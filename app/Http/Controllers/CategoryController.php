<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{      
    // Show all category instances
    public function index(){
        $categories = Category::all();
        return view('categories.index',compact('categories'));
    }

    // Show form to create category
    public function create(){
        return view('categories.create');
    }

    // Create category in db
    public function store(Request $request){
        // Validate request
        $request->validate([
            'title'=> ['required', 'min:3', 'max:255']
        ]);
        $categoryTitle = $request->title;
        // Create category in db
        Category::create([
            'title' => $categoryTitle
        ]);

        // return response()->json([
        //     "message"=>"category with title $categoryTitle was created successfully!"], 200);
        return redirect()->route('category.index');    
    }

    // Edit form to update category
    public function edit(Category $category){
        return view('categories.edit', compact('category'));
    }

    // Update category in db
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

    // Delete category by id
    public function destroy(Category $category){
        $category->delete();
        return redirect()->route('category.index');
    }

}
