<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    public function tg_user()
    {
        return $this->belongsTo(TelegramUser::class, 't_id');
    }
}
