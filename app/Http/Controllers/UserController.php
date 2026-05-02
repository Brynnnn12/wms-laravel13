<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $service
    ) {
    }

    #[Authorize('viewAny', User::class)]
    public function index(): View
    {
        $users = $this->service->paginate(10);

        confirmDelete(
            'Hapus User!',
            'Apakah Anda yakin ingin menghapus user ini?'
        );

        return view('dashboard.users.index', compact('users'));
    }

    #[Authorize('create', User::class)]
    public function create(): View
    {
        $roles = Role::orderBy('name')->get();

        return view('dashboard.users.create', compact('roles'));
    }

    #[Authorize('create', User::class)]
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        toast('User berhasil ditambahkan!', 'success');

        return redirect()->route('users.index');
    }

    #[Authorize('view', 'user')]
    public function show(User $user): View
    {
        return view('dashboard.users.show', compact('user'));
    }

    #[Authorize('update', 'user')]
    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->get();

        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    #[Authorize('update', 'user')]
    public function update(
        UpdateUserRequest $request,
        User $user
    ): RedirectResponse {
        $this->service->update($user, $request->validated());

        toast('User berhasil diperbarui!', 'success');

        return redirect()->route('users.index');
    }

    #[Authorize('delete', 'user')]
    public function destroy(User $user): RedirectResponse
    {
        try {
            $this->service->delete($user);

            toast('User berhasil dihapus!', 'success');
        } catch (DomainException $e) {
            toast($e->getMessage(), 'error');
        }

        return redirect()->route('users.index');
    }

    #[Authorize('delete', User::class)]
    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            toast('Tidak ada user yang dipilih untuk dihapus.', 'warning');

            return redirect()->route('users.index');
        }

        try {
            $this->service->bulkDelete($ids);

            toast('User berhasil dihapus!', 'success');
        } catch (DomainException $e) {
            toast($e->getMessage(), 'error');
        }

        return redirect()->route('users.index');
    }
}
