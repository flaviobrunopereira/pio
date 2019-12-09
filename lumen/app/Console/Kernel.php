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
        Commands\SyncSigesCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    $schedule->command('update:employees')->dailyAt('00:00');;
	$schedule->command('update:students')->dailyAt('00:01');;
	$schedule->command('update:teachers')->dailyAt('00:02');;
	$schedule->command('update:siges')->dailyAt('03:00');;
    }
}


