<?php

namespace App\Http\Requests\Api;

/** @OA\Schema(type="object", schema="StoreKeyValuePairSchema") */
class StoreKeyValuePairSchema
{
    /** @OA\Property(type="string",description="KeyValue pair", example="cat") */
    public string $animal;
}
