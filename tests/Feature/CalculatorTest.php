<?php

namespace Tests\Feature;

use App\Models\Calculation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CalculatorTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCalculate()
    {
        $response = $this->postJson('/api/calculator/calculate', ['expression' => 'sqrt(((((9*9)/12)+(13-4))*2)^2)']);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'expression' => 'sqrt(((((9*9)/12)+(13-4))*2)^2)',
                'result' => 31.5
            ]);
    }
}
