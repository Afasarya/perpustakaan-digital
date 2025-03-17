<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenaltyResource\Pages;
use App\Models\Penalty;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PenaltyResource extends Resource
{
    protected static ?string $model = Penalty::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Library Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Penalty Information')
                            ->schema([
                                Forms\Components\Select::make('book_borrow_id')
                                    ->relationship('bookBorrow', 'id', fn ($query) => $query->with('book', 'user'))
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->user->name} - {$record->book->title} (ID: {$record->id})")
                                    ->disabled(fn ($operation) => $operation === 'edit'),
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->disabled(fn ($operation) => $operation === 'edit'),
                                Forms\Components\TextInput::make('amount')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp'),
                                Forms\Components\TextInput::make('days_late')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'unpaid' => 'Unpaid',
                                        'paid' => 'Paid',
                                    ])
                                    ->required()
                                    ->default('unpaid')
                                    ->reactive()
                                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                                        if ($state === 'paid') {
                                            $set('paid_date', now()->format('Y-m-d'));
                                        } else {
                                            $set('paid_date', null);
                                        }
                                    }),
                                Forms\Components\DatePicker::make('paid_date')
                                    ->visible(fn (Forms\Get $get) => $get('status') === 'paid'),
                                Forms\Components\FileUpload::make('payment_receipt')
                                    ->disk('public')
                                    ->directory('penalties/receipts')
                                    ->visible(fn (Forms\Get $get) => $get('status') === 'paid'),
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
                Tables\Columns\TextColumn::make('bookBorrow.book.title')
                    ->searchable()
                    ->label('Book'),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('days_late')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'paid' => 'success',
                    }),
                Tables\Columns\TextColumn::make('paid_date')
                    ->date()
                    ->placeholder('Not paid yet'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'paid' => 'Paid',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('mark_as_paid')
                    ->label('Mark as Paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Penalty $record) => $record->status === 'unpaid')
                    ->action(function (Penalty $record) {
                        $record->status = 'paid';
                        $record->paid_date = now();
                        $record->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark_as_paid')
                        ->label('Mark as Paid')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                if ($record->status === 'unpaid') {
                                    $record->status = 'paid';
                                    $record->paid_date = now();
                                    $record->save();
                                }
                            }
                        }),
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
            'index' => Pages\ListPenalties::route('/'),
            'create' => Pages\CreatePenalty::route('/create'),
            'edit' => Pages\EditPenalty::route('/{record}/edit'),
        ];
    }
}