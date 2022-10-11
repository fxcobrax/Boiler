<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\UserRepository;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /** @var  PermissionRepository */
    private $permissionRepository;
    /** @var  RoleRepository */
    private $roleRepository;
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(RoleRepository $roleRepo, PermissionRepository $permissionRepo, UserRepository $userRepo)
    {
        $this->roleRepository = $roleRepo;
        $this->permissionRepository = $permissionRepo;
        $this->userRepository = $userRepo;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('config:clear');
        // load permission from router name
        $exitCode = Artisan::call('router:permission');

        // Supper Admin
        $roleSupperAdmin = $this->roleRepository->create([
            'name' =>    Role::SUPPER_ADMIN,
            'title' => 'Supper Admin',
            'guard_name' => 'api'
        ]);

        $userSupperAdmin = $this->userRepository->create([
            'name' => 'Nguyễn Văn Hậu',
            'email' => 'hau@hau.xyz',
            'password' => Hash::make('123@123@1234'),
        ]);
        $userSupperAdmin->assignRole($roleSupperAdmin);
    }
}
