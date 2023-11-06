<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {

        $categories = new Category();
        $categories= $categories->all();

        if ($categories)
        return response()->json([
            'success' => true,
            'data' => $categories,
            'message' => 'All categories fetched.',
        ],201);
        else
        return response()->json([
            'success' => false,
            'message' => 'Categories not found'
        ], 500);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = new Category();
        $category->nom = $request->name;
        $category->description = $request->description;

        if ($category->save())
        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Category has been created',
        ],201);
        else
        return response()->json([
            'success' => false,
            'message' => 'Category not added'
        ], 500);
    }

    public function getNewsByCategoryId($id)
    {
        $category = new Category();
        $news = $category->find($id)->news;

        if ($news)
        return response()->json([
            'success' => true,
            'data' => $news,
            'message' => 'Fetched news by category id',
        ],201);
        else
        return response()->json([
            'success' => false,
            'message' => 'News not found'
        ], 500);
    }

    public function getNewsByCategoryName($name)
    {
        $category = new Category();
        $news = $category->where('nom', $name )->with('news')->get();
        $news = $news[0]->news;

        if ($news)
        return response()->json([
            'success' => true,
            'data' => $news,
            'message' => 'News by category id',
        ],201);
        else
        return response()->json([
            'success' => false,
            'message' => 'Not found'
        ], 500);
    }
}
