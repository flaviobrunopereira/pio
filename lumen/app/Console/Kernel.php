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
	$schedule->command('update:students')->dailyAt('02:30');
	$schedule->command('update:teachers')->dailyAt('02:00');
	$schedule->command('update:siges')->dailyAt('03:00');
	$schedule->command('update:giaf')->dailyAt('03:00');
    }
}


