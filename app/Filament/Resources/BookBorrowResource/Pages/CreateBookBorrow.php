<?php

namespace App\Filament\Resources\BookBorrowResource\Pages;

use App\Filament\Resources\BookBorrowResource;
use App\Models\Book;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateBookBorrow extends CreateRecord
{
    protected static string $resource = BookBorrowResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = User::find($data['user_id']);
        $book = Book::find($data['book_id']);

        // Check if user has unpaid penalties
        if ($user->hasUnpaidPenalties()) {
            Notification::make()
                ->title('Cannot borrow book')
                ->body('This user has unpaid penalties. Please settle the penalties first.')
                ->danger()
                ->send();

            $this->halt();
        }

        // Check if book is available
        if (!$book->isAvailable()) {
            Notification::make()
                ->title('Cannot borrow book')
                ->body('This book is not available for borrowing.')
                ->danger()
                ->send();

            $this->halt();
        }

        // Increment borrowed count
        $book->borrowed_count++;
        $book->save();

        return $data;
    }
}
    
