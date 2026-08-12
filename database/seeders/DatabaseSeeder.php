<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
            $this->call(UserSeeder::class);
            $this->call(ProvinceSeeder::class);
            $this->call(CitySeeder::class);
            $this->call(AboutUsSeeder::class);
            $this->call(ContactUsSeeder::class);
            $this->call(CategorySeeder::class);
            $this->call(CouponSeeder::class);
            $this->call(FeatureSeeder::class);
            $this->call(FooterSeeder::class);
            $this->call(SliderSeeder::class);

            // seeders with foreign key
            $this->call(ProductSeeder::class);
            $this->call(UserAddressSeeder::class);
            // $this->call(WishlistSeeder::class);
     
    }
}
