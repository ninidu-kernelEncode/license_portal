<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AssignAllPermissionsToUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::find(1);

        if (!$user) {
            $this->command->error('User with ID 1 not found.');
            return;
        }

        $permissions = Permission::all();

        $user->syncPermissions($permissions);

        $this->command->info('All permissions assigned to user ID 1.');
    }
}
