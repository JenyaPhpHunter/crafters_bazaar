<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumSubCategory;
use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Http\Request;

class ForumTopicController extends Controller
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
        $sub_category_id = $request->input('sub_category_id');
        $sub_category = ForumSubCategory::with('forum_category')->where('id', $sub_category_id)->first();
        $topics = ForumTopic::all();
        $categories = ForumCategory::query()->with('forum_sub_categories.forum_topics')->get();

        return view('forum_topics.index',
            compact('topics', 'sub_category', 'user', 'categories', /* 'sub_categories' */)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = ForumCategory::all();
        $sub_categories = ForumSubCategory::all();

        $selected_sub_category_id = $request->input('sub_category_id');
        $selected_sub_category = null;
        $selected_category = null;

        if (!empty($selected_sub_category_id)) {
            $selected_sub_category = ForumSubCategory::find($selected_sub_category_id);
            if ($selected_sub_category) {
                $selected_category = ForumCategory::find($selected_sub_category->forum_category_id);
            }
        }

        return view('forum_topics.create', [
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'selected_sub_category' => $selected_sub_category ? $selected_sub_category : null,
            'selected_category' => $selected_category,
        ]);
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
            'name' => 'required',
            'forum_sub_category_id' => 'required',
        ]);
        $topic = new ForumTopic();
        $topic->name = $request->post('name');
        $topic->forum_sub_category_id = $request->post('forum_sub_category_id');
        $topic->created_at = date("Y-m-d H:i:s");

        $topic->save();

        return redirect(route('forum_topics.show',['forum_topic' => $topic->id]));
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
        $topic = ForumTopic::with('forum_sub_category.forum_category')->where('id', $id)->first();

        return view('forum_topics.show', compact('topic', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $topic = ForumTopic::query()->with('forum_sub_category.forum_category')->where('id',$id)->first();
        $categories = ForumCategory::pluck('name', 'id');
        $sub_categories = ForumSubCategory::query()
            ->where('forum_category_id', $topic->forum_sub_category->forum_category_id)
            ->pluck('name', 'id');

        return view('forum_topics.edit', [
            'topic' => $topic,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
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
            'name' => 'required|unique:forum_topics,name,'.$id,
            'forum_sub_category_id' => 'required',
        ]);

        $topic = ForumTopic::query()->where('id',$id)->first();
        $topic->name = $request->post('name');
        $topic->forum_sub_category_id = $request->post('forum_sub_category_id');
        $topic->updated_at = date("Y-m-d H:i:s");

        $topic->save();

        return redirect( route('forum_topics.index'));

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
