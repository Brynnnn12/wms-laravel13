<?php

use App\Models\Role;

test('super-admin bisa melihat daftar role', function () {
    $user = createSuperAdmin();
    Role::create(['name' => 'manager', 'guard_name' => 'web']);

    $response = $this
        ->actingAs($user)
        ->get(route('roles.index'));

    $response
        ->assertOk()
        ->assertSeeText('manager');
});

test('super-admin bisa melihat form create role', function () {
    $user = createSuperAdmin();

    $response = $this
        ->actingAs($user)
        ->get(route('roles.create'));

    $response->assertOk();
});

test('super-admin bisa membuat role baru', function () {
    $user = createSuperAdmin();

    $response = $this
        ->actingAs($user)
        ->post(route('roles.store'), [
            'name' => 'operator',
            'guard_name' => 'web',
            'permissions' => [],
        ]);

    $response->assertRedirect(route('roles.index'));
    $this->assertDatabaseHas('roles', ['name' => 'operator']);
});

test('super-admin bisa melihat detail role', function () {
    $user = createSuperAdmin();
    $role = Role::create(['name' => 'supervisor', 'guard_name' => 'web']);

    $response = $this
        ->actingAs($user)
        ->get(route('roles.show', $role));

    $response
        ->assertOk()
        ->assertSeeText('supervisor');
});

test('super-admin bisa melihat form edit role', function () {
    $user = createSuperAdmin();
    $role = Role::create(['name' => 'editor', 'guard_name' => 'web']);

    $response = $this
        ->actingAs($user)
        ->get(route('roles.edit', $role));

    $response
        ->assertOk()
        ->assertSeeText('editor');
});

test('super-admin bisa update role', function () {
    $user = createSuperAdmin();
    $role = Role::create(['name' => 'viewer', 'guard_name' => 'web']);

    $response = $this
        ->actingAs($user)
        ->put(route('roles.update', $role), [
            'name' => 'viewer-updated',
            'guard_name' => 'web',
            'permissions' => [],
        ]);

    $response->assertRedirect(route('roles.index'));
    $this->assertDatabaseHas('roles', ['name' => 'viewer-updated']);
});

test('super-admin bisa hapus role', function () {
    $user = createSuperAdmin();
    $role = Role::create(['name' => 'temp-role', 'guard_name' => 'web']);

    $response = $this
        ->actingAs($user)
        ->delete(route('roles.destroy', $role));

    $response->assertRedirect(route('roles.index'));
    $this->assertDatabaseMissing('roles', ['name' => 'temp-role']);
});
