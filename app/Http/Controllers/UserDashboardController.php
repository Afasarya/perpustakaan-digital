<?php

namespace App\Http\Controllers;

use App\Models\BookBorrow;
use App\Models\BookReadingSession;
use App\Models\Penalty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $activeLoans = BookBorrow::where('user_id', $user->getAuthIdentifier())
            ->where('status', 'borrowed')
            ->with('book')
            ->get();
            
        $unpaidPenalties = Penalty::where('user_id', $user->getAuthIdentifier())
            ->where('status', 'unpaid')
            ->with('bookBorrow.book')
            ->get();
            
            $readingSessions = BookReadingSession::where('user_id', $user->getAuthIdentifier())
            ->with('book')
            ->orderBy('last_read_at', 'desc')
            ->take(5)
            ->get();
            
        // Add this line to create $recentReads variable as well
        $recentReads = $readingSessions;
    
        return view('dashboard.index', compact('user', 'activeLoans', 'unpaidPenalties', 'readingSessions', 'recentReads'));
    }

    public function profile()
    {
        return view('dashboard.profile', [
            'user' => Auth::user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $userId = $user->getAuthIdentifier();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only(['name', 'email', 'phone_number', 'address', 'birth_date']);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('users/profile-pictures', 'public');
            $data['profile_picture'] = $path;
        }
        
        // Update user using DB facade
        DB::table('users')->where('id', $userId)->update($data);

        return redirect()->route('dashboard.profile')->with('success', 'Profile updated successfully.');
    }

    public function changePassword()
    {
        return view('dashboard.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $userId = $user->getAuthIdentifier();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }

        // Update password using DB facade
        DB::table('users')->where('id', $userId)->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('dashboard.change-password')->with('success', 'Password changed successfully.');
    }

    public function readingHistory()
    {
        $readingSessions = BookReadingSession::where('user_id', Auth::user()->getAuthIdentifier())
            ->with('book')
            ->orderBy('last_read_at', 'desc')
            ->paginate(10);

        return view('dashboard.reading-history', compact('readingSessions'));
    }

    public function borrowHistory()
    {
        $borrows = BookBorrow::where('user_id', Auth::user()->getAuthIdentifier())
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.borrow-history', compact('borrows'));
    }

    public function penaltyHistory()
    {
        $penalties = Penalty::where('user_id', Auth::user()->getAuthIdentifier())
            ->with('bookBorrow.book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.penalty-history', compact('penalties'));
    }
}