<?php

use Illuminate\Database\Seeder;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'super admin',
            'email'=> 'admin@admin.com',
            'email_verified_at'=>null,
            'password'=>'$2y$10$MuXrHqIm6wzgGl32c8iq7eMW/aRgp.SZf1Yn8C0snEMVcNzEMJ7hq',
            'is_admin'=>2,
            'is_super_admin'=>1,
            'remember_token' => null,
            'created_at'=>'2020-04-03 16:41:21',
            'updated_at'=>'2020-04-03 16:41:21'
        ]);
    }
}
