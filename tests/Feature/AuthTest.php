<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testRegister()
    {
        $response = $this->json('POST', '/register', [
            'name'  =>  $name = 'Test',
            'email'  =>  $email = time().'test@example.com',
            'password'  =>  $password = '123456789',
            'password_confirmation' => '123456789',
        ]);

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(201)->assertJson([]);

        User::where('email',$email)->delete();
    }

    public function testLogin()
    {
        User::create([
            'name' => 'Test',
            'email'=> 'testcase@gmail.com',
            'password' => $password = bcrypt('123456789')
        ]);

        $response = $this->json('POST',route('login'),[
            'email' => 'testcase@gmail.com',
            'password' => '123456789',
        ]);

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(204);

        User::where('email','testcase@gmail.com')->delete();
    }
}
