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
		$kol_service->calc_all_user_score();
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
				if ($column === 'C' || $column === 'D') {
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
				$twitter_service->insert_user_from_xlsx($cellValues[0], $cellValues[1]);
				Log::info($cellValues);
				sleep(20);
			}
		}
	
	}
}
