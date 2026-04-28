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
use Spatie\Permission\Exceptions\GuardDoesNotMatch;
use Throwable;

class PermissionController extends Controller
{
    public function __construct(
        private readonly PermissionService $permissionService,
    ) {
    }
    #[Authorize('viewAny', Permission::class)]
    public function index(): View
    {
        $permissions = $this->permissionService->paginate();

        $title = 'Hapus Permission!';
        $text = "Apakah Anda yakin ingin menghapus permission ini?";
        confirmDelete($title, $text);


        return view('dashboard.permissions.index', compact('permissions'));
    }

    #[Authorize('create', Permission::class)]
    public function create(): View
    {
        // Menggunakan Service untuk mendapatkan data role yang sudah di-group
        $roles = $this->permissionService->rolesByGuard();

        return view('dashboard.permissions.create', compact('roles'));
    }
    #[Authorize('create', Permission::class)]
    public function store(StorePermissionRequest $request): RedirectResponse
    {
        try {
            // dd($request->validated());
            $this->permissionService->create($request->validated());
            toast('Permission berhasil ditambahkan!', 'success');

            return redirect()->route('permissions.index');
        } catch (\Exception $e) {
            toast('Terjadi kesalahan saat menambahkan permission!', 'error');

            return back()->withInput();
        }
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
        $roles = $this->permissionService->rolesByGuard();

        return view('dashboard.permissions.edit', compact('permission', 'roles'));
    }

    #[Authorize('update', 'permission')]
    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        try {
            $this->permissionService->update($permission, $request->validated());
            toast('Permission berhasil diperbarui!', 'success');

            return redirect()->route('permissions.index');
        } catch (GuardDoesNotMatch $exception) {
            report($exception);
            toast('Guard permission dan role harus sama (contoh: web ke web).', 'error');

            return back()->withInput();
        } catch (\Exception $e) {
            report($e);
            toast('Terjadi kesalahan saat memperbarui permission!', 'error');

            return back()->withInput();
        }
    }

    #[Authorize('delete', 'permission')]
    public function destroy(Permission $permission): RedirectResponse
    {
        try {
            $this->permissionService->delete($permission);
            toast('Permission berhasil dihapus!', 'success');

            return redirect()->route('permissions.index');
        } catch (ValidationException $exception) {
            $message = collect($exception->errors())->flatten()->first() ?? 'Terjadi kesalahan saat menghapus permission!';
            toast($message, 'error');

            return back()->withErrors($exception->errors());
        } catch (Throwable $e) {
            report($e);
            toast('Terjadi kesalahan saat menghapus permission!', 'error');

            return back();
        }
    }
}
