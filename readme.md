# SimplePermission
SimplePermission is a simple authorization package for Laravel.
It is designed with Laravel 10, but may work with other versions.
With this package, Roles and Permissions are added to your Laravel application, so you can easily manage authorization.

## Installation
1. Install the package via composer:
    ```bash
    composer require lcloss/simple-permission
    ```
2. Publish the config file:
    ```bash
    php artisan vendor:publish --provider="Lcloss\SimplePermission\SimplePermissionServiceProvider"
    ```
   
3. Compile assets:
    ```bash
    npm run build
    ```
   
4. Run the migrations:
    ```bash
    php artisan migrate
    ```
   
5. Add the `HasRoles` trait to your `User` model:
    ```php
    use Lcloss\SimplePermission\Models\Traits\HasRoles;
   
    class User extends Authenticatable
    {
        use HasRoles;
    }
    ```

6. Add the `AuthGates` middleware to your `app\Http\Kernel.php` file:
    ```php
    protected $middlewareGroups = [
        'web' => [
            // ...
            \Lcloss\SimplePermission\Http\Middleware\AuthGates::class,
        ],

        'api' => [
            // ...
            \Lcloss\SimplePermission\Http\Middleware\AuthGates::class,
        ],
    ];
    ```
   
7. Add the `role` to the `user`
If you are using Laravel Fortify, you can chane App\Actions\Fortify\CreateNewUser.php file:
    ```php
    use Lcloss\SimplePermission\Models\Role;
   
    class CreateNewUser
    {
        // ...
        public function create(array $input)
        {
            // ...
            // If you are getting the first and last names:
            $name = trim($input['first_name'] . ' ' . $input['last_name']);
   
            DB::beginTransaction();
   
            $user = User::create([
                'name'      => $name,
                'email'     => $input['email'],
                'password'  => Hash::make($input['password']),
            ]);

            $countUsers = User::count();
   
            if ( $countUsers == 1 ) {
                $role = Role::where('slug', 'sysadmin')->first();
            } else {
                $role = Role::where('slug', 'user')->first();
            }
            $user->roles()->attach($role);

            DB::commit();
   
            return $user;
        }
    }
    ```
   With the configuration above, the first user created will be a `sysadmin`, and the others will be `user`.

8. Other considerations

Check package blade files. 
You can use your own blade files by replacing the blade file names in `config/simple-permission.php` file.
Do not forget to:

a) Add @liwewireStyles() and @livewireScripts() to your layout file.
b) Add @yield('scripts') to your layout file.
c) Add @yield('modals') to the end of body, on the layout file.

## Configuration

You can change this package's configuration by editing the `config/simple-permission.php` file.

## Database Seeder

This package comes with a database seeder that creates the default roles and permissions.
You can run it with the following command:

```bash
php artisan db:seed --class=SimplePermissionSeeder
```
Or, you can run individual seeders:

```bash
php artisan db:seed --class=SimplePermissionRoleSeeder
php artisan db:seed --class=SimplePermissionPermissionSeeder
```

## Roles and Permissions

### Roles

This package cames with default roles: 'sysadmin', 'admin', 'premium-user', 'user' and 'free-user'.

Each role has a single identification `slug` and a `level` to determine the role's hierarchy.
Roles with `level` 1 are the highest level roles, and roles with `level` 300 are the lowest level roles.
All roles with `level` 1 get access to all permissions.

You can customize the roles by editing the `database\seeders\SimplePermissionRoleSeeder.php` file.

### Permissions

Permissions follows the structure of `access`, `list` and CRUD operations (`create`, `read`, `update` and `delete`).
Tipically `access` permisison is used to allow access to a resource, `list` permission is used to allow listing the resource, and CRUD permissions are used to allow operations on the resource.

A permission is composed by an `object` and an `action`, delimited by a `_` character.
An object is a resource, like `users`, `roles`, `permissions`, `posts` or `comments`.
An action is an operation on the resource, like `access`, `list`, `create`, `read`, `update` or `delete`.

So, the permission `users_create` determine if the user can create users, and the permission `users_list` determine if the user can list users.

You can customize the permissions by editing the `database\seeders\SimplePermissionPermissionSeeder.php` file.

To protect a route, you can use the `can` middleware:
```php
Route::get('/users', [UserController::class, 'index'])->middleware('can:users_list');
```

To protect a controller method, you can use the `can` middleware:
```php
use Gate;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('users_list');
        
        // ...
    }
}
```

To protect a part of a view, you can use the `@can` directive:
```blade
@can('users_list')
    <a href="{{ route('users.index') }}">Users</a>
@endcan
```
## TODOs

- [ ] Add tests
- [ ] Add artisan commands
