<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = auth()->user()->news;

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    public function getAllByOrderDesc()
    {
        $news = auth()->user()->news()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $news,
            'message' => 'Les news par ordre décroissant'
        ]);
    }

    public function show($id)
    {
        $news = auth()->user()->news()->find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $news->toArray()
        ], 400);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titre' => 'required',
            'contenu' => 'required',
            'category_id' => 'required'
        ]);

        $news = new News;
        $news->titre = $request->titre;
        $news->contenu = $request->contenu;
        $news->user_id = $request->user()->id;
        $news->category_id = $request->category_id;

        if ($news->save())
            return response()->json([
                'success' => true,
                'data' => $news->toArray(),
                'message' => 'Acticle has been created',
                'data' => $news,
            ],201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Article not added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $news = auth()->user()->news()->find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'Artice not found'
            ], 400);
        }

        $updated = $news->fill($request->all())->save();

        if ($updated)
            return response()->json([
                'success' => true,
                'updated data' => $request->all(),
                'message' => 'Article has been updated'
            ],201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Article can not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $news = auth()->user()->news()->find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found'
            ], 400);
        }

        if ($news->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Article has been deleted'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Article can not be deleted'
            ], 500);
        }
    }


}
