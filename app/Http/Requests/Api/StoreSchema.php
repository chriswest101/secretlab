<?php

namespace App\Http\Requests\Api;

/** @OA\Schema(type="object", schema="StoreSchema") */
class StoreSchema
{
    /** @OA\Property(type="string",description="Created Date of Store", example="2022-06-04 23:45:12") */
    public string $createdAt;

    /** @OA\Property(type="string",description="Key Of Store", example="MyKey") */
    public string $mykey;

    /** @OA\Property(type="string", description="Value Of Store", example="SomeValue") */
    public string $value;
}
