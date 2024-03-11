<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Models\Lead;
use App\Http\Requests\InteractionRequest;
use Illuminate\Support\Facades\Redirect;
use App\Models\Company;

use App\Models\Tag;
use App\Models\LeadTag;


class InteractionController extends Controller
{
    //
    public function create(Request $request): Response
    {
        $user = $request->user();
        $leads = Lead::all()->where('user_id', $user->id);
        return Inertia::render('Interactions/Create', ['leads' => $leads]);
    }


    public function store(InteractionRequest $request): RedirectResponse 
    {
        // $request->validated();

        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        
        //dd($data['tags']);
        /*
        if($request->new_company && ($request->new_company != '' || $request->new_company != null)){
            $newCompany = Company::create(['name' => $request->new_company, 'user_id' => $request->user()->id]);
            //echo($newCompany->id);
            $data['company_id'] = $newCompany->id;
        }*/
        $interaction = Interaction::create($data);
        /*
        if($data['tags']){
            $tags = $data['tags'];
            foreach($tags as $tag){
                LeadTag::create(['lead_id' => $lead->id, 'tag_id' => $tag['id'],  'user_id' => $data['user_id']]);
            } 
        }
        */
        return Redirect::route('leads.list');
    }

}
