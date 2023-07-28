<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['sender_id','receiver_id'];
    /**
     * Get the user that owns the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id')->select('id', 'name');
    }

    /**
     * Get the user that owns the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id')->select('id', 'name');
    }

    /**
     * Get the all message for chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id');
    }

    
}
