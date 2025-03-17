<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookBorrowResource\Pages;
use App\Models\BookBorrow;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;

class BookBorrowResource extends Resource
{
    protected static ?string $model = BookBorrow::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';
    protected static ?string $navigationLabel = 'Book Borrows';
    protected static ?string $navigationGroup = 'Library Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Borrow Information')
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('book_id')
                                    ->relationship('book', 'title', fn ($query) => $query->where('stock', '>', 0))
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\DatePicker::make('borrow_date')
                                    ->required()
                                    ->default(now()),
                                Forms\Components\DatePicker::make('due_date')
                                    ->required()
                                    ->default(now()->addDays(7))
                                    ->minDate(fn (Forms\Get $get) => $get('borrow_date')),
                                Forms\Components\DatePicker::make('return_date')
                                    ->minDate(fn (Forms\Get $get) => $get('borrow_date')),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'borrowed' => 'Borrowed',
                                        'returned' => 'Returned',
                                        'lost' => 'Lost',
                                    ])
                                    ->required()
                                    ->default('borrowed')
                                    ->reactive()
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                        if ($state === 'returned' && !$get('return_date')) {
                                            $set('return_date', now()->format('Y-m-d'));
                                        }
                                    }),
                                Forms\Components\Textarea::make('notes')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('book.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('borrow_date')
                    ->date(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->badge()
                    ->color(fn (BookBorrow $record): string => Carbon::parse($record->due_date)->isPast() && $record->status !== 'returned' ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('return_date')
                    ->date()
                    ->placeholder('Not returned yet'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'borrowed' => 'warning',
                        'returned' => 'success',
                        'lost' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'borrowed' => 'Borrowed',
                        'returned' => 'Returned',
                        'lost' => 'Lost',
                    ]),
                Tables\Filters\Filter::make('overdue')
                    ->query(fn ($query) => $query->where('due_date', '<', now())->where('status', 'borrowed'))
                    ->label('Overdue Books'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('return_book')
                    ->label('Return Book')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->visible(fn (BookBorrow $record) => $record->status === 'borrowed')
                    ->action(function (BookBorrow $record) {
                        $record->status = 'returned';
                        $record->return_date = now();
                        $record->save();

                        // Check if book is late
                        if ($record->isOverdue()) {
                            $daysLate = $record->getDaysLate();
                            $penaltyAmount = $daysLate * 1000; // Rp1000 per day

                            // Create penalty record
                            $record->penalty()->create([
                                'user_id' => $record->user_id,
                                'amount' => $penaltyAmount,
                                'days_late' => $daysLate,
                                'status' => 'unpaid',
                                'notes' => "Late return penalty for book: {$record->book->title}",
                            ]);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookBorrows::route('/'),
            'create' => Pages\CreateBookBorrow::route('/create'),
            'edit' => Pages\EditBookBorrow::route('/{record}/edit'),
        ];
    }
}