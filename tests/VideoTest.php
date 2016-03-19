<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use LearnParty\Http\Repositories\VideoRepository;

class VideoTest extends TestCase
{
    /**
     * Test get a single Video
     *
     * @return void
     */
    public function testGetVideo()
    {
        $video = factory('LearnParty\Video')->create();
        $searchVideo = $this->videoRepository->getVideo($video->id);

        $this->assertTrue(is_array($searchVideo->toArray()));
        $this->assertEquals($video->title, $searchVideo->title);
        $this->assertEquals($video->url, $searchVideo->url);
    }

    /**
     * Test that a user viewing a video is able to get all the
     * comments on a video
     *
     * @return void
     */
    public function testGetAllComments()
    {
        $video = factory('LearnParty\Video')->create();
        $comments = factory('LearnParty\Comment', 3)->create(['video_id' => 1]);

        $getComments = $this->videoRepository->getAllComments($video->id);

        $this->assertTrue(is_array($getComments->toArray()));
        $this->assertArrayHasKey('comment', $getComments->toArray()[0]);
        $this->assertArrayHasKey('video_id', $getComments->toArray()[0]);
        $this->assertEquals($comments[0]->comment, $getComments->toArray()[0]['comment']);
        $this->assertEquals($comments[0]->video_id, $getComments->toArray()[0]['video_id']);
    }
}