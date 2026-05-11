<?php

namespace Tests\Feature\JenisBarang;

use App\Models\JenisBarang;
use App\Models\Barang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function Pest\Laravel\{get, post, put, delete};
use Mockery;

/**
 * Konfigurasi Dasar
 */
beforeEach(function () {

    // Disable CSRF middleware for testing
    $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

    // 2. MOCK SWEETALERT (Agar tidak Error 500 karena fungsi toast/confirmDelete)
    app()->bind('alert', function () {
        $mock = Mockery::mock();
        $mock->shouldReceive('toast')->andReturn($mock);
        $mock->shouldReceive('confirmDelete')->andReturn($mock);
        return $mock;
    });

    // 3. DEFINISIKAN PERMISSIONS (Sesuai dot notation di Policy Anda)
    $this->perms = [
        'view' => 'jenis barang.view',
        'create' => 'jenis barang.create',
        'update' => 'jenis barang.update',
        'delete' => 'jenis barang.delete',
    ];
});

/**
 * SKENARIO 1: SUPER ADMIN (FULL ACCESS)
 */
describe('Akses Super Admin', function () {
    
    beforeEach(function () {
        $this->admin = createSuperAdmin();
        // Berikan semua permission ke role super-admin
        giveRolePermissions('super-admin', array_values($this->perms));
        $this->actingAs($this->admin);
    });

    it('bisa melihat daftar jenis barang', function () {
        JenisBarang::factory()->count(3)->create();
        
        get(route('jenis-barang.index'))
            ->assertOk()
            ->assertViewHas('jenisBarangs');
    });

    it('bisa melihat detail jenis barang', function () {
        $jenis = JenisBarang::factory()->create();
        
        get(route('jenis-barang.show', $jenis))
            ->assertOk()
            ->assertViewHas('jenis_barang');
    });

    it('bisa menambah jenis barang baru', function () {
        $data = ['jenis_barang' => 'Elektronik'];

        post(route('jenis-barang.store'), $data)
            ->assertRedirect(route('jenis-barang.index'));

        $this->assertDatabaseHas('jenis_barangs', $data);
    });

    it('bisa mengupdate jenis barang', function () {
        $jenis = JenisBarang::factory()->create(['jenis_barang' => 'Lama']);
        $newData = ['jenis_barang' => 'Baru'];

        put(route('jenis-barang.update', $jenis), $newData)
            ->assertRedirect(route('jenis-barang.index'));

        $this->assertDatabaseHas('jenis_barangs', $newData);
    });

    it('bisa menghapus jenis barang', function () {
        $jenis = JenisBarang::factory()->create();

        delete(route('jenis-barang.destroy', $jenis))
            ->assertRedirect(route('jenis-barang.index'));

        $this->assertDatabaseMissing('jenis_barangs', ['id' => $jenis->id]);
    });

    it('bisa bulk delete jenis barang', function () {
        $items = JenisBarang::factory()->count(2)->create();
        $ids = $items->pluck('id')->toArray();

        delete(route('jenis-barang.bulk-delete'), ['ids' => $ids])
            ->assertRedirect(route('jenis-barang.index'));

        foreach ($ids as $id) {
            $this->assertDatabaseMissing('jenis_barangs', ['id' => $id]);
        }
    });
});

/**
 * SKENARIO 2: NON-ADMIN (RESTRICTED)
 * Memastikan Policy bekerja dan mengembalikan 403
 */
describe('Akses Non-Admin (Terbatasi)', function () {

    it('Keuangan sama sekali tidak bisa mengakses jenis barang (403)', function () {
        $keuangan = createKeuangan();
        $this->actingAs($keuangan);

        get(route('jenis-barang.index'))->assertStatus(403);
        post(route('jenis-barang.store'), ['jenis_barang' => 'Ilegal'])->assertStatus(403);
    });

    it('Inventaris tidak bisa menambah atau menghapus jenis barang (403)', function () {
        $inventaris = createInventaris();
        // Berikan HANYA permission view (jika di sistem Anda inventaris boleh lihat)
        // giveRolePermissions('inventaris', [$this->perms['view']]);
        
        $this->actingAs($inventaris);
        $jenis = JenisBarang::factory()->create();

        // Coba Create
        post(route('jenis-barang.store'), ['jenis_barang' => 'Test'])->assertStatus(403);
        // Coba Delete
        delete(route('jenis-barang.destroy', $jenis))->assertStatus(403);
    });
});

/**
 * SKENARIO 3: DATA INTEGRITY & ERROR HANDLING
 */
test('Gagal menghapus jenis barang yang masih digunakan oleh produk lain', function () {
    $admin = createSuperAdmin();
    giveRolePermissions('super-admin', array_values($this->perms));
    
    $jenis = JenisBarang::factory()->create();
    // Simulasi data terikat di tabel barang
    Barang::factory()->create(['jenis_barang_id' => $jenis->id]);

    $this->actingAs($admin)
        ->delete(route('jenis-barang.destroy', $jenis))
        ->assertRedirect(route('jenis-barang.index'));

    // Data harus tetap ada karena diproteksi try-catch di Controller & Foreign Key
    $this->assertDatabaseHas('jenis_barangs', ['id' => $jenis->id]);
});