<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Providers\RouteServiceProvider;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, HasRoles;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_perm' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['role_perm'] == 'manager') {
            $manager = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            if($manager){
                $role = Role::create(['name' => 'manager']);
                $permissions[] = Permission::create(['name' => 'create park']);
                $permissions[] = Permission::create(['name' => 'edit park']);
                $permissions[] = Permission::create(['name' => 'edit park']);
                $permissions[] = Permission::create(['name' => 'delete park']);
                $permissions[] = Permission::create(['name' => 'create vehicle']);
                $permissions[] = Permission::create(['name' => 'edit vehicle']);
                $permissions[] = Permission::create(['name' => 'delete vehicle']);
                if($role->syncPermissions($permissions)) {
                    return $manager;
                }
            }
        } elseif($data['role_perm'] == 'driver') {
            $manager = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            if($manager){
                $role = Role::create(['name' => 'driver']);
                $permissions[] = Permission::create(['name' => 'create vehicle']);
                $permissions[] = Permission::create(['name' => 'edit vehicle']);
                if($role->syncPermissions($permissions)) {
                    return $manager;
                }
            }
        }
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }
}
