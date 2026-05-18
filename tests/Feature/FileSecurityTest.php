<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\File;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('private');
    }

    /** @test */
    public function admin_can_download_any_file()
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);
        
        $file = File::create([
            'original_name' => 'secret.pdf',
            'display_name' => 'Secret Document',
            'file_path' => 'files/secret.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => User::factory()->create()->id,
        ]);

        Storage::disk('private')->put('files/secret.pdf', 'fake content');

        $response = $this->actingAs($admin)->get(route('file.download', $file));

        $response->assertStatus(200);
        $this->assertStringContainsString('secret.pdf', $response->headers->get('content-disposition'));
        $this->assertDatabaseHas('download_logs', [
            'user_id' => $admin->id,
            'file_id' => $file->id,
        ]);
    }

    /** @test */
    public function client_cannot_download_unshared_file()
    {
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);
        
        $file = File::create([
            'original_name' => 'private.pdf',
            'display_name' => 'Private Document',
            'file_path' => 'files/private.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => User::factory()->create()->id,
        ]);

        Storage::disk('private')->put('files/private.pdf', 'fake content');

        $response = $this->actingAs($client)->get(route('file.download', $file));

        $response->assertStatus(403);
        $this->assertDatabaseMissing('download_logs', [
            'user_id' => $client->id,
            'file_id' => $file->id,
        ]);
    }

    /** @test */
    public function client_can_download_shared_file_directly()
    {
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);
        
        $file = File::create([
            'original_name' => 'shared.pdf',
            'display_name' => 'Shared Document',
            'file_path' => 'files/shared.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => User::factory()->create()->id,
        ]);

        $file->users()->attach($client->id);
        Storage::disk('private')->put('files/shared.pdf', 'fake content');

        $response = $this->actingAs($client)->get(route('file.download', $file));

        $response->assertStatus(200);
        $this->assertDatabaseHas('download_logs', [
            'user_id' => $client->id,
            'file_id' => $file->id,
        ]);
    }

    /** @test */
    public function client_can_download_file_shared_via_group()
    {
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);
        $group = Group::create(['name' => 'Premium Clients']);
        $client->groups()->attach($group->id);

        $category = Category::create(['name' => 'General']);
        
        $file = File::create([
            'original_name' => 'group_file.pdf',
            'display_name' => 'Group Document',
            'file_path' => 'files/group_file.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => User::factory()->create()->id,
        ]);

        $file->groups()->attach($group->id);
        Storage::disk('private')->put('files/group_file.pdf', 'fake content');

        $response = $this->actingAs($client)->get(route('file.download', $file));

        $response->assertStatus(200);
    }
}
