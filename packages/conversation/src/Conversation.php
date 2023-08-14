<?php

namespace NahidFerdous\Conversation;

use Nahidferdous\Conversation\Models\CMessage;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use Pusher\PusherException;

class Conversation
{
    public $pusher;

    /**
     * @throws PusherException
     */
    public function __construct()
    {
        $this->pusher = new Pusher(
            config('conversation.pusher.key'),
            config('conversation.pusher.secret'),
            config('conversation.pusher.app_id'),
            config('conversation.pusher.options'),
        );
    }

//    public function routes()
//    {
//        return __DIR__ . '/../routes/web.php';
//    }


    public function getMaxUploadSize(): float|int
    {
        return config('conversation.attachments.max_upload_size') * 1048576;
    }

    public function getAllowedImages()
    {
        return config('conversation.attachments.allowed_images');
    }

    public function getAllowedFiles()
    {
        return config('conversation.attachments.allowed_files');
    }

    public function getMessengerColors()
    {
        return config('conversation.colors');
    }

    public function getFallbackColor()
    {
        $colors = $this->getMessengerColors();
        return count($colors) > 0 ? $colors[0] : '#000000';
    }

    public function push($channel, $event, $data): object
    {
        return $this->pusher->trigger($channel, $event, $data);
    }

    public function pusherAuth($requestUser, $authUser, $channelName, $socket_id): \Illuminate\Http\JsonResponse|string
    {
        // Auth data
        $authData = json_encode([
            'user_id' => $authUser->id,
            'user_info' => [
                'name' => $authUser->name
            ]
        ]);
        // check if user authenticated
        if (Auth::check()) {
            if ($requestUser->id == $authUser->id) {
                return $this->pusher->socket_auth(
                    $channelName,
                    $socket_id,
                    $authData
                );
            }
            // if not authorized
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        // if not authenticated
        return response()->json(['message' => 'Not authenticated'], 403);
    }

    public function fetchMessagesQuery($user_id)
    {
        return CMessage::where('from_id', Auth::user()->id)->where('to_id', $user_id)
            ->orWhere('from_id', $user_id)->where('to_id', Auth::user()->id);
    }
}
