<?php

namespace Database\Seeders;

use App\Models\VideoTutorial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;

class VideoTutorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $video_urls = [
                'https://www.youtube.com/watch?v=MDedqBwm-yI',
                'https://www.youtube.com/watch?v=viimfQi_pUw',
                'https://www.youtube.com/watch?v=DyDfgMOUjCI',
                'https://www.youtube.com/watch?v=MupKJq80V8o',
            ];

            foreach ($video_urls as $key => $url) {
                $video_key = $key + 1;
                $member_type_id = $key + 2;
                
                $video = VideoTutorial::create([
                    'name' => "Video Tutorial {$video_key}",
                    'member_type_id' => $member_type_id,
                    'url' => $url,
                ]);
            }

            DB::commit();
        } catch (Throwable $throw) {
            DB::rollBack();

            var_dump($throw);
        }
    }
}
