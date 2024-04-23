<?php 


use App\Models\Company;
use App\Providers\RouteServiceProvider;
use App\Models\User;

test('users can create companies', function () {
    $user = User::factory()->create([
       'email_verified_at' => null
    ]);

    
    $response = $this->actingAs($user)->post('/companies-store', [
        "name" => "Any Company",
    ]);
    
    $companies_list = Company::all();
    
    $response->assertStatus(302);
    expect($companies_list)->toHaveLength(1);
});

test('users can read companies', function () {
    $user = User::factory()->create([
       'email_verified_at' => null
    ]);

    $response = $this->actingAs($user)->get('/companies-list');
    
    $response->assertStatus(200);
   
});


test('users can update companies', function () {


    $user = User::factory()->create([
       'email_verified_at' => null
    ]);
    
    $response = $this->actingAs($user)->post('/companies-store', [
            "name" => "Any Company"
    ]);

    $company_old = Company::all()->first();

    $id = $company_old->id;
    $company_old->name = 'ABC';
    

    $update = $this->actingAs($user)->patch("/companies-update/$id", [$company_old->all()]);
        
    $response->assertStatus(302);
    $update->assertStatus(302);

    $company = $company_old->refresh();

    expect($company)->toBe($company_old);
   
});


test('users can delete companies', function () {

    $user = User::factory()->create([
       'email_verified_at' => null
    ]);
    
    $response = $this->actingAs($user)->post('/companies-store', [
            "name" => "Any Company"
    ]);

    $company_old = Company::all()->first();
    $companies_list = Company::all();
    $id = $company_old->id;

    $delete = $this->actingAs($user)->delete("/companies-destroy/$id");
        
    $response->assertStatus(302);
    $delete->assertStatus(302);

    
    $companies_list = Company::all();
    expect($companies_list)->toHaveLength(0);
   
});
