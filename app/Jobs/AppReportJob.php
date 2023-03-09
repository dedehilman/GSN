<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Excel;
use App;
use Illuminate\Support\Facades\Log;

class AppReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reportClass;
    protected $reportModel;
    protected $filePath;
    protected $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reportClass, $reportModel, $filePath, $fileName = null)
    {
        $this->reportClass = $reportClass;
        $this->reportModel = $reportModel;
        $this->filePath = $filePath;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->reportModel->status = '1';
            $this->reportModel->runned_at = Carbon::now()->format('Y-m-d H:i:s');
            $this->reportModel->save();

            $filePath = $this->filePath.($this->fileName != null ? $this->fileName : $this->reportModel->code.'_'.time().'.xlsx');
            Excel::store(
                App::make($this->reportClass, [
                    'reportModel' => $this->reportModel, 
                ]),
                $filePath,
            );
            
            $this->reportModel->status = '2';
            $this->reportModel->message = '';
            $this->reportModel->file_path = $filePath;
        } catch (\Throwable $th) {
            $this->reportModel->status = '3';
            $this->reportModel->message = $th->getMessage();
            Log::error($th);
        } finally {
            $this->reportModel->finished_at = Carbon::now()->format('Y-m-d H:i:s');
            $this->reportModel->save();
        }
    }

}
