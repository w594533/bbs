<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class syncCalculateActivedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:calcate_actived_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '计算活跃用户';

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
        $this->info('开始计算活跃用户...');
        $user->syncCalculateActivedUsers();
        $this->info('结束计算');
    }
}
