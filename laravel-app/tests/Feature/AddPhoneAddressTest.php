<?php

use App\Filament\Resources\PhoneBookAddressResource;
use App\Models\PhoneBookAddress;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

use function Pest\Livewire\livewire;

beforeEach(function () {
    config(['database.default' => 'sqlite']);
    config(['database.connections.sqlite.database' => ':memory:']);
    
    Artisan::call('migrate');
});

it('auth user can add phone address', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $data = [
        'name' => 'Petras Petrovicius',
        'phone_number' => '+37061234567',
        'user_id' => $user->id,
    ];

    livewire(PhoneBookAddressResource\Pages\CreatePhoneBookAddress::class)
        ->fillForm($data)
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(PhoneBookAddress::class, $data);
});
