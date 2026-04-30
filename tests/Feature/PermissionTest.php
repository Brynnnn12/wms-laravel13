<?php

use App\Models\Permission;

test('super-admin bisa melihat daftar permission', function () {
    $user = createSuperAdmin();
    Permission::create(['name' => 'view-users', 'guard_name' => 'web']);

    $response = $this
        ->actingAs($user)
        ->get(route('permissions.index'));

    $response
        ->assertOk()
        ->assertSeeText('view-users');
});

test('super-admin bisa melihat form create permission', function () {
    $user = createSuperAdmin();

    $response = $this
        ->actingAs($user)
        ->get(route('permissions.create'));

    $response->assertOk();
});

test('super-admin bisa membuat permission baru', function () {
    $user = createSuperAdmin();

    $response = $this
        ->actingAs($user)
        ->post(route('permissions.store'), [
            'name' => 'create-users',
            'guard_name' => 'web',
            'roles' => [],
        ]);

    $response->assertRedirect(route('permissions.index'));
    $this->assertDatabaseHas('permissions', ['name' => 'create-users']);
});

test('super-admin bisa melihat detail permission', function () {
    $user = createSuperAdmin();
    $permission = Permission::create(['name' => 'edit-users', 'guard_name' => 'web']);

    $response = $this
        ->actingAs($user)
        ->get(route('permissions.show', $permission));

    $response
        ->assertOk()
        ->assertSeeText('edit-users');
});

test('super-admin bisa melihat form edit permission', function () {
    $user = createSuperAdmin();
    $permission = Permission::create(['name' => 'delete-users', 'guard_name' => 'web']);

    $response = $this
        ->actingAs($user)
        ->get(route('permissions.edit', $permission));

    $response
        ->assertOk()
        ->assertSeeText('delete-users');
});

test('super-admin bisa update permission', function () {
    $user = createSuperAdmin();
    $permission = Permission::create(['name' => 'manage-users', 'guard_name' => 'web']);

    $response = $this
        ->actingAs($user)
        ->put(route('permissions.update', $permission), [
            'name' => 'manage-users-updated',
            'guard_name' => 'web',
            'roles' => [],
        ]);

    $response->assertRedirect(route('permissions.index'));
    $this->assertDatabaseHas('permissions', ['name' => 'manage-users-updated']);
});

test('super-admin bisa hapus permission', function () {
    $user = createSuperAdmin();
    $permission = Permission::create(['name' => 'temp-permission', 'guard_name' => 'web']);

    $response = $this
        ->actingAs($user)
        ->delete(route('permissions.destroy', $permission));

    $response->assertRedirect(route('permissions.index'));
    $this->assertDatabaseMissing('permissions', ['name' => 'temp-permission']);
});
