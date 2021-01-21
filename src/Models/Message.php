<?php

namespace Kodio\LaravelMessaging\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public $table = 'kodio_messaging_messages';

    protected $fillable = [
        'target_user_id',
        'message',
        'title',
    ];

    public static function getLoggedUserMessages() {
        return Message::where('target_user_id', auth()->id())->with('sendedBy')->orderBy('created_at', 'DESC')->get();
    }

    public function isReaded() {
        return $this->readed == 1;
    }


    /**
     * Relationships
     */

    public function sendedBy() {
        return $this->belongsTo(User::class, 'sended_by_id');
    }

    public function targetUser() {
        return $this->belongsTo(User::class, 'target_user_id');
    }

}
