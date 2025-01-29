<?php

namespace App\Filament\Resources\SharedPhoneBookAddressesResource\Pages;

use App\Filament\Resources\SharedPhoneBookAddressesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSharedPhoneBookAddresses extends ListRecords
{
    protected static string $resource = SharedPhoneBookAddressesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
