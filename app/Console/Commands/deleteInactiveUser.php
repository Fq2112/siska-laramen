<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class deleteInactiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inactiveUser:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleting the inactive user';

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
    public function handle()
    {
        $users = User::where('status', false)->wherenotnull('verifyToken')
            ->whereDate('created_at', '<=', now()->subWeek())->get();

        foreach ($users as $user) {
            $user->forceDelete();
        }
    }
}
