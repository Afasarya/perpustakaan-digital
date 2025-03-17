<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'birth_date',
        'status',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
    ];
    
    // Relasi dengan BookBorrow
    public function bookBorrows()
    {
        return $this->hasMany(BookBorrow::class);
    }
    
    // Relasi dengan Penalty
    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }
    
    // Relasi dengan BookRating
    public function bookRatings()
    {
        return $this->hasMany(BookRating::class);
    }
    
    // Relasi dengan BookReadingSession
    public function readingSessions()
    {
        return $this->hasMany(BookReadingSession::class);
    }
    
    // Method untuk cek apakah user memiliki denda yang belum dibayar
    public function hasUnpaidPenalties()
    {
        return $this->penalties()->where('status', 'unpaid')->exists();
    }
    
    // Method untuk mendapatkan total denda yang belum dibayar
    public function getTotalUnpaidPenaltiesAmount()
    {
        return $this->penalties()->where('status', 'unpaid')->sum('amount');
    }
    
    // Method untuk mendapatkan jumlah buku yang sedang dipinjam
    public function getActiveBorrowsCount()
    {
        return $this->bookBorrows()->where('status', 'borrowed')->count();
    }
    
    // Method untuk mendapatkan buku yang sedang dipinjam
    public function getActiveBorrows()
    {
        return $this->bookBorrows()->where('status', 'borrowed')->with('book')->get();
    }
}
