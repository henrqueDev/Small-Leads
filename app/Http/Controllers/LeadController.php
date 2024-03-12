<?php

namespace App\Http\Controllers;


use Inertia\Inertia;

use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Lead;
use App\Http\Requests\LeadRequest;
use Illuminate\Support\Facades\Redirect;
use App\Models\Company;

use App\Models\Tag;
use App\Models\LeadTag;
use App\Http\Requests\EditLeadRequest;

class LeadController extends Controller
{
    //

    public function create(Request $request): Response
    {
        $user = $request->user();
        $tags = Tag::all()->where('user_id', $user->id);
        return Inertia::render('Lead/Create', ['tags' => $tags]);
    }

    public function list(Request $request): Response
    {
        $user = $request->user();
        $tags = $user->load('tags')->tags;

        //dd(Lead::with('leadTags.tag')->get()[0]->leadTags[0]->tag);
        $filters = $request->query();
        

        $query = $user->leads()->with('user')->with('company')->with('leadTags.tag');
        
        $filter = array_key_exists('filter', $filters) ? $filters['filter'] : [];

        
        //dd($filter['converted'] === "false");

        $filterTags = array_key_exists('tags', $filter);
        if($filterTags){
            $requestedTags = $filter['tags'];

            $query->whereHas('leadTags', function ($query) use ($requestedTags) {
                $query->whereIn('tag_id', $requestedTags);
            });
        }


        foreach ($filter as $field => $value) {
            if (in_array($field, ['name', 'email', 'phone'])) {
                $query->where($field, 'like', '%' . $value . '%');
            } else if ($field === 'company_id' && is_numeric($value)) {
                $query->where('company_id', $value);
            } else if ($field == 'situation') {

                if($value['is_paying']==="true" && $value['converted'] === "true"){
                    $query->where('is_paying', 1);
                    $query->where('converted', 1);
                }
                else if ($value['converted'] === "true"){
                    $query->where('converted', 1);
                } else if ($value['is_paying'] === "true") {
                    $query->where('is_paying', 1);
                }
            }
            else if($field === 'order'){
                if(array_key_exists('orderBy', $value)){
                    if(in_array($value['orderBy'], ['name', 'email', 'phone'])){
                        $query->orderBy($value['orderBy'], $value['orderDesc'] === 'true' ? 'desc' : 'asc' );
                    }
                }
            }
        }

        //$query->orderBy(array_key_exists('filter', $filters) ? $filters['filter'] : '', 'asc');

        $leads = $query->paginate(5)->withQueryString();


        return Inertia::render('Lead/List', ['leads' => $leads, 'tags' => $tags, 'alreadySelectedTags' => $filterTags ? $filter['tags'] : []]);
    }

    public function show(Request $request, Lead $lead): Response
    {
        if($request->user()->id != $lead->user_id){
            return Redirect::route('leads.list');
        }
        //dd($lead);
        $leadShow = $lead->load(['company']);
        $leadTags = $lead->load(['leadTags']);
        $interactions = $lead->load(['interactions'])->interactions->load(['interactionType']);

        $tags = $lead->leadTags->load(['tag']);

        return Inertia::render('Lead/Show', ['lead' => $lead, 'tags' => $tags, 'interactions' => $interactions]);
    }

    public function store(LeadRequest $request): RedirectResponse 
    {
        $request->validated();

        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        
        //dd($data['tags']);

        if($request->new_company && ($request->new_company != '' || $request->new_company != null)){
            $newCompany = Company::create(['name' => $request->new_company, 'user_id' => $request->user()->id]);
            //echo($newCompany->id);
            $data['company_id'] = $newCompany->id;
        }
        $lead = Lead::create($data);
        if($data['tags']){
            $tags = $data['tags'];
            foreach($tags as $tag){
                LeadTag::create(['lead_id' => $lead->id, 'tag_id' => $tag['id'],  'user_id' => $data['user_id']]);
            } 
        }
        return Redirect::route('leads.show', ['lead' => $lead->id]);
    }

    public function edit(Request $request, Lead $lead): Response
    {
        $user = $request->user();
        $tags = Tag::all()->where('user_id', $user->id);
        $leadTags = $lead->leadTags->load(['tag']);

        return Inertia::render('Lead/Edit', ['lead' => $lead, 'tags' => $tags, 'leadTags' => $leadTags]);
    }

    public function update(EditLeadRequest $request, Lead $lead): RedirectResponse
    {
        $user = $request->user();

        $filters = $request->query();
        $data = $request->all();

        $data['user_id'] = $request->user()->id;
        

        

        //dd($lead->load('leadTags')->leadTags->load('tag'));
        //dd($data['tags']);  
        if($request->new_company && ($request->new_company != '' || $request->new_company != null)){
            $newCompany = Company::create(['name' => $request->new_company, 'user_id' => $request->user()->id]);
            //echo($newCompany->id);
            $data['company_id'] = $newCompany->id;
        }

    

        if($data['tags'] || $lead->load('leadTags')->leadTags){
            $tags = $data['tags'];
            $leadTags = $lead->load('leadTags')->leadTags;
            foreach($leadTags as $leadTag){
                $leadTag->delete();
            
            }
            
            foreach($tags as $tag){
                LeadTag::create(['lead_id' => $lead->id, 'tag_id' => $tag['id'],  'user_id' => $data['user_id']]);
            } 
        }

        $lead->update($data);

        return Redirect::route('leads.show', ['lead' => $lead->id]);
    }

    public function destroy(Request $request, Lead $lead) {
        $lead->delete();
        return Redirect::route('leads.list');
    }

}
