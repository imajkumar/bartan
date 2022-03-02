<?php

  

use Illuminate\Database\Seeder;

use App\User;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

  

class CreateAdminSeederNp extends Seeder

{

    /**

     * Run the database seeds.

     *

     * @return void

     */

    public function run()

    {

        $user = User::create(
            [

        	'name' => 'Sanjay Sharma', 

        	'email' => 'Sanjaysharma@subhiksh.com',

        	'password' => bcrypt('Sanjay123'),
        	'user_type' => 1,
        	'profile' => 1,

            ],
            [

        	'name' => 'Uday', 

        	'email' => 'uday@subhiksh.com',

        	'password' => bcrypt('Uday#123'),
        	'user_type' => 1,
        	'profile' => 1,

            ],
            [

        	'name' => 'Renu', 

        	'email' => 'Renu@subhiksh.com',

        	'password' => bcrypt('Renu&123'),
        	'user_type' => 1,
        	'profile' => 1,

            ],
            [

                'name' => 'Jitender', 
    
                'email' => 'jitender@subhiksh.com',
    
                'password' => bcrypt('Jitender123#'),
                'user_type' => 1,
                'profile' => 1,
    
            ],
            [

                'name' => 'Santanu', 
    
                'email' => 'santanu@subhiksh.com',
    
                'password' => bcrypt('Santanu1234'),
                'user_type' => 1,
                'profile' => 1,
    
            ],
            [

                'name' => 'Vikesh', 
    
                'email' => 'vikesh@subhiksh.com',
    
                'password' => bcrypt('Vikesh#123'),
                'user_type' => 1,
                'profile' => 1,
    
            ],
        );

  

        $role = Role::create(['name' => 'Admin']);

   

        $permissions = Permission::pluck('id','id')->all();

  

        $role->syncPermissions($permissions);

   

        $user->assignRole([$role->id]);

    }
    // php artisan db:seed --class=ProductTableSeeder run specific seeder file
}