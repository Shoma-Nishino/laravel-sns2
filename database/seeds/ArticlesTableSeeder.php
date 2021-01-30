<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = [
            [
                'title' => 'タイトル1',
                'body' => '本文1',
                'user_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'title' => 'タイトル2',
                'body' => '本文2',
                'user_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        foreach ($articles as $article) {
            DB::table('articles')->insert($article);
        }
    }
}
