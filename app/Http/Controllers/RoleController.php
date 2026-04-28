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
use Spatie\Permission\Exceptions\GuardDoesNotMatch;
use Throwable;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
    ) {}

    #[Authorize('viewAny', Role::class)]
    public function index(): View
    {
        $roles = $this->roleService->paginate();

        $title = 'Hapus Role!';
        $text = "Apakah Anda yakin ingin menghapus role ini?";
        confirmDelete($title, $text);


        return view('dashboard.roles.index', compact('roles'));
    }

    #[Authorize('create', Role::class)]
    public function create(): View
    {
        $permissions = $this->roleService->permissionsByGuard();

        return view('dashboard.roles.create', compact('permissions'));
    }

    #[Authorize('create', Role::class)]
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        try {
            $this->roleService->create($request->validated());
            toast('Role berhasil ditambahkan!', 'success');

            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            toast('Terjadi kesalahan saat menambahkan role!', 'error');

            return back()->withInput();
        }
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
        $permissions = $this->roleService->permissionsByGuard();

        return view('dashboard.roles.edit', compact('role', 'permissions'));
    }

    #[Authorize('update', 'role')]
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        try {
            $this->roleService->update($role, $request->validated());
            toast('Role berhasil diperbarui!', 'success');

            return redirect()->route('roles.index');
        } catch (GuardDoesNotMatch $exception) {
            report($exception);
            toast('Guard role dan permission harus sama (contoh: web ke web).', 'error');

            return back()->withInput();
        } catch (\Exception $e) {
            report($e);
            toast('Terjadi kesalahan saat memperbarui role!', 'error');

            return back()->withInput();
        }
    }

    #[Authorize('delete', 'role')]
    public function destroy(Role $role): RedirectResponse
    {
        try {
            $this->roleService->delete($role);
            toast('Role berhasil dihapus!', 'success');

            return redirect()->route('roles.index');
        } catch (ValidationException $exception) {
            $message = collect($exception->errors())->flatten()->first() ?? 'Terjadi kesalahan saat menghapus role!';
            toast($message, 'error');

            return back()->withErrors($exception->errors());
        } catch (Throwable $e) {
            report($e);
            toast('Terjadi kesalahan saat menghapus role!', 'error');

            return back();
        }
    }
}
