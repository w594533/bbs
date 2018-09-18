<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
          [
            'name' => '分享',
          ],
          [
            'name' => '教程',
          ],
          [
            'name' => '文档',
          ],
          [
            'name' => '开源'
          ]
        ];

        Category::insert($categories);
    }
}
