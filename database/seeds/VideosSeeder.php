<?php

use Carbon\Carbon;
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
        DB::table('videos')->insert([
            'title' => 'Bastad',
            'length' => '00:03',
            'image' =>  './images/videocovers/kurs1.jpg',
            'source1' => './testvideos/bastad/media/bastad_dev-cattura-video-eco0000-04-00-0--0.mp4',
            'source2' => './testvideos/bastad/media/bastad_dev-cattura-video-eco0000-04-00-0--1.mp4',
            'source3' => './testvideos/bastad/media/bastad_dev-cattura-video-eco0000-05-00-0--0.mp4',
            'source4' => './testvideos/bastad/media/bastad_dev-cattura-video-eco0000-05-00-0--1.mp4',
            'course_id' => 3,
            'category_id' => 3,
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('videos')->insert([
            'title' => 'Boras',
            'length' => '00:00',
            'image' =>  './images/videocovers/kurs2.jpg',
            'source1' => './testvideos/Boras/media/Boras_dev-cattura-video-eco0000-04-00-0--0.mp4',
            'source2' => './testvideos/Boras/media/Boras_dev-cattura-video-eco0000-04-00-0--1.mp4',
            'source3' => './testvideos/Boras/media/Boras_dev-cattura-video-eco0000-05-00-0--0.mp4',
            'source4' => './testvideos/Boras/media/Boras_dev-cattura-video-eco0000-05-00-0--0.mp4',
            'course_id' => 3,
            'category_id' => 3,
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('videos')->insert([
            'title' => 'DB HT16 Lecture 4',
            'length' => '01:44',
            'image' =>  './images/videocovers/kurs3.jpg',
            'source1' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/c8bc3722-8291-4012-86bb-5d7c834a6981.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source2' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/dad1db70-512f-4149-a892-c1ffa342e128.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source3' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/4cbea3cf-9b84-40af-9d49-ed50f72552f2.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source4' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/4cbea3cf-9b84-40af-9d49-ed50f72552f2.mp4?playbackTicket=&site=play2.dsv.su.se',
            'course_id' => 1,
            'category_id' => 1,
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('videos')->insert([
            'title' => 'DB HT16 Lecture 5',
            'length' => '01:49',
            'image' =>  './images/videocovers/kurs4.jpg',
            'source1' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/a1a423d3-42b7-4907-b890-fedeb1fa6565.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source2' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/850430ee-f9d2-41b6-93a3-9667a542f4af.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source3' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/850430ee-f9d2-41b6-93a3-9667a542f4af.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source4' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/850430ee-f9d2-41b6-93a3-9667a542f4af.mp4?playbackTicket=&site=play2.dsv.su.se',
            'course_id' => 1,
            'category_id' => 1,
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('videos')->insert([
            'title' => 'DB HT16 Lecture 6',
            'length' => '01:34',
            'image' =>  './images/videocovers/kurs5.jpg',
            'source1' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/c1e8af27-1b43-412f-baf9-d26a8d265199.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source2' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/01d28d0b-fc05-4f00-9dbb-8ec4e06731aa.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source3' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/7dd07486-f5c6-4439-ad00-4ab7aaf24f3c.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source4' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/7dd07486-f5c6-4439-ad00-4ab7aaf24f3c.mp4?playbackTicket=&site=play2.dsv.su.se',
            'course_id' => 1,
            'category_id' => 1,
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('videos')->insert([
            'title' => 'DB HT16 Lecture 7',
            'length' => '01:33',
            'image' =>  './images/videocovers/kurs6.jpg',
            'source1' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/ce62731c-294c-4940-85eb-f73ec5391a6f.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source2' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/cc06f79c-c21b-4a67-b62d-c3ed23084dc8.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source3' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/d6dccaee-e99f-4b48-821a-8f975a217e69.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source4' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/d6dccaee-e99f-4b48-821a-8f975a217e69.mp4?playbackTicket=&site=play2.dsv.su.se',
            'course_id' => 1,
            'category_id' => 1,
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('videos')->insert([
            'title' => 'GB HT2018 Lecture 1',
            'length' => '00:58',
            'image' =>  './images/videocovers/kurs7.jpg',
            'source1' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/76da3f7f-55ce-4a9e-9f15-d589c729a6ab.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source2' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/788141a9-f0c3-498c-ab9e-1d63b2696544.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source3' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/e0bcd99e-4591-41b3-81ef-8ac9effce210.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source4' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/e0bcd99e-4591-41b3-81ef-8ac9effce210.mp4?playbackTicket=&site=play2.dsv.su.se',
            'course_id' => 2,
            'category_id' => 2,
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('videos')->insert([
            'title' => 'GB HT2018 Lecture 2',
            'length' => '01:38',
            'image' =>  './images/videocovers/kurs8.jpg',
            'source1' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/b5b4ba2e-7e2e-4765-8f6f-fe70fb148786.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source2' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/1448fb46-42d0-4c50-8b4e-e70090610012.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source3' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/e7766c33-5afb-4ca1-a9ac-320af0001fb4.mp4?playbackTicket=&site=play2.dsv.su.se',
            'source4' => 'https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/e7766c33-5afb-4ca1-a9ac-320af0001fb4.mp4?playbackTicket=&site=play2.dsv.su.se',
            'course_id' => 2,
            'category_id' => 2,
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        /*
        DB::table('videos')->insert([
            'title' => '',
            'length' => '',
            'image' =>  './images/videocovers/kurs1.jpg',
            'source1' => '',
            'source2' => '',
            'source3' => '',
            'source4' => '',
            'course_id' => 1,
            'category_id' => 1,
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        */
    }
}
