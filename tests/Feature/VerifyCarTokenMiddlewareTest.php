<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCarToken;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class VerifyCarTokenMiddlewareTest extends TestCase
{
    protected $validToken = 'valid-secure-token-123';
    protected $invalidToken = 'invalid-token';
    protected $testRoute = '/v1/test';

    protected function setUp(): void
    {
        parent::setUp();
        
        // Manually register the test route
        Route::get($this->testRoute, function () {
            return response()->json(['message' => 'Success']);
        })->middleware(VerifyCarToken::class); // Use class directly here
        
        Config::set('services.car.token', $this->validToken);
    }

    public function test_block_requests_without_token()
    {
        $response = $this->get($this->testRoute);
        $response->assertStatus(401)
                 ->assertJson(['error' => 'Token não fornecido']);
    }

    public function test_block_requests_with_invalid_token()
    {
        $response = $this->withHeaders([
            'X-Car-Token' => $this->invalidToken
        ])->get($this->testRoute);

        $response->assertStatus(403)
                 ->assertJson(['error' => 'Token inválido']);
    }

    public function test_allow_requests_with_valid_token()
    {
        $response = $this->withHeaders([
            'X-Car-Token' => $this->validToken
        ])->get($this->testRoute);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Success']);
    }
}