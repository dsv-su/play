<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class FaqController extends Controller
{
    public function __invoke(): View
    {
        $playRole = (string) app('play_role');

        $role = match (true) {
            $playRole === 'Administrator' => 'Administrator',
            $playRole === 'Uploader' => 'Uploader',
            $playRole === 'Courseadmin' => 'Courseadmin',
            $playRole === 'Student' || str_starts_with($playRole, 'Student') => 'Student',
            default => 'Staff',
        };

        return view('faq.index', compact('role'));
    }
}
