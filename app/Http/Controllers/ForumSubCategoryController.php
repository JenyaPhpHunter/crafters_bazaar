<?php

namespace App\Http\Controllers;

use App\Constants\ProductsConstants;
use App\Models\ForumCategory;
use App\Models\ForumSubCategory;
use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Http\Request;

class ForumSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sub_categories = ForumSubCategory::all();
        $categories = ForumCategory::all();
        $user_id = $request->input('user_id');
        $user = User::find($user_id);

        return view('forum_sub_categories.index',
            compact(
                'sub_categories',
                'categories',
                'user',
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $selected_category_id = $request->input('category_id');
        $categories = ForumCategory::all();
        $action_types = ProductsConstants::ACTION_TYPES;

        return view('forum_sub_categories.create', compact('categories', 'selected_category_id', 'action_types'));
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
            'name' => 'required|unique:forum_sub_categories',
            'forum_category_id' => 'required',
        ]);
        $sub_category = new ForumSubCategory();
        $sub_category->name = $request->post('name');
        $sub_category->forum_category_id = $request->post('forum_category_id');
        $sub_category->created_at = date("Y-m-d H:i:s");

        $sub_category->save();

        return redirect(route('forum_sub_categories.show',['forum_sub_category' => $sub_category->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $sub_category = ForumSubCategory::query()
            ->with('forum_category')
            ->with('forum_topics')
            ->where('id', $id)
            ->first();

        return view('forum_sub_categories.show', compact('sub_category', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sub_category = ForumSubCategory::query()->with('forum_category')->where('id',$id)->first();
        $categories = ForumCategory::pluck('name', 'id');
        if(!$sub_category){
            throw new \Exception('Підкатегорія не знайдена');
        }

        return view('forum_sub_categories.edit', [
            'sub_category' => $sub_category,
            'categories' => $categories,
        ]);
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
            'name' => 'required|unique:forum_sub_categories,name,'.$id,
            'forum_category_id' => 'required',
        ]);

        $sub_category = ForumSubCategory::query()->where('id',$id)->first();
        $sub_category->name = $request->post('name');
        $sub_category->forum_category_id = $request->post('forum_category_id');
        $sub_category->updated_at = date("Y-m-d H:i:s");

        $sub_category->save();

        return redirect( route('forum_sub_categories.index'));
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
