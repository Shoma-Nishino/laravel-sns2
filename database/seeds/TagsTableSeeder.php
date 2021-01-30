<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [
                'name' => 'タグ1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'タグ2',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert($tag);
        }
    }
}
