<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['user_id','title','description'];

    public function users(){
    	return $this->belongsToMany('App\User','message_users');
    }

    public function attachments(){
    	return $this->belongsTo('App\Attachment');
    }
}
