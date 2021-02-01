<?php

namespace App\Services;

use App\Services\Course\CourseStore;
use App\Services\Presenter\PresenterStore;
use App\Services\Tag\TagsStore;
use App\Services\Video\VideoStore;
use App\Services\Video\VideoUpdate;
use App\Video;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReLoadPlayStore extends Model
{

    public function reloadlist()
    {
        return $this->getAllPresentations('presentation');
    }

    public function reloadpresentation($id)
    {
        return $this->getPresentation('presentation/'.$id);
    }

    public function reloadstore(Request $request)
    {
        //Check if video exist
        if(!$presentation = Video::find($request->id)) {
            //Store video
            $video = new VideoStore($request);
            $video = $video->presentation();
            //Store presenter
            $presenter = new PresenterStore($request, $video);
            $presenter->presenter();
            //Store course
            $course = new CourseStore($request, $video);
            $course->course();
            //Store tags
            $tags = new TagsStore($request, $video);
            $tags->tags();
        }
        else {
            //Update existing video
            $video = new VideoUpdate($presentation, $request);
            $video = $video->presentation_update();
            //Store presenter
            $presenter = new PresenterStore($request, $video);
            $presenter->presenter();
            //Store course
            $course = new CourseStore($request, $video);
            $course->course();
            //Store tags
            $tags = new TagsStore($request, $video);
            $tags->tags();

            return response()->json('Presentation has been updated', Response::HTTP_CREATED);
        }


        return response()->json('Presentation has been created', Response::HTTP_CREATED);
    }

    private function getPresentation($uri)
    {
        $client = new Client(['base_uri' => $this->uri()]);
        $headers = [
            //'Authorization' => 'Bearer ' . $this->token(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        try {
            $response = $client->request('GET', $uri, [
                'headers' => $headers,
            ]);
        } catch (Exception $e) {
            /**
             * If there is an exception; Client error;
             */
            if ($e->hasResponse()) {
                //return $response = $e->getResponse()->getStatusCode();

                return $response = $e->getResponse()->getBody();
            }
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    private function getAllPresentations($uri)
    {
        $client = new Client(['base_uri' => $this->uri()]);
        $headers = [
            //'Authorization' => 'Bearer ' . $this->token(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        try {
            $response = $client->request('GET', $uri, [
                'headers' => $headers,
            ]);
        } catch (Exception $e) {
            /**
             * If there is an exception; Client error;
             */
            if ($e->hasResponse()) {
                //return $response = $e->getResponse()->getStatusCode();


                return $response = $e->getResponse()->getBody();
            }
        }

        return json_decode($response->getBody()->getContents(), true);


    }

    private function uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['sftp']['reload'];
    }
}
