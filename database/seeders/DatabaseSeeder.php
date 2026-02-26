<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create roles via users: admin, user, guest
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        User::factory(5)->create();

        // seed some categories, brands, products
        \App\Models\Category::factory(3)->create()->each(function($cat){
            \App\Models\Product::factory(5)->create(['category_id'=>$cat->id])->each(function($p){
                // attach a sample photo record
                \App\Models\ProductPhoto::factory()->create(['product_id'=>$p->id]);
            });
        });

        \App\Models\Brand::factory(3)->create();

        // create some transactions and reviews for first non-admin user
        $user = User::where('role','user')->first();
        if ($user) {
            $products = \App\Models\Product::take(3)->get();
            foreach ($products as $prod) {
                $txn = \App\Models\Transaction::factory()->create(['user_id'=>$user->id]);
                \App\Models\TransactionItem::factory()->create([
                    'transaction_id'=>$txn->id,
                    'product_id'=>$prod->id,
                    'quantity'=>1,
                    'unit_price'=>$prod->price,
                ]);
                \App\Models\Review::factory()->create([
                    'user_id'=>$user->id,
                    'product_id'=>$prod->id,
                ]);
            }
        }
    }
}
