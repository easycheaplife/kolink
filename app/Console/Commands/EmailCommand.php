<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\MailService;


class EmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:email-command';

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
		$mail_service = new MailService;
		$mail_service->mail_task();
    }
}
