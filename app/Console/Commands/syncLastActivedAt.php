<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class syncLastActivedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:last-actived-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '任务调度同步到数据库最后的活跃时间';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        $this->info('开始同步活动时间数据...');
        $user->sysncLastActivedAt();
        $this->info('同步结束!!!');
    }
}
