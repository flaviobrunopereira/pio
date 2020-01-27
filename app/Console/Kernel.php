<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UpdateStudentsCommand::class,
        Commands\UpdateTeachersCommand::class,
        Commands\UpdateEmployeesCommand::class,
        Commands\SyncSigesCommand::class,
        Commands\SyncGiafCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    	$schedule->command('update:employees')->twiceDaily(1,13);
	$schedule->command('update:students')->dailyAt('01:04');
	$schedule->command('update:teachers')->twiceDaily(0,12);
	$schedule->command('update:siges')->dailyAt('12:47');
	$schedule->command('update:giaf')->dailyAt('12:48');
    }
}


