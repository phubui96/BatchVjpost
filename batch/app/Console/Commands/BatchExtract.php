<?php

namespace App\Console\Commands;

use App\Services\ConditionExtract\ConditionExtractService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BatchExtract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'batch add product';

    /**
     * @var ConditionExtractService $service
     */
    private ConditionExtractService $service;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConditionExtractService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::channel('daily')->info('Start Batch');
        $this->service->executeTest();
        Log::channel('daily')->info('End Batch');
    }
}
