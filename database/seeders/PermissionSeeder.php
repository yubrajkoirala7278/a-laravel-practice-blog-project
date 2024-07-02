<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['create_blogs', 'edit_blogs', 'delete_blogs', 'show_blogs', 
        'create_news', 'edit_news', 'delete_news', 'show_news', 'create_users', 'edit_users', 'delete_users', 'show_users'];
        foreach ($permissions as $key => $permission) {
           Permission::create([
            'name'=>$permission
           ]);
        }
    }
}
