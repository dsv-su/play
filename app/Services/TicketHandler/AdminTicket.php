<?php

namespace App\Services\TicketHandler;

use App\Video;

class AdminTicket extends TicketPermissionHandler implements \App\Interfaces\TicketInterface
{
    protected $video, $server, $server_entitlement;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
    }

    public function cast()
    {
        $this->server = explode(";", $_SERVER['entitlement']);
        foreach ($this->server as $this->server_entitlement) {
            if ($this->admin_entitlement() == $this->server_entitlement) {
                $this->video->setAttribute('ticket', true);
            }
        }

        return $this->video;
    }

    private function admin_entitlement()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(503);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['global']['admin'];
    }
}
