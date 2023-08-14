<?php

namespace Nahidferdous\Conversation\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Str;
use Nahidferdous\Conversation\Facades\Conversation;

class ConversationController extends Controller
{
    protected $perPage = 30;

    /**
     * Authenticate the connection for pusher
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function pusherAuth(Request $request)
    {
        return Conversation::pusherAuth(
            $request->user(),
            Auth::user(),
            $request['channel_name'],
            $request['socket_id']
        );
    }

    /**
     * Returning the view of the app with the required data.
     *
     * @param int|null $id
     * @return Application|Factory|View
     */
    public function index(int $id = null): View|Factory|Application
    {
        $user = Auth::user();
        $messenger_color = $user->messenger_color;
        return view('Conversation::pages.app', [
            'id' => $id ?? 0,
            'user' => $user,
            'messengerColor' => $messenger_color ? $messenger_color : Conversation::getFallbackColor(),
            'dark_mode' => $user->dark_mode < 1 ? 'light' : 'dark',
        ]);
    }
}
