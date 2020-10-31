<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_is_guest(){
        $this->assertGuest();
    }

    public function test_a_user_failed_login_on_wrong_credential(){
        $response = $this->post('/api/login', [
            'email' => 'sluxzer@gmail.com',
            'password' => 'test123a',
        ]);

        $response
            ->assertJson([
                'status' => false,
                'message' => 'Wrong username or password'
            ]);
    }

    public function test_a_user_can_login(){
        $user = factory(User::class)->create([
            'email' => 'sluxzer@gmail.com',
            'username' => 'sluxzer',
            'password' => 'test123'
        ]);

        $response = $this->post('/api/login', [
            'email' => 'sluxzer@gmail.com',
            'password' => 'test123',
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure(['status', 'message', 'data'])
            ->assertJson([
                'status' => true,
                'message' => 'Success Login',
            ]);
    }

    public function test_a_user_can_view_profile(){
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->get('/api/profile');

        $response
            ->assertOk()
            ->assertJsonStructure(['status', 'message', 'data'])
            ->assertJson([
                'status' => true,
                'message' => 'Success get profile',
            ]);

    }
}
