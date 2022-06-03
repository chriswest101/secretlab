<?php

namespace App\Interfaces;

use Carbon\Carbon;

interface RepositoryInterface 
{
    public function getAll();
    public function create(array $details);
    public function getByKey(string $key);
    public function getByKeyAndTimestamp(string $key, Carbon $timestamp);
}