php artisan make:model nama -a
php artisan make:class Services/nama
php artisan make:class Repositories/nama
php artisan migrate:fresh --seed

php artisan db:seed --class=PermissionSeeder

php artisan make:model Barang
php artisan make:controller BarangController --resource
php artisan make:request Barang/StoreBarangRequest
php artisan make:request Barang/UpdateBarangRequest
php artisan make:policy BarangPolicy --model=Barang

✔ migration selesai
✔ model relasi selesai
✔ request validasi
✔ repository CRUD
✔ service logic harga_total
✔ controller resource
✔ policy auth
✔ blade index/create/edit/show
