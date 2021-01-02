<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id'                => 1,
            'name'              => 'admins-list',
            'display_name'      => 'عرض المستخدمين',
            'description'       => 'صلاحية عرض المستخدمين '
        ]);
        
        DB::table('roles')->insert([
            'id'                => 2,
            'name'              => 'admins-create',
            'display_name'      => ' إنشاء المستخدمين',
            'description'       => 'صلاحية إنشاء المستخدمين'
        ]);

        DB::table('roles')->insert([
            'id'                => 3,
            'name'              => 'admins-edit',
            'display_name'      => ' تعديل المستخدمين',
            'description'       => 'صلاحية تعديل المستخدمين'
        ]);

        DB::table('roles')->insert([
            'id'                => 4,
            'name'              => 'admins-delete',
            'display_name'      => ' حذف المستخدمين',
            'description'       => 'صلاحية حذف المستخدمين'
        ]);
    }
    
}
