<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JustSteveKing\Launchpad\Http\Responses\MessageResponse;

final class HomeController
{
    public function __invoke(Request $request): MessageResponse
    {
        return new MessageResponse(
            data: [
                'message' => __('messages.welcome'),
            ],
        );
    }
}
