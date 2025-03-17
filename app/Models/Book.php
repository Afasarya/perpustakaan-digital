<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'author_id',
        'publisher_id',
        'category_id',
        'isbn',
        'publish_year',
        'language',
        'pages',
        'cover_image',
        'file_path',
        'stock',
        'borrowed_count',
        'is_featured',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function bookBorrows(): HasMany
    {
        return $this->hasMany(BookBorrow::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(BookRating::class);
    }

    public function readingSessions(): HasMany
    {
        return $this->hasMany(BookReadingSession::class);
    }

    // Method untuk cek apakah buku tersedia untuk dipinjam
    public function isAvailable(): bool
    {
        return $this->stock > $this->bookBorrows()->where('status', 'borrowed')->count();
    }

    // Method untuk mendapatkan rating rata-rata
    public function getAverageRating(): float
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    // Method untuk mendapatkan jumlah rating
    public function getRatingsCount(): int
    {
        return $this->ratings()->count();
    }
}

