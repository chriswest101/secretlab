<?php

namespace Tests\Unit\Repositories;

use App\Models\Store;
use App\Repositories\StoreRepository;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Tests\TestHelper;

class StoreRepositoryTest extends TestCase
{
    /**
     * @group Unit
     */
    public function test_get_all_returns_data()
    {
        // Arrange
        $model = $this->mockObject(Store::class);
        $repo = new StoreRepository($model);
        $expected = new Collection([$model]);

        $model->shouldReceive('all')
            ->once()
            ->andReturn($expected);

        // Act
        $result = $repo->getAll();

        // Assert
        $this->assertSame($expected, $result);
    }

    /**
     * @group Unit
     */
    public function test_get_all_returns_empty_collection()
    {
        // Arrange
        $model = $this->mockObject(Store::class);
        $repo = new StoreRepository($model);
        $expected = new Collection([]);

        $model->shouldReceive('all')
            ->once()
            ->andReturn($expected);

        // Act
        $result = $repo->getAll();

        // Assert
        $this->assertSame($expected, $result);
    }

    /**
     * @group Unit
     */
    public function test_get_by_key_returns_record()
    {
        // Arrange
        $key = TestHelper::getTestString();
        $expected = $this->mockObject(Store::class);
        $repo = new StoreRepository($expected);

        $expected->shouldReceive('where')
            ->with('mykey', $key)
            ->once()
            ->andReturnSelf();

        $expected->shouldReceive('orderBy')
            ->with('created_at', 'desc')
            ->once()
            ->andReturnSelf();

        $expected->shouldReceive('first')
            ->once()
            ->andReturn($expected);

        // Act
        $result = $repo->getByKey($key);

        // Assert
        $this->assertSame($expected, $result);
    }

    /**
     * @group Unit
     */
    public function test_get_by_key_returns_null()
    {
        // Arrange
        $key = TestHelper::getTestString();
        $expected = $this->mockObject(Store::class);
        $repo = new StoreRepository($expected);

        $expected->shouldReceive('where')
            ->with('mykey', $key)
            ->once()
            ->andReturnSelf();

        $expected->shouldReceive('orderBy')
            ->with('created_at', 'desc')
            ->once()
            ->andReturnSelf();

        $expected->shouldReceive('first')
            ->once()
            ->andReturnNull();

        // Act
        $result = $repo->getByKey($key);

        // Assert
        $this->assertNull($result);
    }

    /**
     * @group Unit
     */
    public function test_get_by_key_and_timestamp_returns_record()
    {
        // Arrange
        $key = TestHelper::getTestString();
        $timestamp = TestHelper::getTestDate();
        $expected = $this->mockObject(Store::class);
        $repo = new StoreRepository($expected);

        $expected->shouldReceive('where')
            ->with('mykey', $key)
            ->once()
            ->andReturnSelf();

        $expected->shouldReceive('where')
            ->with('created_at', '<=', $timestamp->format('Y-m-d H:i:s'))
            ->once()
            ->andReturnSelf();

        $expected->shouldReceive('orderBy')
            ->with('created_at', 'desc')
            ->once()
            ->andReturnSelf();

        $expected->shouldReceive('first')
            ->once()
            ->andReturn($expected);

        // Act
        $result = $repo->getByKeyAndTimestamp($key, $timestamp);

        // Assert
        $this->assertSame($expected, $result);
    }

    /**
     * @group Unit
     */
    public function test_get_by_key_and_timestamp_returns_null()
    {
        // Arrange
        $key = TestHelper::getTestString();
        $timestamp = TestHelper::getTestDate();
        $expected = $this->mockObject(Store::class);
        $repo = new StoreRepository($expected);

        $expected->shouldReceive('where')
            ->with('mykey', $key)
            ->once()
            ->andReturnSelf();

        $expected->shouldReceive('where')
            ->with('created_at', '<=', $timestamp->format('Y-m-d H:i:s'))
            ->once()
            ->andReturnSelf();

        $expected->shouldReceive('orderBy')
            ->with('created_at', 'desc')
            ->once()
            ->andReturnSelf();

        $expected->shouldReceive('first')
            ->once()
            ->andReturnNull();

        // Act
        $result = $repo->getByKeyAndTimestamp($key, $timestamp);

        // Assert
        $this->assertNull($result);
    }

    /**
     * @group Unit
     */
    public function test_create_successfully()
    {
        // Arrange
        $key = TestHelper::getTestString();
        $value = TestHelper::getTestString();
        $details = [
            'mykey' => $key,
            'value' => $value,
        ];
        $expected = $this->mockObject(Store::class);
        $repo = new StoreRepository($expected);

        $expected->shouldReceive('create')
            ->once()
            ->andReturn($expected);

        // Act
        $result = $repo->create($details);

        // Assert
        $this->assertSame($expected, $result);
    }
}
