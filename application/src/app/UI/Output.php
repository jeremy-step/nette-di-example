<?php

namespace App\UI;

use App\Models\AppRepository;

class Output
{
    private AppRepository $repository;

    function __construct(AppRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(): void
    {
        $latestRecord = $this->repository->getLatestRecord();

        require_once __DIR__ . '/templates/home.php';
    }
}
