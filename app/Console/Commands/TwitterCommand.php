<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Services\TwitterService;


class TwitterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:twitter-command';

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
		$twitter_service = new TwitterService;
		$twitter_service->sync_all_users();
		$twitter_service->load_all_users();
		$twitter_service->get_user_followers();
    }
}
