<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BuildApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $appName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appName)
    {
        $this->appName = $appName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $output = shell_exec("sh C:/laragon/www/apps-management/base/build-app.bash ". $this->appName);
    }
}
