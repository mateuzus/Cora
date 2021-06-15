<?php

namespace Tests\Feature;

use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ManagerDashBoardTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_dashboard()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $response = $this->get('/api/app/dashboard');

        $response->assertStatus(200);

    }
}
