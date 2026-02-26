<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_registration_and_email_verification_flow()
    {
        $response = $this->post('/register', [
            'name'=>'John Doe',
            'email'=>'john@example.com',
            'password'=>'password',
            'password_confirmation'=>'password',
        ]);
        $response->assertRedirect('/email/verify');
        $user = User::where('email','john@example.com')->first();
        $this->assertNotNull($user);
        $this->assertFalse($user->hasVerifiedEmail());
    }

    public function test_admin_protected_route()
    {
        $admin = User::factory()->create(['role'=>'admin','email_verified_at'=>now()]);
        $this->actingAs($admin);
        $response = $this->get('/admin');
        $response->assertStatus(200);
    }
}
