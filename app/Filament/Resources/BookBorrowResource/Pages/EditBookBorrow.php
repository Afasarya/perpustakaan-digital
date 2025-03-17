<?php

namespace App\Filament\Resources\BookBorrowResource\Pages;

use App\Filament\Resources\BookBorrowResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookBorrow extends EditRecord
{
    protected static string $resource = BookBorrowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
