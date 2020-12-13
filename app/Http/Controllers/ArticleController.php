<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function getArticles()
    {
        return Article::where('status_id', '2')->select('title', 'short_description', 'description')->get();

    }

    public function get($id)
    {
        return Article::where(['id' => $id, 'status_id' => '2'])->select('title', 'short_description', 'description')->get();
    }

    public function create(Request $request)
    {
        $validator = $this->validateArticle($request);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['user_id'] = $request->user()->id;
        $article = Article::create($request->all());

        return response($article, 200);

    }

    public function update(Request $request, $id)
    {
        $validator = $this->validateArticle($request);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $article = Article::findOrFail($id);
        $request['user_id'] = $request->user()->id;
        $article->update($request->all());
        return $article;
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return 204;

    }


    public function validateArticle(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'status_id' => 'required|exists:article_statuses,id',
        ]);
        return $validator;

    }
}
