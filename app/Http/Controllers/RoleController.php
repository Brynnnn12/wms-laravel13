<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
    ) {}

    #[Authorize('viewAny', Role::class)]
    public function index(): View
    {
        $roles = $this->roleService->paginate();

        return view('dashboard.roles.index', compact('roles'));
    }

    #[Authorize('create', Role::class)]
    public function create(): View
    {
        $permissions = $this->roleService->permissions();

        return view('dashboard.roles.create', compact('permissions'));
    }

    #[Authorize('create', Role::class)]
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $this->roleService->create($request->validated());

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }

    #[Authorize('view', 'role')]
    public function show(Role $role): View
    {
        $role->load(['permissions:id,name'])->loadCount('users');

        return view('dashboard.roles.show', compact('role'));
    }

    #[Authorize('update', 'role')]
    public function edit(Role $role): View
    {
        $role->load('permissions:id,name');
        $permissions = $this->roleService->permissions();

        return view('dashboard.roles.edit', compact('role', 'permissions'));
    }

    #[Authorize('update', 'role')]
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $this->roleService->update($role, $request->validated());

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    #[Authorize('delete', 'role')]
    public function destroy(Role $role): RedirectResponse
    {
        try {
            $this->roleService->delete($role);

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role berhasil dihapus.');
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors());
        }
    }
}
