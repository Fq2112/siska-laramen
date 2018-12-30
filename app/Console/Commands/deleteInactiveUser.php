<?php

namespace App\Console\Commands;

use App\PartnerCredential;
use App\User;
use GuzzleHttp\Client;
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

            $partners = PartnerCredential::where('status', true)->where('isSync', true)
                ->whereDate('api_expiry', '>=', today())->get();
            if (count($partners) > 0) {
                foreach ($partners as $partner) {
                    $client = new Client([
                        'base_uri' => $partner->uri,
                        'defaults' => [
                            'exceptions' => false
                        ]
                    ]);
                    $client->delete($partner->uri . '/api/SISKA/seekers/delete', [
                        'form_params' => [
                            'key' => $partner->api_key,
                            'secret' => $partner->api_secret,
                            'email' => $user->email,
                        ]
                    ]);
                }
            }
        }
    }
}
