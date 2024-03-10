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
        $tags = $user->tags();
        $filters = $request->query();
        $query = $user->leads()->with('user')->with('company');
        $filter = array_key_exists('filter', $filters) ? $filters['filter'] : [];

        foreach ($filter as $field => $value) {
            if (in_array($field, ['name', 'email', 'phone'])) {
                $query->where($field, 'like', '%' . $value . '%');
            } elseif ($field === 'company_id' && is_numeric($value)) {
                $query->where('company_id', $value);
            }
        }

        $leads = $query->paginate(10)->withQueryString();
        
        return Inertia::render('Lead/List', ['leads' => $leads, 'tags' => $tags]);
    }

    public function show(Lead $lead): Response
    {
        //dd($lead);
        $leadShow = $lead->load(['company']);
        $leadTags = $lead->load(['leadTags']);
        
        //dd($leadTags);
        $tags = $lead->leadTags->load(['tag']);

        return Inertia::render('Lead/Show', ['lead' => $lead, 'tags' => $tags]);
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
        return Redirect::route('leads.list');
    }

}
