<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{      
    // Show all todo instances
    public function index(){
        $todos = Todo::all();
        return view('todos.index',compact('todos'));
    }

    // Show todo by id
    public function show(Todo $todo){
        return view('todos.show',compact('todo'));
    }

    // Show form to create todo
    public function create(){
        $categories = Category::all();
        return view('todos.create', compact('categories'));
    }

    // Create todo in db
    public function store(Request $request){
        // Validate request
        $request->validate([
            'image' => ['required', 'max:5000', 'image'],
            'title'=> ['required', 'min:3', 'max:255'],
            'description' => ['required','min:5','max:255'],
            'category_id' => ['required','integer']
        ]);
        // create name for image and store it in public/images
        $fileName = date("Y-m-d-H-i-s") . $request->image->getClientOriginalName();
        $request->image->storeAs('images', $fileName);
        
        // Create todo in db
        Todo::create([
            'image' => $fileName,
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('todo.index');    
    }

    // Edit form to update todo
    public function edit(Todo $todo){
        $categories = Category::all();
        return view('todos.edit', compact('todo', 'categories'));
    }
    
    // set status as completed
    public function completed(Todo $todo){
        $todo->update([
            'status' => 1,
        ]);
        return redirect()->route('todo.index');
    }

    // Update todo in db
    public function update(Todo $todo, Request $request){
        // validate data
        $request->validate([
            'image' => ['nullable', 'max:5000', 'image'],
            'title'=> ['required', 'min:3', 'max:255'],
            'description' => ['required','min:5','max:255'],
            'category_id' => ['required','integer']
        ]);
        // If new image provided, create name for it and store it in public/images 
        if ($request->hasFile('image')){
            Storage::delete('/images/'.$todo->image); //delete previous one
            $fileName = date("Y-m-d-H-i-s") . $request->image->getClientOriginalName();
            $request->image->storeAs('images', $fileName);
        }
        
        // update data
        $todo->update([
            'image' => $request->hasFile('image') ? $fileName : $todo->image,
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);
        return redirect()->route('todo.index');
    }

    // Delete todo by id
    public function destroy(Todo $todo){
        $todo->delete();
        return redirect()->route('todo.index');
    }

}