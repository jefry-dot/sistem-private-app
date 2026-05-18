<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\File;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileManagementTest extends TestCase
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
        $category = Category::create(['name' => 'General']);
        
        $file = File::create([
            'original_name' => 'old_name.pdf',
            'display_name' => 'Old Display Name',
            'file_path' => 'files/1.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.file.update', $file), [
            'display_name' => 'New Display Name',
            'description' => 'Updated description',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('admin.file.index'));
        $this->assertDatabaseHas('files', [
            'id' => $file->id,
            'display_name' => 'New Display Name',
            'description' => 'Updated description',
        ]);
    }

    /** @test */
    public function admin_can_update_file_access_permissions()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);
        $group = Group::create(['name' => 'Test Group']);
        $category = Category::create(['name' => 'General']);
        
        $file = File::create([
            'original_name' => 'test.pdf',
            'display_name' => 'Test PDF',
            'file_path' => 'files/1.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.file.update', $file), [
            'display_name' => 'Test PDF', // Required field
            'category_id' => $category->id,
            'user_ids' => [$client->id],
            'group_ids' => [$group->id],
        ]);

        $this->assertTrue($file->fresh()->users->contains($client->id));
        $this->assertTrue($file->fresh()->groups->contains($group->id));

        // Revoke access
        $this->actingAs($admin)->put(route('admin.file.update', $file), [
            'display_name' => 'Test PDF',
            'category_id' => $category->id,
            'user_ids' => [],
            'group_ids' => [],
        ]);

        $this->assertCount(0, $file->fresh()->users);
        $this->assertCount(0, $file->fresh()->groups);
    }

    /** @test */
    public function admin_can_delete_file_and_physical_storage()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);
        
        $filePath = 'files/to_delete.pdf';
        Storage::disk('private')->put($filePath, 'content');

        $file = File::create([
            'original_name' => 'to_delete.pdf',
            'display_name' => 'To Delete',
            'file_path' => $filePath,
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.file.destroy', $file));

        $this->assertDatabaseMissing('files', ['id' => $file->id]);
        Storage::disk('private')->assertMissing($filePath);
    }

    /** @test */
    public function admin_can_bulk_delete_files()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);
        
        $f1 = 'files/1.pdf';
        $f2 = 'files/2.pdf';
        Storage::disk('private')->put($f1, 'c1');
        Storage::disk('private')->put($f2, 'c2');

        $file1 = File::create(['original_name'=>'1.pdf','display_name'=>'1','file_path'=>$f1,'extension'=>'pdf','size'=>10,'category_id'=>$category->id,'uploaded_by'=>$admin->id]);
        $file2 = File::create(['original_name'=>'2.pdf','display_name'=>'2','file_path'=>$f2,'extension'=>'pdf','size'=>10,'category_id'=>$category->id,'uploaded_by'=>$admin->id]);

        $response = $this->actingAs($admin)->delete(route('admin.file.bulk-destroy'), [
            'files' => [$file1->id, $file2->id]
        ]);

        $this->assertDatabaseMissing('files', ['id' => $file1->id]);
        $this->assertDatabaseMissing('files', ['id' => $file2->id]);
        Storage::disk('private')->assertMissing($f1);
        Storage::disk('private')->assertMissing($f2);
    }

    /** @test */
    public function client_cannot_delete_files()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $client = User::factory()->create(['role' => 'client', 'status' => 'active']);
        $category = Category::create(['name' => 'General']);
        
        $file = File::create([
            'original_name' => 'protected.pdf',
            'display_name' => 'Protected',
            'file_path' => 'files/protected.pdf',
            'extension' => 'pdf',
            'size' => 1024,
            'category_id' => $category->id,
            'uploaded_by' => User::factory()->create(['role' => 'admin'])->id,
        ]);

        $response = $this->actingAs($client)->delete(route('admin.file.destroy', $file));

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('files', ['id' => $file->id]);
    }
}
