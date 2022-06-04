<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class StoreRepository implements RepositoryInterface
{
    public function getAll(): Collection
    {
        return Store::all();
    }

    public function create(array $details): Store
    {
        return Store::create($details);
    }

    public function getByKey(string $key): ?Store
    {
        return Store::where('mykey', $key)->orderBy('created_at', 'desc')->first();
    }

    public function getByKeyAndTimestamp(string $key, Carbon $timestamp): ?Store
    {
        return Store::where('mykey', $key)->where('created_at', '<=', $timestamp->format('Y-m-d H:i:s'))->orderBy('created_at', 'desc')->first();
    }
}