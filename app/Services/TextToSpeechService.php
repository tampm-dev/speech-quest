<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TextToSpeechService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GOOGLE_CLOUD_API_KEY');
    }

    public function synthesizeSpeech($text, $languageCode = 'vi-VN', $voiceGender = 'MALE', $voiceName = 'vi-VN-Wavenet-A', $speakingRate = 1, $audioFormat = 'MP3')
    {
        $url = "https://texttospeech.googleapis.com/v1/text:synthesize?key={$this->apiKey}";

        $body = [
            'input' => ['text' => $text],
            'voice' => [
                'languageCode' => $languageCode,
                'name' => $voiceName,
                'ssmlGender' => $voiceGender,
            ],
            'audioConfig' => [
                'audioEncoding' => $audioFormat,
                'speakingRate' => $speakingRate,
            ],
        ];

        try {
            $response = $this->client->post($url, [
                'json' => $body
            ]);

            $responseBody = json_decode($response->getBody(), true);

            return base64_decode($responseBody['audioContent']); // Decode the base64 audio content
        } catch (RequestException $e) {
            // Handle error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
