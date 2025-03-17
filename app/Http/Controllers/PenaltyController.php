<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PenaltyController extends Controller
{
    public function index()
    {
        $unpaidPenalties = Penalty::where('user_id', Auth::user()->getAuthIdentifier())
            ->where('status', 'unpaid')
            ->with('bookBorrow.book')
            ->get();

        $paidPenalties = Penalty::where('user_id', Auth::user()->getAuthIdentifier())
            ->where('status', 'paid')
            ->with('bookBorrow.book')
            ->latest()
            ->paginate(10);

        $totalUnpaid = $unpaidPenalties->sum('amount');

        return view('penalties.index', compact('unpaidPenalties', 'paidPenalties', 'totalUnpaid'));
    }

    public function uploadReceipt(Request $request, $id)
    {
        $penalty = Penalty::where('id', $id)
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('status', 'unpaid')
            ->firstOrFail();

        $request->validate([
            'payment_receipt' => 'required|image|max:2048',
        ]);

        $path = $request->file('payment_receipt')->store('penalties/receipts', 'public');

        $penalty->payment_receipt = $path;
        $penalty->status = 'paid';
        $penalty->paid_date = now();
        $penalty->save();

        return redirect()->route('penalties.index')->with('success', 'Payment receipt uploaded successfully. Your penalty has been marked as paid.');
    }
}