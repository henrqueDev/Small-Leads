<?php 


use App\Models\Tag;
use App\Providers\RouteServiceProvider;
use App\Models\User;

test('users can access tags list', function () {
 $user = User::factory()->create([
    'email_verified_at' => null
 ]);

 $response = $this->actingAs($user)->get('/tags-list');


 $response->assertStatus(200);

});

test('users can create tags', function () {
    $user = User::factory()->create([
       'email_verified_at' => null
    ]);
   
    $response = $this->actingAs($user)->post('/tags-store', [
        'name' => 'anything'
    ]);
   
       
    $response->assertRedirect(RouteServiceProvider::TAGS_HOME);
   
});