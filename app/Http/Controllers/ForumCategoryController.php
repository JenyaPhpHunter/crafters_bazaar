<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumSubCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ForumCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $categories = ForumCategory::with('forum_sub_categories')->get();

        return view('forum_categories.index', compact('categories', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forum_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:forum_categories',
        ]);

        $category = new ForumCategory();
        $category->name = $request->post('name');

        $category->save();

        return redirect(route('forum_categories.show',['forum_category' => $category->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $category = ForumCategory::with('forum_sub_categories')->where('id', $id)->first();

        return view('forum_categories.show', compact('category', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = ForumCategory::query()->where('id',$id)->first();

        return view('forum_categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:forum_categories,name,'.$id,
        ]);

        $category = ForumCategory::query()->where('id',$id)->first();
        $category->name = $request->post('name');

        $category->save();

        return redirect( route('forum_categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
