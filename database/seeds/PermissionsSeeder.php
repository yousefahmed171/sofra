<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'id'                => 1,
            'name'              => 'admins-list',
            'display_name'      => 'عرض المستخدمين',
            'description'       => 'صلاحية عرض المستخدمين ',
            'routes'            => 'admin.index'
        ]);
        
        DB::table('permissions')->insert([
            'id'                => 2,
            'name'              => 'admins-create',
            'display_name'      => ' إنشاء المستخدمين',
            'description'       => 'صلاحية إنشاء المستخدمين',
            'routes'            => 'admin.create,admin.store'
        ]);

        DB::table('permissions')->insert([
            'id'                => 3,
            'name'              => 'admins-edit',
            'display_name'      => ' تعديل المستخدمين',
            'description'       => 'صلاحية تعديل المستخدمين',
            'routes'            => 'admin.edit,admin.update'
        ]);

        DB::table('permissions')->insert([
            'id'                => 4,
            'name'              => 'admins-delete',
            'display_name'      => ' حذف المستخدمين',
            'description'       => 'صلاحية حذف المستخدمين',
            'routes'            => 'admin.destroy'
        ]);
    }
}
