<?php

namespace App\Http\Controllers;


use Inertia\Inertia;

use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Models\Lead;
use Illuminate\Support\Facades\Redirect;
use App\Models\Company;


use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Requests\Company\DestroyCompanyRequest;


class CompanyController extends Controller
{
    //
    public function list(Request $request): Response
    {
        $user = $request->user();
        $filters = $request->query();
        
        $query = $user->companies();
        //dd($query);
        $companies = $query->paginate()->withQueryString();

       return Inertia::render('Company/List', ['companies' => $companies]);
    }

    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $company->update([
            'name' => $request->name
        ]);


       return Redirect::route('companies.list');
    }

    public function destroy(DestroyCompanyRequest $request, Company $company): RedirectResponse {
        $company->delete();
        return Redirect::route('companies.list');
    }

    public function store(CreateCompanyRequest $request): RedirectResponse 
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        Company::create($data);
        return Redirect::route('companies.list');
    }
}
