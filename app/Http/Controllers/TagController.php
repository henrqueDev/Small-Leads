<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\Tag\UpdateTagRequest;

use App\Http\Requests\Tag\CreateTagRequest;

use App\Models\Tag;

class TagController extends Controller
{
    //

    public function list(Request $request): Response
    {
        $user = $request->user();
        $filters = $request->query();
        
        $query = $user->tags();
        //dd($query);
        $tags = $query->paginate()->withQueryString();

       return Inertia::render('Tags/List', ['tags' => $tags]);
    }

    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        $tag->update([
            'name' => $request->name
        ]);


       return Redirect::route('tags.list');
    }

    public function destroy(Request $request, Tag $tag): RedirectResponse {
        $tag->delete();
        return Redirect::route('tags.list');
    }

    public function store(CreateTagRequest $request): RedirectResponse 
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        Tag::create($data);
        return Redirect::route('tags.list');
    }
}
