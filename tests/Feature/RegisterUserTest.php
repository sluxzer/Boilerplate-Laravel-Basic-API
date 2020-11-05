<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_is_guest(){
        $this->assertGuest();
    }

    public function test_register_new_user(){
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->post('/api/register', [
            'name' => 'John',
            'username' => 'johndoe',
            'password' => 'test',
            'email' => 'John@gmail.com'
        ]);

        $response->assertJson([
            'status' => true,
            'message' => 'Success Register'
        ]);
    }
}
