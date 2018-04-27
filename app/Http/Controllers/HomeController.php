<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard() {

        $messages = Message::all();

        $messages_mod = $messages->map(function ($item, $key) {
            $res = [
                'id' => $item->id,
                'position' => [
                    'lat' => (float) $item->lat,
                    'lng' => (float) $item->lng
                ],
                'message' => $item
            ];
            $res['message']->date = date('Y-m-d H:i:s', $item->time);
            return $res;
        });

        $data = [
            'isGuest' => ! \Auth::check(),
            'icon_url' => asset('images/icon.png'),
            'login' => [
                'url' => route('login'),
                'text' => __('Login')
            ],
            'register' => [
                'url' => route('register'),
                'text' => __('Register')
            ],
            'logout' => [
                'url' => route('logout'),
                'text' => __('Logout')
            ],
            'messages' => $messages_mod
        ];
        return view('dashboard', ['data' => json_encode($data)]);
    }
}
