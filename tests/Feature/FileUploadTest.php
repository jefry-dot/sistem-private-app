<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\File;
use App\Models\User;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('private');
    }

    /** @test */
    public function admin_can_upload_valid_file()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);

        $response = $this->actingAs($admin)
            ->from(route('admin.file.create'))
            ->post(route('admin.file.store'), [
                'file' => UploadedFile::fake()->create('document.pdf', 100),
                'display_name' => 'Test Document',
                'category_id' => $category->id,
                'description' => 'A test description',
            ]);

        $response->assertRedirect(route('admin.file.create'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('files', [
            'original_name' => 'document.pdf',
            'display_name' => 'Test Document',
            'category_id' => $category->id,
            'uploaded_by' => $admin->id,
        ]);

        $file = File::where('original_name', 'document.pdf')->first();
        Storage::disk('private')->assertExists($file->file_path);
    }

    /** @test */
    public function admin_cannot_upload_invalid_file_type()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);

        $response = $this->actingAs($admin)
            ->from(route('admin.file.create'))
            ->post(route('admin.file.store'), [
                'file' => UploadedFile::fake()->create('malicious.exe', 100),
                'category_id' => $category->id,
            ]);

        $response->assertRedirect(route('admin.file.create'));
        $response->assertSessionHasErrors(['file']);
        $this->assertDatabaseCount('files', 0);
    }

    /** @test */
    public function admin_cannot_upload_large_file()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);

        // Limit is 50MB (51200 KB)
        $response = $this->actingAs($admin)
            ->from(route('admin.file.create'))
            ->post(route('admin.file.store'), [
                'file' => UploadedFile::fake()->create('huge.pdf', 60000), 
                'category_id' => $category->id,
            ]);

        $response->assertRedirect(route('admin.file.create'));
        $response->assertSessionHasErrors(['file']);
        $this->assertDatabaseCount('files', 0);
    }

    /** @test */
    public function client_cannot_upload_file()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);

        $response = $this->actingAs($client)
            ->post(route('admin.file.store'), [
                'file' => UploadedFile::fake()->create('document.pdf', 100),
                'category_id' => $category->id,
            ]);

        // IsAdmin middleware redirects to 'dashboard'
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseCount('files', 0);
    }

    /** @test */
    public function upload_requires_category()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);

        $response = $this->actingAs($admin)
            ->from(route('admin.file.create'))
            ->post(route('admin.file.store'), [
                'file' => UploadedFile::fake()->create('document.pdf', 100),
                // 'category_id' missing
            ]);

        $response->assertRedirect(route('admin.file.create'));
        $response->assertSessionHasErrors(['category_id']);
    }

    /** @test */
    public function upload_prevents_duplicate_names()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);

        // Create first file
        File::create([
            'original_name' => 'duplicate.pdf',
            'display_name' => 'Duplicate PDF',
            'file_path' => 'files/dup.pdf',
            'extension' => 'pdf',
            'size' => 100,
            'category_id' => $category->id,
            'uploaded_by' => $admin->id,
        ]);

        // Attempt to upload file with same original name
        $response = $this->actingAs($admin)
            ->from(route('admin.file.create'))
            ->post(route('admin.file.store'), [
                'file' => UploadedFile::fake()->create('duplicate.pdf', 100),
                'category_id' => $category->id,
            ]);

        $response->assertRedirect(route('admin.file.create'));
        $response->assertSessionHasErrors(['file']);
        $this->assertDatabaseCount('files', 1);
    }

    /** @test */
    public function admin_can_upload_file_with_group_access()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);
        $group = Group::create(['name' => 'Test Group']);

        $response = $this->actingAs($admin)
            ->from(route('admin.file.create'))
            ->post(route('admin.file.store'), [
                'file' => UploadedFile::fake()->create('group_document.pdf', 100),
                'category_id' => $category->id,
                'groups' => [$group->id],
            ]);

        $response->assertRedirect(route('admin.file.create'));
        $response->assertSessionHas('success');

        $file = File::where('original_name', 'group_document.pdf')->first();
        $this->assertTrue($file->groups->contains($group->id));
    }


}
