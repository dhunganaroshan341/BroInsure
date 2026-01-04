<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MemberImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $filepath;
    public function __construct($filepath)
    {
        $this->filepath=$filepath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file=storage_path('app/'.$this->filepath);
        $spreadsheet=IOFactory::load($file);
        $worksheet=$spreadsheet->getActiveSheet();
        $rows=[];
        
        foreach ($worksheet->getRowIterator() as $key => $row) {
            if ($key==1) {
                continue;
            }
            $cells=[];
            foreach ($row->getCellIterator() as $cell) {
                $cell[]=$cell->getValue();
            }
            $rows[]=array_combine($this->header(),$cells);
        }
    }
}
