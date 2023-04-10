<?php

namespace Wizard85\ChatGPTAssist\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatGPTNotAvailableException extends Exception
{
    public function render(Request $request)
    {
        return response()->json([
            'meaaseg' => 'ChatGPT is not available'
        ], 409);
    }
}
