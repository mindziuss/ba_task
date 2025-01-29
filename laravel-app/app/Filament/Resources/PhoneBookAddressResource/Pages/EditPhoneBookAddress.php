<?php

namespace App\Filament\Resources\PhoneBookAddressResource\Pages;

use App\Filament\Resources\PhoneBookAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhoneBookAddress extends EditRecord
{
    protected static string $resource = PhoneBookAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
