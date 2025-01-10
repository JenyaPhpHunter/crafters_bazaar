<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ProductsConstants;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Відображення списку тегів.
     */
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $tags = Tag::all();
        return view('admin.tags.index',[
            "tags" => $tags,
            "user" => $user,
        ]);
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:tags|max:35',
        ]);

        $tag = new Tag();
        $tag->title = $request->post('title');

        $tag->save();

        return redirect(route('admin_tags.index'))->with('success', 'Тег успішно додано!');
    }

    public function show(Request $request, $id)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $tag = Tag::query()
            ->where('id',$id)
            ->first();
        return view('admin.tags.show', [
            'admin_tag' => $id,
            'tag' => $tag,
            'user' => $user,
        ]);
    }

    public function edit($id)
    {
        $tag = Tag::query()->where('id',$id)->first();
        if(!$tag){
            throw new \Exception('Tag not found');
        }
        $action_types = ProductsConstants::ACTION_TYPES;
        return view('admin.tags.edit', compact('tag', 'action_types'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|unique:tags,title,' . $id . '|max:35',
        ]);

        $tag = Tag::query()->where('id',$id)->first();
        $tag->title = $request->post('title');

        $tag->save();

        return redirect( route('admin_tags.show', ['admin_tag' => $id]))->with('success', 'Тег успішно оновлено!');
    }

    public function destroy($id)
    {
        $tag = Tag::query()->where('id',$id)->delete();
        return redirect( route('admin_tags.index'));
    }
}
