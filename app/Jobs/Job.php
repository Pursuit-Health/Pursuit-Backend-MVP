<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class Job implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "queueOn" and "delay" queue helper methods.
    |
    */
    public $tries = 999999;
    protected const DELAY = 5;

    abstract public function fire();

    public function handle()
    {
        try {
            $this->fire();
        } catch (\Exception $exception) {

            $this->fail($exception);
        }
    }


    use InteractsWithQueue, Queueable, SerializesModels;
}
