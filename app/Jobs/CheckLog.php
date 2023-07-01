<?php

namespace App\Jobs;

use App\Events\NewMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $logPath = 'C:/laragon/www/apps-management/base/log';

        $completed = false;

        for ($i=0; $i < 60; $i++) {

            $logContent = file_get_contents($logPath);

            // Hacer algo con el contenido del archivo de logs
            event(new NewMessage($logContent));

            $lines = explode("\n", $logContent);
            $lastLine = $lines[count($lines) - 1];

            // if (strpos($lastLine, 'Final: true') !== false) {
            //     $completed = true;
            // }

            sleep(0.5);
        }
    }
}
