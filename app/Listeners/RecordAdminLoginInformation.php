<?php

namespace App\Listeners;

use App\Events\AdminAuthenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Jenssegers\Agent\Facades\Agent;

class RecordAdminLoginInformation implements ShouldQueue
{
    /**
     * 任务将被发送到的队列的名称。
     *
     * @var string|null
     */
    public $queue = 'listeners';

    /**
     * 任务被处理的延迟时间（秒）。
     *
     * @var int
     */
    public $delay = 5;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AdminAuthenticated $event)
    {
        // 设置 UserAgent and HttpHeaders
        Agent::setUserAgent($event->headers->get('USER_AGENT'));
        Agent::setHttpHeaders($event->headers->all());

        // 存储登录日志
        $event->admins->logged()->create([
            'ipv4' => $event->ip,
            'address' => '',
            'platform' => Agent::browser(), // 获取浏览器
        ]);
    }
}
