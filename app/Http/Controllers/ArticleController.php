<?php

namespace App\Http\Controllers;

use App\Article;
use App\Tag;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all()->sortByDesc('created_at')->load(['user', 'likes', 'tags']);

        return view('articles.index', ['articles' => $articles]);
    }

    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all());
        $article->user_id = $request->user()->id;

        DB::beginTransaction();
        try {
            $article->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        $request->tags->each(function($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);

            DB::beginTransaction();
            try {
                $article->tags()->attach($tag);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        });

        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        $tagNames = $article->tags->map(function($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.edit', [
            'article' => $article,
            'tagNames' => $tagNames,
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        DB::beginTransaction();
        try {
            $article->fill($request->all())->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        $article->tags()->detach();
        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);

            DB::beginTransaction();
            try {
                $article->tags()->attach($tag);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        });
        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        DB::beginTransaction();
        try {
            $article->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->route('articles.index');
    }

    public function like(Request $request, Article $article)
    {
        DB::beginTransaction();
        try {
            $article->likes()->detach($request->user()->id);
            $article->likes()->attach($request->user()->id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    public function unlike(Request $request, Article $article)
    {
        DB::beginTransaction();
        try {
            $article->likes()->detach($request->user()->id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

}
