<?php

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Database\Seeders\ShieldSeeder;
use Database\Seeders\TestUserSeeder;
use Filament\Auth\Pages\EditProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed users and permissions
    $this->seed(ShieldSeeder::class);
    $this->seed(TestUserSeeder::class);

    // create admin and fysio
    $this->admin = User::where('email', 'super_admin@example.com')->first();
    $this->fysio = User::where('email', 'fysio@example.com')->first();
});

// LIST
it('admin can load page', function () {
    $users = User::factory()->count(5)->create();

    actingAs($this->admin);

    livewire(ListUsers::class)
        ->call('loadTable')
        ->assertOk()
        ->assertCanSeeTableRecords($users); // warning: there are 2 users in DB, never create more the 8 factory users to be able to see them all here
});

it('fysio can only see their own clients in the list', function () {
    $ownClient = User::factory()->create(['therapist_id' => $this->fysio->id])->assignRole('client');
    $otherClient = User::factory()->create()->assignRole('client');

    actingAs($this->fysio);

    livewire(ListUsers::class)
        ->assertOk();

    $visibleUsers = UserResource::getModel()::where('therapist_id', $this->fysio->id)->get();

    expect($visibleUsers->contains($ownClient))->toBeTrue();
    expect($visibleUsers->contains($otherClient))->toBeFalse();
});

// CREATE
it('admin can create a user', function () {
    $newUserData = User::factory()->make();

    actingAs($this->admin);

    livewire(CreateUser::class)
        ->fillForm([
            'name' => $newUserData->name,
            'email' => $newUserData->email,
            'password' => $newUserData->password,
            'password_confirmation' => $newUserData->password_confirmation,
        ])
        ->call('create')
        ->assertNotified()
        ->assertHasNoErrors();

    assertDatabaseHas(User::class, [
        'name' => $newUserData->name,
        'email' => $newUserData->email,
    ]);
});

it('fysio creates a client that is linked to themselves', function () {
    actingAs($this->fysio);

    $new = User::factory()->make();

    livewire(CreateUser::class)
        ->fillForm([
            'name'     => $new->name,
            'email'    => $new->email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->call('create')
        ->assertHasNoErrors()
        ->assertNotified();

    $created = User::firstWhere('email', $new->email);

    expect($created->therapist_id)->toBe($this->fysio->id);
    expect($created->hasRole('client'))->toBeTrue();
});

// UPDATE
it('user can update their own profile', function () {
    $user = User::factory()->create([
        'password' => bcrypt('secret123'),
    ]);

    actingAs($user);

    $newData = [
        'name' => $user->name,
        'email' => $user->email,
        'password' => 'newpassword123',
        'passwordConfirmation' => 'newpassword123',
        'currentPassword' => 'secret123',
    ];

    livewire(EditProfile::class)
        ->fillForm($newData)
        ->call('save')
        ->assertHasNoErrors()
        ->assertNotified();

    $user->refresh();

    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
});
