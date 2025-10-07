<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewFollower extends Notification
{
    use Queueable;
    
    // フォローしたユーザーのモデルを受け取る
    protected $follower;

    public function __construct($follower)
    {
        $this->follower = $follower;
    }

    // どの通知チャネルを使うかを定義（ウェブ表示のため'database'を指定）
    public function via(object $notifiable): array
    {
        return ['database']; // データベースに保存する
    }

    // データベースに保存されるデータ配列を定義
    public function toDatabase(object $notifiable): array
    {
        return [
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'message' => $this->follower->name . 'があなたをフォローしました。',
        ];
    }
}