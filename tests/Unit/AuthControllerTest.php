<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\Auth\RegisterRequest;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the 'customer' role
        Role::firstOrCreate(['name' => 'customer']);
    }

    public function test_register_creates_user_and_returns_token()
    {
        // Arrange: Create a mock RegisterRequest with necessary data
        $request = RegisterRequest::create('/api/register', 'POST', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Act: Call the register method
        $controller = new AuthController();
        $response = $controller->register($request);

        // Assert: Check the response
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertEquals('register success', $responseData['message']);
        $this->assertArrayHasKey('token', $responseData['data']);

        // Assert: Check the user was created in the database
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_login_returns_token_with_valid_credentials()
    {
        // Arrange: Create a user
        $user = User::factory()->create([
            'email' => 'loginuser@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Create a mock request with valid credentials
        $request = Request::create('/api/login', 'POST', [
            'email' => 'loginuser@example.com',
            'password' => 'password123',
        ]);

        // Act: Call the login method
        $controller = new AuthController();
        $response = $controller->login($request);

        // Assert: Check the response
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertEquals('login success', $responseData['message']);
        $this->assertArrayHasKey('token', $responseData['data']);
    }

    public function test_login_returns_error_with_invalid_credentials()
    {
        // Arrange: Create a user
        $user = User::factory()->create([
            'email' => 'loginuser@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Create a mock request with invalid credentials
        $request = Request::create('/api/login', 'POST', [
            'email' => 'loginuser@example.com',
            'password' => 'wrongpassword',
        ]);

        // Act: Call the login method
        $controller = new AuthController();
        $response = $controller->login($request);

        // Assert: Check the response
        $this->assertEquals(401, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertEquals('Invalid credentials', $responseData['error']);
    }

    public function test_user_returns_authenticated_user_with_role()
    {
        // Arrange: Create a user with a role
        $role = Role::firstOrCreate(['name' => 'customer']);
        $user = User::factory()->create([
            'email' => 'authuser@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $role->id,
        ]);

        // Mock the auth facade to return the user
        Auth::shouldReceive('user')->once()->andReturn($user);

        // Act: Call the user method
        $controller = new AuthController();
        $response = $controller->user();

        // Assert: Check the response
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertEquals('get user success', $responseData['message']);
        $this->assertEquals('authuser@example.com', $responseData['data']['email']);
        $this->assertEquals('customer', $responseData['data']['role']['name']);
    }

    public function test_logout_logs_out_user()
    {
        // Mock the auth facade to expect logout
        Auth::shouldReceive('logout')->once();

        // Act: Call the logout method
        $controller = new AuthController();
        $response = $controller->logout();

        // Assert: Check the response
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertEquals('Successfully logged out', $responseData['message']);
    }
}
