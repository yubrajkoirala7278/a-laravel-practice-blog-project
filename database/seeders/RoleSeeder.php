<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $roles=['super_admin','admin','blog_manager','news_manager'];
       foreach ($roles as $key => $role) {
       Role::create([
        'name'=>$role
       ]);
       }
    }
}
