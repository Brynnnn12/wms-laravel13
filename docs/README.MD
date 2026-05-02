php artisan make:model nama -a
php artisan make:class Services/nama
php artisan make:class Repositories/nama
php artisan migrate:fresh --seed

php artisan db:seed --class=PermissionSeeder
