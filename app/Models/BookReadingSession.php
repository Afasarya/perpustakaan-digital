<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookReadingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'current_page',
        'last_page_read',
        'last_read_at',
    ];

    protected $casts = [
        'last_read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Method untuk menghitung persentase progres membaca
    public function getReadingProgress(): int
    {
        if (!$this->book || !$this->book->pages || $this->book->pages <= 0) {
            return 0;
        }

        return (int) (($this->current_page / $this->book->pages) * 100);
    }
}