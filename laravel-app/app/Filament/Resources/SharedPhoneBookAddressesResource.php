<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SharedPhoneBookAddressesResource\Pages;
use App\Filament\Resources\SharedPhoneBookAddressesResource\RelationManagers;
use App\Models\SharedPhoneBookAddresses;
use App\Models\User;
use Filament\Forms;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SharedPhoneBookAddressesResource extends Resource
{
    protected static ?string $model = SharedPhoneBookAddresses::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function label(): string
    {
        return 'Add New Custom Record'; // Custom name for the resource in the sidebar
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        $userId = Auth::user()->id;
        $sharedTo = SharedPhoneBookAddresses::where('user_id', '=', $userId)
            ->pluck('shared_with_id')
            ->toArray();

        return $table
            ->query(
                SharedPhoneBookAddresses::where('shared_with_id', '=', $userId)->orWhere('user_id', '=', $userId)
            )
            ->columns([
                TextColumn::make('sharedWith.name')
                    ->label('Shared To'),
                TextColumn::make('user.name')
                    ->label('Shared From'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Action::make('share_phone_book')
                    ->label('Share Phone Book')
                    ->form([
                        Select::make('user')
                            ->options(User::whereNot('id', '=', Auth::user()->id)
                                ->where(function ($query) use ($sharedTo) {
                                    $query->whereNotIn('id', $sharedTo);
                                })
                                ->pluck('name', 'id')
                            ),
                    ])
                    ->action(function (array $data) {
                        $shareWithId = (int) $data['user'];

                        SharedPhoneBookAddresses::create([
                            'user_id' => Auth::user()->id,
                            'shared_with_id' => $shareWithId,
                        ]);

                        return;
                    })
                    ->color('success'),
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
            'index' => Pages\ListSharedPhoneBookAddresses::route('/'),
            'create' => Pages\CreateSharedPhoneBookAddresses::route('/create'),
            'edit' => Pages\EditSharedPhoneBookAddresses::route('/{record}/edit'),
        ];
    }
}
