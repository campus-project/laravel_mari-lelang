<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class WelcomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('welcome');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toc() {
        return view('toc');
    }

    public function contact(Request $request) {
        Telegram::sendMessage([
            'chat_id' => config('app.telegram_id'),
            'text' => $request->name . ' (' . $request->email . ')' . PHP_EOL . $request->comments,
        ]);

        return redirect()->to(url()->previous() . '#contact')->with('message', 'Thank you, i\'ll response fast your question.');
    }
}
