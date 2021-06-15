<?php

namespace App\Console\Commands;

use App\Entities\Listing;
use App\Entities\Network;
use App\Entities\User;
use App\Notifications\ListDaily;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class SendNotificationList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:sendListDaily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new command instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $netWorks = Network::active()->get();
        foreach ($netWorks as $netWork){
            $usersOperators = $this->user->usersOperatorNetWork($netWork);
            $userAdmins =  $this->user->usersAdminNetWork($netWork);
            $questionsArray = [
                'total'=>0,
                'answers' =>0,
                'effectiveness'=>0,
            ];
            foreach ($usersOperators as $user){
                $reportQuestionsToday = $user->reportQuestionsToday();
                //total e answers
                $questionsArray['total'] += $reportQuestionsToday['total'];
                $questionsArray['answers'] += $reportQuestionsToday['answers'];
            }
            if($questionsArray['total'] != 0){
                $questionsArray['effectiveness'] = $questionsArray['answers']/$questionsArray['total'];
            }
            foreach ($userAdmins as $userAdmin){
                $userAdmin->notify(new ListDaily($questionsArray));
            }
        }
        return 0;
    }
}
