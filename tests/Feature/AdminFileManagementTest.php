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

class AdminFileManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('private');
    }

    /** @test */
    public function admin_can_update_file_metadata()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $oldCategory = Category::create(['name' => 'Old Category']);
        $newCategory = Category::create(['name' => 'New Category']);

        $file = File::create([
            'original_name' => 'test.pdf',
            'display_name' => 'Old Name',
            'description' => 'Old Description',
            'file_path' => 'files/test.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $oldCategory->id,
            'uploaded_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)
            ->put(route('admin.file.update', $file), [
                'display_name' => 'New Name',
                'description' => 'New Description',
                'category_id' => $newCategory->id,
            ]);

        $response->assertRedirect(route('admin.file.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('files', [
            'id' => $file->id,
            'display_name' => 'New Name',
            'description' => 'New Description',
            'category_id' => $newCategory->id,
        ]);
    }

    /** @test */
    public function admin_can_delete_file()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);

        // Upload a fake file first to have it in storage
        $uploadedFile = UploadedFile::fake()->create('to_delete.pdf', 100);
        $path = $uploadedFile->store('files', 'private');

        $file = File::create([
            'original_name' => 'to_delete.pdf',
            'display_name' => 'To Delete',
            'file_path' => $path,
            'extension' => 'pdf',
            'size' => 100,
            'category_id' => $category->id,
            'uploaded_by' => $admin->id,
        ]);

        Storage::disk('private')->assertExists($path);

        $response = $this->actingAs($admin)
            ->delete(route('admin.file.destroy', $file));

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('files', ['id' => $file->id]);
        Storage::disk('private')->assertMissing($path);
    }

    /** @test */
    public function admin_can_bulk_delete_files()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);

        $files = [];
        $paths = [];

        for ($i = 1; $i <= 3; $i++) {
            $uploadedFile = UploadedFile::fake()->create("bulk_$i.pdf", 100);
            $path = $uploadedFile->store('files', 'private');
            
            $file = File::create([
                'original_name' => "bulk_$i.pdf",
                'display_name' => "Bulk $i",
                'file_path' => $path,
                'extension' => 'pdf',
                'size' => 100,
                'category_id' => $category->id,
                'uploaded_by' => $admin->id,
            ]);

            $files[] = $file->id;
            $paths[] = $path;
            Storage::disk('private')->assertExists($path);
        }

        $response = $this->actingAs($admin)
            ->from(route('admin.file.index'))
            ->call('DELETE', route('admin.file.bulk-destroy'), [
                'files' => $files
            ]);

        $response->assertRedirect(route('admin.file.index'));
        $response->assertSessionHas('success');
        
        foreach ($files as $id) {
            $this->assertDatabaseMissing('files', ['id' => $id]);
        }

        foreach ($paths as $path) {
            Storage::disk('private')->assertMissing($path);
        }
    }
}
