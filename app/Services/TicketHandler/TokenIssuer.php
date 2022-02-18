<?php

namespace App\Services\TicketHandler;

use App\Video;

class TokenIssuer
{
    protected $credentials;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function issue()
    {
        $this->credentials = [
            'email'=> $this->ticket_user(),
            'password' => $this->ticket_pass()
        ];
        //Issue a valid ticket for requester
        if (!$this->token = auth()->claims(['id' => $this->video->id])->attempt($this->credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->token;
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
