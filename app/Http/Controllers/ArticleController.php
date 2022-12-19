<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseHelper;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    /*
     *
     * Show All Article
     *
     */
    public function showAllArticle()
    {
        $articles = Article::get();
        if ($articles->isEmpty())
        {
            return ResponseHelper::response(false, 'Article not found');
        }

        return ResponseHelper::response(true, 'All Articles', $articles);
    }

    /*
     *
     *  Show One Category
     *
     */

    public function showOneArticle($id)
    {
        $article = Article::where('id', $id)->get();

        if ($article->isEmpty())
        {
            return ResponseHelper::response(false, 'Article not found');
        }

        return ResponseHelper::response(true, 'Article Detail', $article);
    }

    /*
     *
     *  Create Article
     *
     */

    public function create(Request $request)
    {
        $title = $request->title;

        $this->validate($request, [
            'title' => 'required|max:250',
            'articleContent' => 'required',
            'tag' => 'required',
            'situation' => 'required',
            'categoryId' => 'required',
            'authorId' => 'required',
        ]);

        $createArticle = new Article();
        $createArticle->title = $title;
        $createArticle->slug = Str::slug($title);
        $createArticle->content = $request->articleContent;
        $createArticle->tag = $request->tag;
        $createArticle->categoryId = $request->categoryId;
        $createArticle->authorId = $request->authorId;
        $createArticle->situation = ARTICLE_ACTIVE;
        $createArticle->save();

        if (!$createArticle)
        {
            return ResponseHelper::response(false, 'System error! Failed to create article');
        }

        return ResponseHelper::response(true, 'Article Added', $createArticle);

    }

    /*
     *
     *  Article Update
     *
     */

    public function update(Request $request, $id)
    {
        $article = Article::where('id', $id)->get();

        if ($article->isEmpty())
        {
            return ResponseHelper::response(false, 'Article not found');
        }

        $this->validate($request, [
            'title' => 'required|max:250',
            'articleContent' => 'required',
            'situation' => 'required',
            'categoryId' => 'required',
            'authorId' => 'required'
        ]);


        $articleUpdate = Article::where('id', $id)
            ->update(
                [
                    'title' => $request->title,
                    'content' => $request->articleContent,
                    'situation' => $request->situation,
                    'categoryId' => $request->categoryId,
                    'authorId' => $request->authorId
                ]
            );


        if (!$articleUpdate)
        {
            return ResponseHelper::response(false, 'System error! Failed to update article.');
        }

        return ResponseHelper::response(true, 'Article Updated');
    }
}
