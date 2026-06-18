<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DashboardRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_dashboards_render_successfully(): void
    {
        $roles = [
            'hr' => 'dashboard.hr',
            'direktur' => 'dashboard.direktur',
            'karyawan' => 'dashboard.karyawan',
        ];

        foreach ($roles as $role => $routeName) {
            $user = User::create([
                'username' => $role . '-dashboard',
                'email' => $role . '-dashboard@example.com',
                'password' => Hash::make('password'),
                'akses_user' => $role,
            ]);

            $response = $this->actingAs($user)->get(route($routeName));

            $response->assertOk();
        }
    }

    public function test_login_redirects_to_authenticated_users_role_dashboard(): void
    {
        $user = User::create([
            'username' => 'director-login',
            'email' => 'director-login@example.com',
            'password' => Hash::make('password'),
            'akses_user' => 'direktur',
        ]);

        $response = $this
            ->withSession(['url.intended' => route('dashboard.hr')])
            ->post(route('login.attempt'), [
                'username' => $user->username,
                'password' => 'password',
            ]);

        $response->assertRedirect(route('dashboard.direktur', absolute: false));
    }

    public function test_user_factory_matches_users_table_schema(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->username);
        $this->assertSame('karyawan', $user->akses_user);
    }
}
