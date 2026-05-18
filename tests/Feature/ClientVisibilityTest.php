<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\File;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientVisibilityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function client_can_see_files_shared_directly_with_them()
    {
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);
        
        $sharedFile = File::create([
            'original_name' => 'shared_direct.pdf',
            'display_name' => 'Shared Directly',
            'file_path' => 'files/1.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => User::factory()->create(['role' => 'admin'])->id,
        ]);
        $sharedFile->users()->attach($client->id);

        $unsharedFile = File::create([
            'original_name' => 'secret.pdf',
            'display_name' => 'Secret File',
            'file_path' => 'files/2.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => User::factory()->create(['role' => 'admin'])->id,
        ]);

        $response = $this->actingAs($client)->get(route('client.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Shared Directly');
        $response->assertDontSee('Secret File');
    }

    /** @test */
    public function client_can_see_files_shared_via_group()
    {
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);
        $group = Group::create(['name' => 'Clients Group']);
        $client->groups()->attach($group->id);

        $category = Category::create(['name' => 'General']);
        
        $groupFile = File::create([
            'original_name' => 'group_file.pdf',
            'display_name' => 'Group File',
            'file_path' => 'files/group.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => User::factory()->create(['role' => 'admin'])->id,
        ]);
        $groupFile->groups()->attach($group->id);

        $response = $this->actingAs($client)->get(route('client.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Group File');
    }

    /** @test */
    public function client_dashboard_shows_only_relevant_categories()
    {
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);
        $categoryShared = Category::create(['name' => 'Shared Category']);
        $categoryHidden = Category::create(['name' => 'Hidden Category']);
        
        $sharedFile = File::create([
            'original_name' => 'shared.pdf',
            'display_name' => 'Shared File',
            'file_path' => 'files/1.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $categoryShared->id,
            'uploaded_by' => User::factory()->create(['role' => 'admin'])->id,
        ]);
        $sharedFile->users()->attach($client->id);

        // File in hidden category not shared with this client
        File::create([
            'original_name' => 'hidden.pdf',
            'display_name' => 'Hidden File',
            'file_path' => 'files/2.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $categoryHidden->id,
            'uploaded_by' => User::factory()->create(['role' => 'admin'])->id,
        ]);

        $response = $this->actingAs($client)->get(route('client.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Shared Category');
        $response->assertDontSee('Hidden Category');
    }

    /** @test */
    public function search_filters_client_files_correctly()
    {
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);
        
        $file1 = File::create([
            'original_name' => 'report_2024.pdf',
            'display_name' => 'Report 2024',
            'file_path' => 'files/1.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => User::factory()->create(['role' => 'admin'])->id,
        ]);
        $file1->users()->attach($client->id);

        $file2 = File::create([
            'original_name' => 'invoice.pdf',
            'display_name' => 'Invoice File',
            'file_path' => 'files/2.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => $admin_id = User::factory()->create(['role' => 'admin'])->id,
        ]);
        $file2->users()->attach($client->id);

        // Search for 'report'
        $response = $this->actingAs($client)->get(route('client.dashboard', ['q' => 'report']));

        $response->assertStatus(200);
        $response->assertSee('Report 2024');
        $response->assertDontSee('Invoice File');
    }

}
