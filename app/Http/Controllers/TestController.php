<?php

namespace App\Http\Controllers;

use App\Services\ConditionExtract\ConditionExtractService;

class TestController extends Controller
{
    private ConditionExtractService $service;
    public function __construct(ConditionExtractService $service)
    {
        $this->service = $service;
    }
    public function test():string
    {
        $this->service->execute();
        return 'test';
    }
}