<?php

namespace App\Console\Commands\Agencies;

use App\Accepting;
use App\PartnerCredential;
use App\Vacancies;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Console\Command;

class inactiveVacancy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inactiveVacancy:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update vacancy status to inactive when the active_period has been ended or already reached its applicant limit';

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
        $vacancies = Vacancies::where('isPost', true)->get();

        foreach ($vacancies as $vacancy) {
            $applicants = Accepting::where('vacancy_id', $vacancy->id)->where('isApply', true)->count();
            if ($vacancy->getPlan->isQuiz == true) {
                if ($applicants >= $vacancy->quiz_applicant || today() > $vacancy->active_period) {
                    $vacancy->update([
                        'isPost' => false,
                    ]);
                    $data = array('email' => $vacancy->agencies->user->email, 'judul' => $vacancy->judul,
                        'input' => array('isPost' => $vacancy->isPost));
                    $this->updatePartners($data, 'schedule');
                }

            } else {
                if (today() > $vacancy->active_period) {
                    $vacancy->update([
                        'isPost' => false,
                    ]);
                    $data = array('email' => $vacancy->agencies->user->email, 'judul' => $vacancy->judul,
                        'input' => array('isPost' => $vacancy->isPost));
                    $this->updatePartners($data, 'schedule');
                }
            }
        }
    }

    private function updatePartners($data, $check)
    {
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

                try {
                    $client->put($partner->uri . '/api/SISKA/vacancies/update', [
                        'form_params' => [
                            'key' => $partner->api_key,
                            'secret' => $partner->api_secret,
                            'check_form' => $check,
                            'agencies' => $data,
                        ]
                    ]);
                } catch (ConnectException $e) {
                    //
                }
            }
        }
    }
}
