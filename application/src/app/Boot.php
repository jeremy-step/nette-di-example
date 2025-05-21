<?php

namespace App;

use App\Models\AppRepository;

class Boot
{
    private AppRepository $repository;

    function __construct(AppRepository $repository)
    {
        $this->repository = $repository;
    }

    public function startup(): void {
        $this->repository->createTable();
        $this->repository->createRecord();
    }
}
