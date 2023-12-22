<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Role::factory()->create([
                'name' => 'Admin',
                'description' => 'System Administrator',
            
        ]);

        \App\Models\Role::factory()->create([
            'name' => 'Auditor',
            'description' => 'System Auditor',
        ]);

        \App\Models\Role::factory()->create([
            'name' => 'Sales',
                'description' => 'Shop Keeper',
        ]);

        \App\Models\Shop::factory()->create(
            [
                'name' => 'Test',
                'address' => 'P.o.Box 100 Dar Es Salaam',
                'location' => 'Mbezi Beach',
                'description' => ' Duka la Vifaa vyote jumla na rejareja'
            ]
        );
        

        \App\Models\User::factory()->create([
            'name' => 'David Daniel',
            'phone' => '+255743414770',
            'email' => 'admin@gmail.com',
            'role_id'=>1,
            'password' => Hash::make('admin123'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Ludovick Konyo',
            'phone' => '+255743414772',
            'email' => 'auditor@gmail.com',
            'role_id'=>2,
            'password' => Hash::make('auditor123'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Andrea Mpulila',
            'phone' => '+255743414771',
            'email' => 'sales@gmail.com',
            'role_id'=>3,
            'shop_id' =>1,
            'password' => Hash::make('sales123'),
        ]);
      
        


        \App\Models\Category::factory()->create([
            'name' =>'Default',
            'description' => 'For Testing Only'
        ]);

        \App\Models\Unit::factory()->create([
            'name' =>'Default',
            'description' => 'For Testing Only'
        ]);
    }
}
