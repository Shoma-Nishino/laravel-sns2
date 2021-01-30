<?php

use Illuminate\Database\Seeder;

class Article_tagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $article_tags = [
            [
                'article_id' => 1,
                'tag_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'article_id' => 2,
                'tag_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        foreach ($article_tags as $article_tag) {
            DB::table('article_tag')->insert($article_tag);
        }
    }
}
