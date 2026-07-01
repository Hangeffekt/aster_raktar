<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'warehouse_manager']);
        $role = Role::create(['name' => 'purchaser']);
        $role = Role::create(['name' => 'warehouse_worker']);
        $role = Role::create(['name' => 'sales_agent']);
        //menu bar
        $permission = Permission::create(['name' => 'show dashboard']);
        $permission = Permission::create(['name' => 'show arrivals']);
        $permission = Permission::create(['name' => 'show sales']);
        $permission = Permission::create(['name' => 'show transfers']);
        $permission = Permission::create(['name' => 'show main_datas']);
        $permission = Permission::create(['name' => 'show main_datas_products']);
        $permission = Permission::create(['name' => 'show main_datas_catalogs']);
        $permission = Permission::create(['name' => 'show main_datas_shop']);
        $permission = Permission::create(['name' => 'show main_datas_taxes']);
        $permission = Permission::create(['name' => 'show main_datas_supliers']);
        $permission = Permission::create(['name' => 'show main_datas_brands']);
        $permission = Permission::create(['name' => 'show main_datas_payment_types']);
        $permission = Permission::create(['name' => 'show main_datas_moduls']);
        $permission = Permission::create(['name' => 'show main_datas_zones']);
        $permission = Permission::create(['name' => 'show main_datas_modul_locations']);
        $permission = Permission::create(['name' => 'show main_datas_users']);
        $permission = Permission::create(['name' => 'show main_datas_roles']);
        $permission = Permission::create(['name' => 'show main_datas_permissions']);

        //brand
        $permission = Permission::create(['name' => 'create brand']);
        $permission = Permission::create(['name' => 'edit brand']);
        $permission = Permission::create(['name' => 'delete brand']);

        //tax
        $permission = Permission::create(['name' => 'create tax']);
        $permission = Permission::create(['name' => 'edit tax']);
        $permission = Permission::create(['name' => 'delete tax']);

        //catalog
        $permission = Permission::create(['name' => 'create catalog']);
        $permission = Permission::create(['name' => 'edit catalog']);
        $permission = Permission::create(['name' => 'delete brand']);

        //suplier
        $permission = Permission::create(['name' => 'create suplier']);
        $permission = Permission::create(['name' => 'edit suplier']);
        $permission = Permission::create(['name' => 'delete catalog']);

        //shop
        $permission = Permission::create(['name' => 'create shop']);
        $permission = Permission::create(['name' => 'edit shop']);
        $permission = Permission::create(['name' => 'delete shop']);

        //product
        $permission = Permission::create(['name' => 'create product']);
        $permission = Permission::create(['name' => 'edit product']);
        $permission = Permission::create(['name' => 'delete product']);

        //user
        $permission = Permission::create(['name' => 'create user']);
        $permission = Permission::create(['name' => 'edit user']);
        $permission = Permission::create(['name' => 'delete user']);

        //zone
        $permission = Permission::create(['name' => 'create zone']);
        $permission = Permission::create(['name' => 'edit zone']);
        $permission = Permission::create(['name' => 'delete zone']);
    }
}
