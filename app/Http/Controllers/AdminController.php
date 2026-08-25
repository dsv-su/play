<?php

namespace App\Http\Controllers;

use App\Models\AdminHandler;
use App\Services\Daisy\DaisyAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('entitlements');
        $this->middleware('play-admin')->except(['emulateUser', 'findUser']);
    }

    public function emulateUser(Request $request)
    {
        // play_role is intentionally allowed to change while emulating.
        // Only real administrators can switch.
        abort_unless(app()->make('play_auth') === 'Administrator', 403);

        //Validate inputs
        $validated = $request->validate([
            'role' => [
                'required',
                Rule::in(['Administrator', 'Courseadmin', 'Uploader', 'Staff', 'Student', 'Student1', 'Student2', 'Student3', 'custom']),
            ],
            // only required when role === custom
            'custom' => ['nullable', 'string'],
        ]);

        //Detect Shibboleth session once
        $hasRemoteUser = (bool) $request->server('REMOTE_USER');
        $shibSessionId = $hasRemoteUser
            ? (string) $request->server('Shib_Session_ID')
            : '9999';

        // Helper to fetch or create the AdminHandler row for this session
        $adminhandler = AdminHandler::firstOrCreate(['Shib_Session_ID' => $shibSessionId]);

        // Branch by requested role
        if ($validated['role'] === 'Administrator') {
            // Administrator is always a clean, non-override state
            $adminhandler->fill([
                'override' => false,
                'custom'   => false,
                'role'     => 'Administrator',
                'user'     => '',
                'username' => '',
            ])->save();

            return back()->withInput();
        }

        if ($validated['role'] === 'custom') {
            //Normalize custom user id
            $input = (string) ($validated['custom'] ?? '');
            $userID = $input !== '' ? Str::before($input, '@') : '';

            //Guard against empty custom input
            if ($userID === '') {
                return back()->withErrors(['custom' => 'Please provide a username (sukat-id).'])->withInput();
            }

            //Fetch DAISY info
            $daisy  = new DaisyAPI();
            $person = null;

            try {
                $person = $daisy->getDaisyEmployee($userID); // expected: ['id','firstName','lastName', ...]
            } catch (\Throwable $e) {
                // Log the error but don’t expose internals to users
                \Log::warning('DAISY lookup failed', ['userID' => $userID, 'error' => $e->getMessage()]);
            }

            // Fallbacks if DAISY didn’t return expected data
            $fullName = ($person['person']['firstName'] ?? null) && ($person['person']['lastName'] ?? null)
                ? $person['person']['firstName'].' '.$person['person']['lastName']
                : $userID;

            //Decide role based on DAISY employee check; fallback to Student
            $role = 'Student';
            if (!empty($person['person']['id'])) {
                try {
                    $role = $daisy->checkifEmployee($person['person']['id']) ? 'Courseadmin' : 'Student';
                } catch (\Throwable $e) {
                    \Log::warning('DAISY employee check failed', ['personId' => $person['id'], 'error' => $e->getMessage()]);
                }
            }

            //Persist
            $adminhandler->fill([
                'override' => true,
                'custom'   => true,
                'username' => $userID,
                'user'     => $fullName,
                'role'     => $role,
            ])->save();

            return back()->withInput();
        }

        //Non-custom roles (Student / Courseadmin / Student1..3)
        $adminhandler->fill([
            'override' => true,
            'custom'   => false,
            'user'     => '',
            'username' => '',
            'role'     => $validated['role'],
        ])->save();

        //Redirect
        if (!$hasRemoteUser && in_array($adminhandler->role, ['Student', 'Student1', 'Student2', 'Student3'], true)) {
            return redirect()->route('home');
        }

        return back()->withInput();
    }

}
