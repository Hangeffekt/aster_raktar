<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleadmin = Role::create(['name' => 'admin']);
        $rolemanager = Role::create(['name' => 'warehouse_manager']);
        $roleStorekeeper = Role::create(['name' => 'Storekeeper']);
        $roleStocker = Role::create(['name' => 'Stocker']);
        $roleuser = Role::create(['name' => 'User']);

        //menu bar
        $permission = Permission::create(['name' => 'show dashboard']);
        $permission = Permission::create(['name' => 'show stocks']);
        $permission = Permission::create(['name' => 'show arrivals']);
        $permission = Permission::create(['name' => 'show adjustments']);
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

        //set emnu permissions to roles
        $rolemanager->givePermissionTo(['show dashboard','show stocks','show adjustments','show arrivals', 'show sales','show transfers','show main_datas','show main_datas_products',
        'show main_datas_catalogs','show main_datas_shop','show main_datas_taxes','show main_datas_supliers','show main_datas_brands','show main_datas_payment_types',
        'show main_datas_users','show main_datas_roles','show main_datas_permissions']);
        $roleStorekeeper->givePermissionTo(['show dashboard','show stocks','show adjustments','show arrivals','show sales','show transfers','show main_datas','show main_datas_products',
        'show main_datas_users']);
        $roleStocker->givePermissionTo(['show dashboard','show arrivals','show sales','show main_datas','show main_datas_products',
        'show main_datas_users']);

        //brand
        $permission = Permission::create(['name' => 'create brand']);
        $permission = Permission::create(['name' => 'edit brand']);
        $permission = Permission::create(['name' => 'delete brand']);
        $rolemanager->givePermissionTo(['create brand', 'edit brand','delete brand']);

        //tax
        $permission = Permission::create(['name' => 'create tax']);
        $permission = Permission::create(['name' => 'edit tax']);
        $permission = Permission::create(['name' => 'delete tax']);
        $rolemanager->givePermissionTo(['create tax', 'edit tax','delete tax']);

        //catalog
        $permission = Permission::create(['name' => 'create catalog']);
        $permission = Permission::create(['name' => 'edit catalog']);
        $permission = Permission::create(['name' => 'delete catalog']);
        $rolemanager->givePermissionTo(['create catalog', 'edit catalog','delete catalog']);

        //paymenttype
        $permission = Permission::create(['name' => 'create paymenttype']);
        $permission = Permission::create(['name' => 'edit paymenttype']);
        $permission = Permission::create(['name' => 'delete paymenttype']);
        $rolemanager->givePermissionTo(['create paymenttype', 'edit paymenttype', 'delete paymenttype']);

        //suplier
        $permission = Permission::create(['name' => 'create suplier']);
        $permission = Permission::create(['name' => 'edit suplier']);
        $permission = Permission::create(['name' => 'delete suplier']);
        $rolemanager->givePermissionTo(['create suplier', 'edit suplier','delete suplier']);

        //shop
        $permission = Permission::create(['name' => 'create shop']);
        $permission = Permission::create(['name' => 'edit shop']);
        $rolemanager->givePermissionTo(['create shop', 'edit shop']);

        //product
        $permission = Permission::create(['name' => 'create product']);
        $permission = Permission::create(['name' => 'edit product']);
        $permission = Permission::create(['name' => 'delete product']);
        $permission = Permission::create(['name' => 'show product']);
        $rolemanager->givePermissionTo(['create product', 'edit product','delete product','show product']);
        $roleStorekeeper->givePermissionTo(['show product']);
        $roleStocker->givePermissionTo(['show product']);

        //user
        $permission = Permission::create(['name' => 'create user']);
        $permission = Permission::create(['name' => 'edit user']);
        $permission = Permission::create(['name' => 'delete user']);
        $rolemanager->givePermissionTo(['create user', 'edit user', 'delete user']);
        $roleStorekeeper->givePermissionTo(['create user', 'edit user']);
        $roleStocker->givePermissionTo(['create user', 'edit user']);

        //role
        $permission = Permission::create(['name' => 'create role']);
        $permission = Permission::create(['name' => 'edit role']);
        $permission = Permission::create(['name' => 'delete role']);
        $rolemanager->givePermissionTo(['create role', 'edit role', 'delete role']);

        //permission
        $permission = Permission::create(['name' => 'edit permission']);
        $rolemanager->givePermissionTo(['edit permission']);

        //zone
        $permission = Permission::create(['name' => 'create zone']);
        $permission = Permission::create(['name' => 'edit zone']);
        $permission = Permission::create(['name' => 'delete zone']);

        //arrival
        $permission = Permission::create(['name' => 'create arrival']);
        $permission = Permission::create(['name' => 'edit arrival']);
        $permission = Permission::create(['name' => 'delete arrival']);
        $rolemanager->givePermissionTo(['create arrival', 'edit arrival', 'delete arrival']);
        $roleStorekeeper->givePermissionTo(['create arrival', 'edit arrival', 'delete arrival']);

        //edit arrival
        $permission = Permission::create(['name' => 'create edit_arrival']);
        $permission = Permission::create(['name' => 'edit edit_arrival']);
        $permission = Permission::create(['name' => 'delete edit_arrival']);
        $rolemanager->givePermissionTo(['create edit_arrival', 'edit edit_arrival', 'delete edit_arrival']);
        $roleStorekeeper->givePermissionTo(['create edit_arrival', 'edit edit_arrival', 'delete edit_arrival']);
 
        //adjustment
        $permission = Permission::create(['name' => 'create adjustment']);
        $permission = Permission::create(['name' => 'edit adjustment']);
        $permission = Permission::create(['name' => 'delete adjustment']);
        $rolemanager->givePermissionTo(['create adjustment', 'edit adjustment', 'delete adjustment']);
        $roleStorekeeper->givePermissionTo(['create adjustment', 'edit adjustment', 'delete adjustment']);

        //edit adjustment
        $permission = Permission::create(['name' => 'create edit_adjustment']);
        $permission = Permission::create(['name' => 'edit edit_adjustment']);
        $permission = Permission::create(['name' => 'delete edit_adjustment']);
        $rolemanager->givePermissionTo(['create edit_adjustment', 'edit edit_adjustment', 'delete edit_adjustment']);
        $roleStorekeeper->givePermissionTo(['create edit_adjustment', 'edit edit_adjustment', 'delete edit_adjustment']);

        //storno arrival
        $permission = Permission::create(['name' => 'create storno_arrival']);
        $rolemanager->givePermissionTo(['create storno_arrival']);
        $roleStorekeeper->givePermissionTo(['create storno_arrival']);

        //sale
        $permission = Permission::create(['name' => 'create sale']);
        $permission = Permission::create(['name' => 'edit sale']);
        $permission = Permission::create(['name' => 'delete sale']);
        $rolemanager->givePermissionTo(['create sale', 'edit sale', 'delete sale']);
        $roleStorekeeper->givePermissionTo(['create sale', 'edit sale', 'delete sale']);
        $roleStocker->givePermissionTo(['create sale', 'edit sale']);

        //edit sale
        $permission = Permission::create(['name' => 'create edit_sale']);
        $permission = Permission::create(['name' => 'edit edit_sale']);
        $permission = Permission::create(['name' => 'delete edit_sale']);
        $rolemanager->givePermissionTo(['create edit_sale', 'edit edit_sale', 'delete edit_sale']);
        $roleStorekeeper->givePermissionTo(['create edit_sale', 'edit edit_sale', 'delete edit_sale']);
        $roleStocker->givePermissionTo(['create edit_sale', 'edit edit_sale', 'delete edit_sale']);

        //storno sale
        $permission = Permission::create(['name' => 'create storno_sale']);
        $rolemanager->givePermissionTo(['create storno_sale']);

        //transfer
        $permission = Permission::create(['name' => 'create transfer']);
        $permission = Permission::create(['name' => 'edit transfer']);
        $permission = Permission::create(['name' => 'delete transfer']);
        $rolemanager->givePermissionTo(['create transfer', 'edit transfer', 'delete transfer']);
        $roleStorekeeper->givePermissionTo(['create transfer', 'edit transfer', 'delete transfer']);

        //edit transfer
        $permission = Permission::create(['name' => 'create edit_transfer']);
        $permission = Permission::create(['name' => 'edit edit_transfer']);
        $permission = Permission::create(['name' => 'delete edit_transfer']);
        $rolemanager->givePermissionTo(['create edit_transfer', 'edit edit_transfer', 'delete edit_transfer']);
        $roleStorekeeper->givePermissionTo(['create edit_transfer', 'edit edit_transfer', 'delete edit_transfer']);

        //storno transfer
        $permission = Permission::create(['name' => 'create storno_transfer']);
        $rolemanager->givePermissionTo(['create storno_transfer']);
        $roleStorekeeper->givePermissionTo(['create storno_transfer']);

        $admin = User::first();
        $admin->assignRole('admin');
        $roleadmin->syncPermissions(Permission::all());
    }
}
