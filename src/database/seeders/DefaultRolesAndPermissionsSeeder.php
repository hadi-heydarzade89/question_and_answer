<?php

namespace Database\Seeders;

use HadiHeydarzade89\QuestionAndAnswer\Enums\DefaultPermissionsEnum;
use HadiHeydarzade89\QuestionAndAnswer\Enums\DefaultRolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DefaultRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        $rolePermissions = [
            DefaultRolesEnum::ADMIN->value => [
                DefaultPermissionsEnum::CREATE_USER->value,
                DefaultPermissionsEnum::UPDATE_USER->value,
                DefaultPermissionsEnum::DELETE_ANSWER->value,
                DefaultPermissionsEnum::DELETE_QUESTION->value
            ],
            DefaultRolesEnum::USER->value => [
                DefaultPermissionsEnum::CREATE_QUESTION->value,
                DefaultPermissionsEnum::UPDATE_QUESTION->value,
                DefaultPermissionsEnum::DELETE_OWN_QUESTION->value,
                DefaultPermissionsEnum::LIST_OF_QUESTION->value,
                DefaultPermissionsEnum::CREATE_ANSWER->value,
                DefaultPermissionsEnum::UPDATE_ANSWER->value,
                DefaultPermissionsEnum::DELETE_OWN_ANSWER->value,
                DefaultPermissionsEnum::LIST_OF_ANSWER->value,
            ]
        ];
        foreach ($rolePermissions as $role => $permissions) {


            $$role = Role::updateOrCreate(
                ['name' => $role],
                ['name' => $role],
            );
            foreach ($permissions as $permission) {
                Permission::updateOrCreate(
                    ['name' => $permission],
                    ['name' => $permission]
                );
                $$role->givePermissionTo($permission);
            }
        }
    }
}
