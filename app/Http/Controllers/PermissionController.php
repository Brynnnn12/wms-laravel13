<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function __construct(
        private readonly PermissionService $permissionService,
    ) {}

    #[Authorize('viewAny', Permission::class)]
    public function index(): View
    {
        $permissions = $this->permissionService->paginate();

        return view('dashboard.permissions.index', compact('permissions'));
    }

    #[Authorize('create', Permission::class)]
    public function create(): View
    {
        $roles = $this->permissionService->roles();

        return view('dashboard.permissions.create', compact('roles'));
    }

    #[Authorize('create', Permission::class)]
    public function store(StorePermissionRequest $request): RedirectResponse
    {
        $this->permissionService->create($request->validated());

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission berhasil ditambahkan.');
    }

    #[Authorize('view', 'permission')]
    public function show(Permission $permission): View
    {
        $permission->load(['roles:id,name'])->loadCount(['roles', 'users']);

        return view('dashboard.permissions.show', compact('permission'));
    }

    #[Authorize('update', 'permission')]
    public function edit(Permission $permission): View
    {
        $permission->load('roles:id,name');
        $roles = $this->permissionService->roles();

        return view('dashboard.permissions.edit', compact('permission', 'roles'));
    }

    #[Authorize('update', 'permission')]
    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $this->permissionService->update($permission, $request->validated());

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }

    #[Authorize('delete', 'permission')]
    public function destroy(Permission $permission): RedirectResponse
    {
        try {
            $this->permissionService->delete($permission);

            return redirect()
                ->route('permissions.index')
                ->with('success', 'Permission berhasil dihapus.');
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors());
        }
    }
}
