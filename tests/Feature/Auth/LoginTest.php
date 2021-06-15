<?php

namespace Tests\Feature\Auth;

use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewLoginForm(){
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }
//    public function testUserCannotViewALoginFormWhenAuthenticated()
//    {
//        $user = User::factory()->create([
//            'password' => bcrypt($password = 'muffato-tasktok'),
//        ]);
//        $response = $this->actingAs($user)->get('/login');
//        $response->assertRedirect('/home');
//    }
//    public function test_user_can_login_with_correct_credentials()
//    {
//        $user = User::factory()->create([
//            'password' => bcrypt($password = 'muffato-tasktok'),
//        ]);
//
//        $response = $this->post('/login', [
//            'email' => $user->email,
//            'password' => $password,
//        ]);
//
//        $response->assertRedirect('/home');
//        $this->assertAuthenticatedAs($user);
//    }
//    public function test_user_cannot_login_with_incorrect_password()
//    {
//        $user = User::factory()->create([
//            'password' => bcrypt($password = 'muffato-tasktok'),
//        ]);
//
//        $response = $this->from('/login')->post('/login', [
//            'email' => $user->email,
//            'password' => 'invalid-password',
//        ]);
//
//        $response->assertRedirect('/login');
//        $response->assertSessionHasErrors('email');
//        $this->assertTrue(session()->hasOldInput('email'));
//        $this->assertFalse(session()->hasOldInput('password'));
//        $this->assertGuest();
//    }
}
