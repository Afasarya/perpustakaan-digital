<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BookBorrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function penalty(): HasOne
    {
        return $this->hasOne(Penalty::class);
    }

    // Method untuk cek apakah peminjaman sudah terlambat
    public function isOverdue(): bool
    {
        if ($this->status === 'returned') {
            return false;
        }

        return now()->greaterThan($this->due_date);
    }

    // Method untuk menghitung jumlah hari terlambat
    public function getDaysLate(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        if ($this->status === 'returned' && $this->return_date) {
            return $this->return_date->diffInDays($this->due_date);
        }

        return now()->diffInDays($this->due_date);
    }
}
