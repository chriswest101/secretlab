<?php

namespace App\Services;

use App\Repositories\StoreRepository;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class StoreService
{
    protected StoreRepository $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function getAll(): Collection
    {
        return $this->storeRepository->getAll();
    }

    public function store(array $details): Store
    {
        return $this->storeRepository->create($details);
    }

    public function getByKeyAndTimestamp(string $key, Carbon $timestamp): Store
    {
        return $this->storeRepository->getByKeyAndTimestamp($key, $timestamp);
    }

    public function getByKey(string $key): Store
    {
        return $this->storeRepository->getByKey($key);
    }
}