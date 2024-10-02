<?php

namespace App\Http\Controllers;

use App\Services\TextToSpeechService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TextToSpeechController extends Controller
{
    protected $textToSpeechService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TextToSpeechService $textToSpeechService)
    {
        $this->textToSpeechService = $textToSpeechService;
    }


    public function speak(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'voiceName' => 'nullable|string',
            'languageCode' => 'nullable|string',
            'voiceGender' => 'nullable|string',
            'speakingRate' => 'nullable|numeric|min:0.25|max:4.0'
        ]);

        $text = $request->input('text');
        $languageCode = $request->input('languageCode', 'vi-VN');
        $voiceGender = $request->input('voiceGender', 'NEUTRAL');
        $speakingRate = $request->input('speakingRate', 1.0);
        $voiceName = $request->input('voiceName', 'vi-VN-Wavenet-A');
        $audioContent = $this->textToSpeechService->synthesizeSpeech($text, $languageCode, $voiceGender, $voiceName, $speakingRate);

        // Return audio content as response
        return Response::make($audioContent, 200, [
            'Content-Type' => 'audio/mpeg',
            'Content-Disposition' => 'attachment; filename="speech.mp3"',
        ]);
    }
}
