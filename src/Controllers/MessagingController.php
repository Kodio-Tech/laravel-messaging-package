<?php

namespace Kodio\LaravelMessaging\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kodio\LaravelMessaging\Models\Message;
use Kodio\LaravelMessaging\Requests\MessagingRequest;

class MessagingController extends Controller
{
    /**
     * Send the message to the target user/s
     *
     * @param MessagingRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function postSendMessage(MessagingRequest $request) {
        $message = new Message($request->except('_token'));

        $message->sended_by_id = auth()->id();

        if($message->save()) {
            return redirect()->back()->with('status', 'sended');
        }

        return redirect()->back()->withErrors(['status' => 'error'])->withInput();
    }

    /**
     * Mark message as readed
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function getMarkAsReaded(Request $request, Message $message) {
        if(auth()->id() != $message->target_user_id) return redirect()->back()->withErrors(['status' => 'error'])->withInput();

        $message->readed = true;

        if($message->save()) {
            return redirect()->back()->with('status', 'readed');
        }

        return redirect()->back()->withErrors(['status' => 'error'])->withInput();
    }
}
