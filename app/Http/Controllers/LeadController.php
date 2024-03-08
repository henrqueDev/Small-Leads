<?php

namespace App\Http\Controllers;


use Inertia\Inertia;

use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Lead;
use App\Http\Requests\LeadRequest;
use Illuminate\Support\Facades\Redirect;

class LeadController extends Controller
{
    //

    public function create(): Response
    {
        return Inertia::render('Lead/Create');
    }

    public function list(Request $request): Response
    {
        $user = $request->user();
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

        return Inertia::render('Lead/List', ['leads' => $leads]);
    }

    public function store(LeadRequest $request): RedirectResponse 
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        
        Lead::create($data);

        return Redirect::route('profile.edit');
    }

}
