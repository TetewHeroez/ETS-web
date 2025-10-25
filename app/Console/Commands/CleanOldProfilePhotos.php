<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CleanOldProfilePhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:clean-old-photos {--force : Force clean without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old profile photos (local storage paths) from database and set to NULL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Scanning for old profile photos...');
        
        // Find users dengan foto path local storage (bukan URL Cloudinary)
        $usersWithOldPhotos = User::whereNotNull('profile_photo')
            ->where(function($query) {
                $query->where('profile_photo', 'not like', 'http://%')
                      ->where('profile_photo', 'not like', 'https://%');
            })
            ->get();
        
        $count = $usersWithOldPhotos->count();
        
        if ($count === 0) {
            $this->info('✅ No old profile photos found. All clean!');
            return Command::SUCCESS;
        }
        
        $this->warn("Found {$count} user(s) with old profile photo paths:");
        
        // Tampilkan list users
        $this->table(
            ['ID', 'Name', 'Email', 'Old Photo Path'],
            $usersWithOldPhotos->map(function($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    \Str::limit($user->profile_photo, 50)
                ];
            })
        );
        
        // Konfirmasi
        if (!$this->option('force') && !$this->confirm('Do you want to clean these old photo paths?', true)) {
            $this->info('Operation cancelled.');
            return Command::SUCCESS;
        }
        
        $this->info('🧹 Cleaning old profile photos...');
        
        $progressBar = $this->output->createProgressBar($count);
        $progressBar->start();
        
        $cleaned = 0;
        
        foreach ($usersWithOldPhotos as $user) {
            try {
                // Set profile_photo ke NULL
                $user->profile_photo = null;
                $user->save();
                
                $cleaned++;
            } catch (\Exception $e) {
                $this->error("\nFailed to clean photo for user {$user->id}: " . $e->getMessage());
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine(2);
        
        $this->info("✅ Successfully cleaned {$cleaned} old profile photo path(s)!");
        $this->info('💡 Users can now upload new photos to Cloudinary.');
        
        return Command::SUCCESS;
    }
}
