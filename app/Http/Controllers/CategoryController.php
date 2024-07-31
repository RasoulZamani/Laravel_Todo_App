<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(){
        return view('categories.create');
    }

    public function store(Request $request){
        // validate request
        $request->validate([
            'title'=> ['required', 'min:3', 'max:255']
        ]);
        $categoryTitle = $request->title;
        // create category in db
        Category::create([
            'title' => $categoryTitle
        ]);
        return response()->json([
            "message"=>"category with title $categoryTitle was created successfully!"], 200);
    }

}
