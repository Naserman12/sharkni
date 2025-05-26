<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Constuction Tools', 'name_ha' => 'kayan Gina','slug' => 'Constuction'],
            ['name' => 'Farming Tools', 'name_ha' => 'kayan Noma','slug' => 'Farming'],
            ['name' => 'Household Tools', 'name_ha' => 'kayan Gida','slug' => 'Household'],
            ['name' => 'Cars Tools', 'name_ha' => 'kayan Mota', 'slug' => 'Cars'],
        ];
        foreach($categories as $category){
            Category::create($category);
        }
    }
}
