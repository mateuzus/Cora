<?php

namespace App\Console;

use App\Entities\OperationStandart;
use App\Entities\Routine;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('listing:close')->everyMinute();
        $pops = OperationStandart::all();
        foreach ($pops as $pop){
            switch ($pop->schedule){
                case "everyMinute":
                    $schedule->command("make:listPop $pop->id")->everyMinute()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "everyTwoMinutes":
                    $schedule->command("make:listPop $pop->id")->everyTwoMinutes()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "everyThreeMinutes":
                    $schedule->command("make:listPop $pop->id")->everyThreeMinutes()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "everyFourMinutes":
                    $schedule->command("make:listPop $pop->id")->everyFourMinutes()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "everyFiveMinutes":
                    $schedule->command("make:listPop $pop->id")->everyFiveMinutes()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "everyTenMinutes":
                    $schedule->command("make:listPop $pop->id")->everyTenMinutes()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "everyFifteenMinutes":
                    $schedule->command("make:listPop $pop->id")->everyFifteenMinutes()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "everyThirtyMinutes":
                    $schedule->command("make:listPop $pop->id")->everyThirtyMinutes()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "hourly":
                    $schedule->command("make:listPop $pop->id")->hourly()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "hourlyAt":
                    $schedule->command("make:listPop $pop->id")->hourlyAt($pop->time)->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "everyTwoHours":
                    $schedule->command("make:listPop $pop->id")->everyTwoHours()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "everySixHours":
                    $schedule->command("make:listPop $pop->id")->everySixHours()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "dailyAt":
                    $schedule->command("make:listPop $pop->id")->dailyAt($pop->time)->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "weekly":
                    $schedule->command("make:listPop $pop->id")->weekly()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "weeklyOn":
                    $schedule->command("make:listPop $pop->id")->weeklyOn($pop->day, $pop->hour)->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "monthly":
                    $schedule->command("make:listPop $pop->id")->monthly()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "monthlyOn":
                    $schedule->command("make:listPop $pop->id")->monthlyOn($pop->day, $pop->hour)->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "lastDayOfMonth":
                    $schedule->command("make:listPop $pop->id")->lastDayOfMonth()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
                case "yearly":
                    $schedule->command("make:listPop $pop->id")->yearly()->sendOutputTo(storage_path("app/public/pop.log"));
                    break;
            }
        }
        $routines = Routine::all();
        foreach ($routines as $routine){
            switch ($routine->schedule){
                case "everyMinute":
                    $schedule->command("make:listRoutine $routine->id")->everyMinute()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "everyTwoMinutes":
                    $schedule->command("make:listRoutine $routine->id")->everyTwoMinutes()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "everyThreeMinutes":
                    $schedule->command("make:listRoutine $routine->id")->everyThreeMinutes()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "everyFourMinutes":
                    $schedule->command("make:listRoutine $routine->id")->everyFourMinutes()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "everyFiveMinutes":
                    $schedule->command("make:listRoutine $routine->id")->everyFiveMinutes()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "everyTenMinutes":
                    $schedule->command("make:listRoutine $routine->id")->everyTenMinutes()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "everyFifteenMinutes":
                    $schedule->command("make:listRoutine $routine->id")->everyFifteenMinutes()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "everyThirtyMinutes":
                    $schedule->command("make:listRoutine $routine->id")->everyThirtyMinutes()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "hourly":
                    $schedule->command("make:listRoutine $routine->id")->hourly()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "hourlyAt":
                    $schedule->command("make:listRoutine $routine->id")->hourlyAt($routine->time)->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "everyTwoHours":
                    $schedule->command("make:listRoutine $routine->id")->everyTwoHours()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "everySixHours":
                    $schedule->command("make:listRoutine $routine->id")->everySixHours()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "dailyAt":
                    $schedule->command("make:listRoutine $routine->id")->dailyAt($routine->time)->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "weekly":
                    $schedule->command("make:listRoutine $routine->id")->weekly()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "weeklyOn":
                    $schedule->command("make:listRoutine $routine->id")->weeklyOn($routine->day, $routine->hour)->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "monthly":
                    $schedule->command("make:listRoutine $routine->id")->monthly()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "monthlyOn":
                    $schedule->command("make:listRoutine $routine->id")->monthlyOn($routine->day, $routine->hour)->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "lastDayOfMonth":
                    $schedule->command("make:listRoutine $routine->id")->lastDayOfMonth()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
                case "yearly":
                    $schedule->command("make:listRoutine $routine->id")->yearly()->sendOutputTo(storage_path("app/public/routine.log"));
                    break;
            }
        }



    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
