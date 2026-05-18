<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\File;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_dashboard_shows_correct_statistics()
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        
        // Setup data
        User::factory()->count(3)->create(['role' => 'client', 'status' => 'active']);
        User::factory()->count(2)->create(['role' => 'client', 'status' => 'pending']);
        Group::factory()->count(4)->create();
        
        $category = Category::create(['name' => 'General']);
        File::create([
            'original_name' => 'file1.pdf',
            'display_name' => 'File 1',
            'file_path' => 'files/1.pdf',
            'extension' => 'pdf',
            'size' => 1000,
            'category_id' => $category->id,
            'uploaded_by' => $admin->id,
        ]);
        File::create([
            'original_name' => 'file2.pdf',
            'display_name' => 'File 2',
            'file_path' => 'files/2.pdf',
            'extension' => 'pdf',
            'size' => 2000,
            'category_id' => $category->id,
            'uploaded_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        
        // Verify statistics in view (data passed to view)
        $response->assertViewHas('stats', function($stats) {
            return $stats['total_files'] === 2 &&
                   $stats['total_users'] === 5 && // 3 active + 2 pending
                   $stats['pending_users'] === 2 &&
                   $stats['total_groups'] === 4 &&
                   (int)$stats['total_size'] === 3000;
        });
    }

    /** @test */
    public function non_admin_cannot_access_admin_dashboard()
    {
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);

        $response = $this->actingAs($client)->get(route('admin.dashboard'));

        // Based on IsAdmin middleware, it redirects to 'dashboard' (which then redirects to client.dashboard)
        $response->assertRedirect(route('dashboard'));
    }
}
