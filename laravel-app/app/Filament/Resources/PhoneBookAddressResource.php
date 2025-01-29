<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhoneBookAddressResource\Pages;
use App\Models\PhoneBookAddress;
use App\Models\SharedPhoneBookAddresses;
use App\Rules\LithuanianPhoneNumber;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PhoneBookAddressResource extends Resource
{
    protected static ?string $model = PhoneBookAddress::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getTitle(): string
    {
        return 'Shared Phone Books';  // Singular title
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->unique()
                    ->required(),
                TextInput::make('phone_number')
                    ->required()
                    ->unique()
                    ->rule(new LithuanianPhoneNumber()),
                Hidden::make('user_id')
                    ->default(fn() => Auth::user()->id),
            ]);
    }

    public static function table(Table $table): Table
    {
        $userId = Auth::user()->id;
        $shared = SharedPhoneBookAddresses::where('shared_with_id', '=', $userId)->pluck('user_id')->toArray();
        $shared[] = $userId;
        
        return $table
            ->query(
                PhoneBookAddress::whereIn('user_id', $shared),
            )
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('phone_number'),
                TextColumn::make('shared_address')
                    ->default(fn($record) => $record->user_id == $userId ? 'false' : 'true')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'false' => 'success',
                        'true' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPhoneBookAddresses::route('/'),
            'create' => Pages\CreatePhoneBookAddress::route('/create'),
            'edit' => Pages\EditPhoneBookAddress::route('/{record}/edit')
        ];
    }
}
