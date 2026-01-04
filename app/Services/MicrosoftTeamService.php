<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MicrosoftTeamService
{
    protected $webhookUrl;

    public function __construct()
    {
        $this->webhookUrl = env('MICROSOFT_TEAMS_WEBHOOK_URL');
    }

    public function sendMessage($message)
    {
        $payload = [
            'text' => $message,
        ];

        $response = Http::post($this->webhookUrl, $payload);

        if ($response->failed()) {
            Log::error('Microsoft Teams message send error:', ['response' => $response->body()]);
        }
    }
}
