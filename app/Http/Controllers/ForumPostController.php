<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumPost;
use App\Models\ForumSubCategory;
use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Http\Request;

class ForumPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = User::find($request->input('user_id'));
//        $this->seedie($request->all());
        $topic = ForumTopic::query()
            ->where('id',$request->input('topic_id'))
            ->with('forum_sub_category.forum_category')
            ->first();
        $answer_post = false;
        if ($request->input('post_id')){
            $answer_post = ForumPost::find($request->input('post_id'));
        }
        $categories = ForumCategory::all();
        $sub_categories = ForumSubCategory::all();
        $topics = ForumTopic::all();

        return view('forum_posts.create', [
            'user' => $user,
            'topic' => $topic,
            'topics' => $topics,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'answer_post' => $answer_post,
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
            'content' => 'required',
            'forum_topic_id' => 'required',
        ]);

        $post = new ForumPost();
        $post->content = $request->post('content');
        if($request->input('answer_post_id')){
            $answer_post = ForumPost::find($request->input('answer_post_id'));
            $post->forum_topic_id = $answer_post->forum_topic_id;
            $post->answer_to = $answer_post->id;
        } else {
            $post->forum_topic_id = $request->post('forum_topic_id');
        }
        $post->user_id = $request->post('user_id');
        $post->created_at = date("Y-m-d H:i:s");

        $post->save();

        return redirect()->route('forum_topics.show', ['forum_topic' => $post->forum_topic_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = ForumPost::query()
            ->where('id',$id)
            ->with('forum_topic.forum_sub_category.forum_category')
            ->first();
        $categories = ForumCategory::all();
        $sub_categories = ForumSubCategory::all();
        $topics = ForumTopic::query()->where('forum_sub_category_id', $post->forum_topic->forum_sub_category->id)->get();

        return view('forum_posts.edit', [
            'post' => $post,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'topics' => $topics,
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
            'content' => 'required|unique:forum_posts,content,'.$id,
            'forum_topic_id' => 'required',
        ]);

        $post = ForumPost::query()->where('id',$id)->first();
        $post->forum_topic_id = $request->post('forum_topic_id');
        $post->updated_at = date("Y-m-d H:i:s");
        $post->save();

        return redirect()->route('forum_topics.show', ['forum_topic' => $post->forum_topic_id]);
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
