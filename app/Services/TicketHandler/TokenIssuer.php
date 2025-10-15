<?php

namespace App\Services\TicketHandler;

use App\Models\Video;

class TokenIssuer
{
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function issue()
    {
        $credentials = [
            'email'=> $this->ticket_user(),
            'password' => $this->ticket_pass()
        ];

        //Issue a valid ticket for requester
        $token = auth('api')->claims(['id' => $this->video->id])->attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
    }

    private function ticket_user()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(503);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['ticket']['email'];
    }

    private function ticket_pass()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(503);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['ticket']['password'];
    }
}
