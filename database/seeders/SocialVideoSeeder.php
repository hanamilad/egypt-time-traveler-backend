<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialVideo;

class SocialVideoSeeder extends Seeder
{
    public function run()
    {
        SocialVideo::create([
            'platform' => 'youtube',
            'url' => 'https://www.youtube.com/shorts/EMDpyAIau6c',
            'is_active' => true,
        ]);

        SocialVideo::create([
            'platform' => 'youtube',
            'url' => 'https://www.youtube.com/watch?v=S51FDACCwkQ',
            'is_active' => true,
        ]);
    }
}
