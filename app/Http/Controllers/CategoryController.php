<?php

namespace App\Http\Controllers;

use App\Category;
use App\Task;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all()->toArray();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = Task::create([
           'name' => $request->name,
           'category' => $request->category_id,
           'user_id' => $request->user_id,
           'order' => $request->order
        ]);

        $data = [
            'data' => $task,
            'status' => (bool) $task,
            'message' => $task ? 'Task Created' : 'Error creating Task'
        ];

        return response()->json($data);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function tasks(Category $category)
    {
        return response()->json($category->tasks()->orderBy('order')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $status = $category->update($request->only('name'));

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Category Updated.' : "Error updating category. Please try again."
        ]);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $status  = $category->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Category Deleted' : 'Error Deleting Category'
        ]);
    }
}
