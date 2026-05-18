<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\File;
use App\Models\DownloadLog;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a Category
        $category = Category::firstOrCreate(['name' => 'Dokumen Umum'], [
            'slug' => 'dokumen-umum'
        ]);

        // 2. Create a Client User if not exists
        $client = User::firstOrCreate(['username' => 'client'], [
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'status' => 'active',
        ]);

        $admin = User::where('role', 'admin')->first() ?? $client;

        // 3. Create a Dummy File
        $file = File::create([
            'category_id' => $category->id,
            'uploaded_by' => $admin->id,
            'original_name' => 'Contoh_Dokumen_Penting.pdf',
            'display_name' => 'Dokumen Penting V1',
            'file_path' => 'files/dummy.pdf',
            'extension' => 'pdf',
            'size' => 1024 * 500, // 500KB
            'visibility' => 'private',
        ]);

        // Attach file to client
        $file->users()->sync([$client->id]);

        // 4. Create Dummy Download Logs
        for ($i = 0; $i < 5; $i++) {
            DownloadLog::create([
                'user_id' => $client->id,
                'file_id' => $file->id,
                'ip_address' => '127.0.0.1',
                'downloaded_at' => now()->subHours(rand(1, 24)),
                'created_at' => now()->subHours(rand(1, 24)),
                'updated_at' => now(),
            ]);
        }
    }
}
