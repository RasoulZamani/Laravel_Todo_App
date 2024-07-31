<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{   
    public function index(){
        $categories = Category::all();
        return view('categories.index',compact('categories'));
    }

    // show create form for category
    public function create(){
        return view('categories.create');
    }

    // create category
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

        // return response()->json([
        //     "message"=>"category with title $categoryTitle was created successfully!"], 200);
        return redirect()->route('category.index');    
    }

    // edit form for category
    public function edit(Category $category){
        return view('categories.edit', compact('category'));
    }

    // update category in db
    public function update(Category $category, Request $request){
        // validate data
        $request->validate([
            'title'=> ['required', 'min:3', 'max:255']
        ]);
        $categoryTitle = $request->title;
        
        // update data
        $category->update([
            'title' => $categoryTitle 
        ]);
        return redirect()->route('category.index');
    }

    // delete category 
    public function destroy(Category $category){
        $category->delete();
        return redirect()->route('category.index');
    }

}
