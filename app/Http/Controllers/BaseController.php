<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Services\MicrosoftTeamService;

class BaseController extends Controller
{
    protected $teamService;

    /**
     * Constructor to inject MicrosoftTeamService.
     */
    public function __construct(MicrosoftTeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * Success response method.
     *
     * @param  mixed  $result
     * @param  string  $message
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message = '')
    {
        $response = [
            'status' => true,
            'response' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * Return error response.
     *
     * @param  string  $error
     * @param  array  $errorMessages
     * @param  int  $code
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'status' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
            $this->teamService->sendMessage(json_encode(is_array($$errorMessages) ? $errorMessages : ['message' => $errorMessages], JSON_PRETTY_PRINT));
        }

        return response()->json($response, $code);
    }
    protected function checkAccess($access, $action)
    {

        if ($access[$action] != 'Y') {
            return ['status' => false, 'message' => "You don't have access to perform this action", 'code' => 403];
        }
    }

    protected function accessCheck($type)
    {
        return checkAccessPrivileges($type);
    }

    public function uploadfiles($file, $folder)
    {
        $filename = $folder . '/' .uniqid(). str_replace(' ', '', date('y-m-d-h-i-s') . '' . preg_replace('/\s+/','',str_replace('%','',$file->getClientOriginalName())));
        $file->move($folder, $filename);
        return str_replace('admin/', '', $filename);
    }

    public function removePublicFile($file_path)
    {
        @unlink(public_path($file_path));
    }
}
