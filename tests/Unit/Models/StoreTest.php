<?php

namespace Tests\Unit\Models;

use App\Models\Store;
use PHPUnit\Framework\TestCase;

class StoreTest extends TestCase
{
    /**
     * @group Unit
     */
    public function test_fillable()
    {
        // Arrange
        $model = new Store();

        // Act
        $fillable = $model->getFillable();

        // Assert
        $this->assertEquals([
            'mykey',
            'value',
        ], $fillable);
    }
}
