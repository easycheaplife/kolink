<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\ProjectTaskApplicationService;

class TransactionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transaction-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
		$application_service = new ProjectTaskApplicationService;
		$application_service->tansaction_timeout_check();
    }
}
