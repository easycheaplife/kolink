<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;
use App\Http\Services\TwitterService;
use App\Http\Services\KolService;


class KolCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:kol-command';

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
		$kol_service = new KolService;
		$dayOfMonth = now()->day;
		if ($dayOfMonth % 2 != 0) {
			$kol_service->update_all_user_data();
			$kol_service->calc_all_user_twitter_content_relevance();
		} else {
			$kol_service->get_all_user_tweets();
			$kol_service->summarize_all_user_tweets();
		}
		$kol_service->calc_all_user_score();
		$kol_service->calc_all_user_twitter_metric(7);
		$kol_service->calc_all_user_twitter_metric(30);
    }

	public function load_kol_from_twitter()
	{
		$twitter_service = new TwitterService;
        $filePath = 'kol/kol.xlsx';
		$spreadsheet = IOFactory::load($filePath);
		$worksheet = $spreadsheet->getActiveSheet();
		foreach ($worksheet->getRowIterator() as $row) {
			$cellValues = [];
			foreach ($row->getCellIterator() as $cell) {
				$column = $cell->getColumn();
				if ($column === 'A' || $column === 'C' || $column === 'D') {
					$cellValue = $cell->getValue();
					if ("KOL" == $cellValue || is_null($cellValue) || "Twitter Handle" == $cellValue || '' == $cellValue)
					{
						break;
					}
					$cellValues[] = $cellValue;
				}
			}
			if (!empty($cellValues))
			{
				$cellValues[0] = str_replace('@', '', $cellValues[0]);
				$twitter_service->insert_user_from_xlsx($cellValues[0]);
				Log::info("load_kol_from_twitter:" . $cellValues[0]);
				sleep(20);
			}
		}
	
	}
}
