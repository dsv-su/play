<?php

use Illuminate\Database\Seeder;

class VideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory('App\Video', 10)->create();
        DB::table('videos')->insert([
            'title' => 'Lecture 1',
            'name' => 'Lecture 1',
            'length' => '00:09',
            'source1' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/9e5f2d1c-4c1d-48e8-8502-f00b9f0f0d79.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source2' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/fabefa3e-6758-468b-aae1-b7b512d084fa.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source3' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/2af810b8-1e59-4215-9f71-be097c1f88fb.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source4' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/2af810b8-1e59-4215-9f71-be097c1f88fb.mp4?playbackTicket=&site=play2.dsv.su.se',
            'course_id' => 1,
            'category_id' => 1,
        ]);
        DB::table('videos')->insert([
            'title' => 'Lecture 3',
            'name' => 'Lecture 3',
            'length' => '01:40',
            'source1' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/3d6766fe-9d77-429c-9120-2ed564b891bc.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source2' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/f99c14e8-e13b-46e9-a10d-00ff67379acb.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source3' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/e420023f-b272-4c98-a155-2cefabcf546f.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source4' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/e420023f-b272-4c98-a155-2cefabcf546f.mp4?playbackTicket=&site=play2.dsv.su.se',
            'course_id' => 1,
            'category_id' => 1,
        ]);
        DB::table('videos')->insert([
            'title' => 'Lecture 4',
            'name' => 'Lecture 4',
            'length' => '01:44',
            'source1' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/c8bc3722-8291-4012-86bb-5d7c834a6981.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source2' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/dad1db70-512f-4149-a892-c1ffa342e128.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source3' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/4cbea3cf-9b84-40af-9d49-ed50f72552f2.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source4' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/4cbea3cf-9b84-40af-9d49-ed50f72552f2.mp4?playbackTicket=&site=play2.dsv.su.se',
            'course_id' => 1,
            'category_id' => 1,
        ]);
        DB::table('videos')->insert([
            'title' => 'Lecture 5',
            'name' => 'Lecture 5',
            'length' => '01:49',
            'source1' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/a1a423d3-42b7-4907-b890-fedeb1fa6565.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source2' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/850430ee-f9d2-41b6-93a3-9667a542f4af.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source3' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/bf879a7e-7773-4abb-a434-e968fd2d2e7b.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source4' => '',
            'course_id' => 1,
            'category_id' => 1,
        ]);
        /*
        DB::table('videos')->insert([
            'title' => 'Lecture 3',
            'name' => 'Lecture 3',
            'length' => '01:40',
            'source1' => '',
            'source2' => '',
            'source3' => '',
            'source4' => '',
            'course_id' => 1,
            'category_id' => 1,
        ]);
        */
    }
}
