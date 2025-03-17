<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Book permissions
            'view books',
            'create books',
            'edit books',
            'delete books',
            
            // Author permissions
            'view authors',
            'create authors',
            'edit authors',
            'delete authors',
            
            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            
            // Publisher permissions
            'view publishers',
            'create publishers',
            'edit publishers',
            'delete publishers',
            
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Borrow permissions
            'view borrows',
            'create borrows',
            'edit borrows',
            'delete borrows',
            'return books',
            
            // Penalty permissions
            'view penalties',
            'create penalties',
            'edit penalties',
            'delete penalties',
            'pay penalties',
            
            // Settings permissions
            'view settings',
            'edit settings',
            
            // Reports permissions
            'view reports',
            'create reports',
            'export reports',
            
            // Reading permission
            'read books',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign created permissions
        
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
        
        // Librarian role (can manage books, borrows, but not users or settings)
        $librarianRole = Role::create(['name' => 'librarian']);
        $librarianRole->givePermissionTo([
            'view books', 'create books', 'edit books', 'delete books',
            'view authors', 'create authors', 'edit authors', 'delete authors',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view publishers', 'create publishers', 'edit publishers', 'delete publishers',
            'view borrows', 'create borrows', 'edit borrows', 'delete borrows', 'return books',
            'view penalties', 'create penalties', 'edit penalties', 'delete penalties',
            'view reports', 'create reports', 'export reports',
        ]);
        
        // User role (regular user)
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view books',
            'read books',
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');
        
        // Create librarian user
        $librarian = User::create([
            'name' => 'Librarian',
            'email' => 'librarian@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $librarian->assignRole('librarian');
        
        // Create regular user
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('user');
    }
}
