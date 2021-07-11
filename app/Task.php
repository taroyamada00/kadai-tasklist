<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //$fillable を設定
    protected $fillable = ['content','status',];
    
    //この投稿を所有するユーザ。（Userモデルとの関係を定義）
    public function user() {
        return $this->belongsTo(User::class);
    }
}
