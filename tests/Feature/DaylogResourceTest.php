<?php

use App\Filament\Resources\DayLogs\DayLogResource;
use App\Filament\Resources\DayLogs\Pages\CreateDayLog;
use App\Filament\Resources\DayLogs\Pages\EditDayLog;
use App\Filament\Resources\DayLogs\Pages\ListDayLogs;
use App\Models\DayLog;
use App\Models\User;
use Database\Seeders\ShieldSeeder;
use Database\Seeders\TestUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(ShieldSeeder::class);
    $this->seed(TestUserSeeder::class);

    $this->admin = User::role('super_admin')->first();
    $this->fysio = User::role('fysio')->first();

    $this->client = User::role('client')
        ->where('therapist_id', $this->fysio->id)
        ->first();

    $this->otherClient = User::role('client')
        ->where('therapist_id', '!=', $this->fysio->id)
        ->first();

    expect($this->admin)->not->toBeNull();
    expect($this->fysio)->not->toBeNull();
    expect($this->client)->not->toBeNull();
    expect($this->otherClient)->not->toBeNull();
});

// LIST
it('admin can see daylogs in list (first page)', function () {
    $logs = DayLog::latest()->take(5)->get();

    actingAs($this->admin, config('filament.auth.guard'));

    livewire(ListDayLogs::class)
        ->assertOk()
        ->assertCanSeeTableRecords($logs);
});

it('client sees only their own daylogs', function () {
    $ownLogs = DayLog::where('user_id', $this->client->id)->take(3)->get();
    $otherLogs = DayLog::where('user_id', $this->otherClient->id)->take(3)->get();

    actingAs($this->client, config('filament.auth.guard'));

    livewire(ListDayLogs::class)
        ->assertOk()
        ->assertCanSeeTableRecords($ownLogs)
        ->assertCanNotSeeTableRecords($otherLogs);
});

it('fysio sees only logs of their own clients', function () {
    $ownClientLogs = DayLog::whereHas('user', fn ($q) =>
    $q->where('therapist_id', $this->fysio->id)
    )->take(3)->get();

    $otherClientLogs = DayLog::whereHas('user', fn ($q) =>
    $q->where('therapist_id', '!=', $this->fysio->id)
    )->take(3)->get();

    actingAs($this->fysio, config('filament.auth.guard'));

    livewire(ListDayLogs::class)
        ->assertOk()
        ->assertCanSeeTableRecords($ownClientLogs)
        ->assertCanNotSeeTableRecords($otherClientLogs);
});

//
// CREATE TESTS
//

it('client can create a daylog for themselves', function () {
    actingAs($this->client, config('filament.auth.guard'));

    $data = DayLog::factory()->make();

    livewire(CreateDayLog::class)
        ->fillForm([
            'title' => $data->title,
            'notes' => $data->notes,
            'date'  => $data->date,
        ])
        ->call('create')
        ->assertHasNoErrors()
        ->assertNotified();

    assertDatabaseHas(DayLog::class, [
        'user_id' => $this->client->id,
        'title'   => $data->title,
    ]);
});

it('fysio cannot create a daylog for a client that is not theirs', function () {
    actingAs($this->fysio, config('filament.auth.guard'));

    $data = DayLog::factory()->make();

    livewire(CreateDayLog::class)
        ->fillForm([
            'title' => $data->title,
            'notes' => $data->notes,
            'date'  => $data->date,
        ])
        ->call('create')
        ->assertForbidden();
});

//
// DIRECT URL / AUTHORIZATION TESTS
//

it('client cannot access other users daylog via direct url', function () {
    $log = DayLog::where('user_id', $this->otherClient->id)->first();

    actingAs($this->client, config('filament.auth.guard'));

    $this->get(DayLogResource::getUrl('view', ['record' => $log]))
        ->assertNotFound();
});

it('fysio cannot access non-client daylog via direct url', function () {
    $log = DayLog::where('user_id', $this->otherClient->id)->first();

    actingAs($this->fysio, config('filament.auth.guard'));

    $this->get(DayLogResource::getUrl('view', ['record' => $log]))
        ->assertNotFound();
});

//
// UPDATE TESTS
//

it('client can update own daylog', function () {
    $log = DayLog::where('user_id', $this->client->id)->first();

    actingAs($this->client, config('filament.auth.guard'));

    livewire(EditDayLog::class, ['record' => $log->getKey()])
        ->fillForm(['title' => 'Updated Title'])
        ->call('save')
        ->assertHasNoErrors()
        ->assertNotified();

    $log->refresh();

    expect($log->title)->toBe('Updated Title');
});

it('client cannot update other users daylog', function () {
    $log = DayLog::where('user_id', $this->otherClient->id)->first();

    actingAs($this->client, config('filament.auth.guard'));

    $this->get(DayLogResource::getUrl('edit', ['record' => $log]))
        ->assertNotFound();
});
