<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class StoreRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Store $store)
    {
        $this->model = $store;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function create(array $details): Store
    {
        return $this->model->create($details);
    }

    public function getByKey(string $key): ?Store
    {
        return Cache::remember('keyvalues', 60, function () use ($key) {
            return $this->model->where('mykey', $key)->orderBy('created_at', 'desc')->first();
        });
    }

    public function getByKeyAndTimestamp(string $key, Carbon $timestamp): ?Store
    {
        return $this->model->where('mykey', $key)->where('created_at', '<=', $timestamp->format('Y-m-d H:i:s'))->orderBy('created_at', 'desc')->first();
    }
}