<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;

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
        $filePath = 'kol/kol.xlsx';
		$spreadsheet = IOFactory::load($filePath);
		$worksheet = $spreadsheet->getActiveSheet();
		foreach ($worksheet->getRowIterator() as $row) {
			$cellValues = [];
			foreach ($row->getCellIterator() as $cell) {
				$column = $cell->getColumn();
				if ($column === 'B' || $column === 'D') {
					$cellValue = $cell->getValue();
					if ("KOL" == $cellValue || is_null($cellValue))
					{
						break;
					}
					$cellValues[] = $cellValue;
				}
			}
			if (!empty($cellValues))
			{
				Log::info($cellValues);
			}
		}
    }
}
