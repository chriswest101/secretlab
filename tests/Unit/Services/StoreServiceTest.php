<?php

namespace Tests\Unit\Services;

use App\Models\Store;
use App\Repositories\StoreRepository;
use App\Services\StoreService;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Tests\TestHelper;

class StoreServiceTest extends TestCase
{
    /**
     * @group Unit
     */
    public function test_get_all_returns_data()
    {
        // Arrange
        $model = $this->mockObject(Store::class);
        $repo = $this->mockObject(StoreRepository::class);
        $service = new StoreService($repo);
        $expected = new Collection([$model]);

        $repo->shouldReceive('getAll')
            ->once()
            ->andReturn($expected);

        // Act
        $result = $service->getAll();

        // Assert
        $this->assertSame($expected, $result);
    }

    /**
     * @group Unit
     */
    public function test_get_all_returns_empty_collection()
    {
        // Arrange
        $repo = $this->mockObject(StoreRepository::class);
        $service = new StoreService($repo);
        $expected = new Collection([]);

        $repo->shouldReceive('getAll')
            ->once()
            ->andReturn($expected);

        // Act
        $result = $service->getAll();

        // Assert
        $this->assertSame($expected, $result);
    }

    /**
     * @group Unit
     */
    public function test_get_by_key_returns_record()
    {
        // Arrange
        $repo = $this->mockObject(StoreRepository::class);
        $service = new StoreService($repo);
        $key = TestHelper::getTestString();
        $expected = $this->mockObject(Store::class);

        $repo->shouldReceive('getByKey')
            ->with($key)
            ->once()
            ->andReturn($expected);

        // Act
        $result = $service->getByKey($key);

        // Assert
        $this->assertSame($expected, $result);
    }

    /**
     * @group Unit
     */
    public function test_get_by_key_returns_null()
    {
        // Arrange
        $repo = $this->mockObject(StoreRepository::class);
        $service = new StoreService($repo);
        $key = TestHelper::getTestString();

        $repo->shouldReceive('getByKey')
            ->with($key)
            ->once()
            ->andReturnNull();

        // Act
        $result = $service->getByKey($key);

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
        $repo = $this->mockObject(StoreRepository::class);
        $service = new StoreService($repo);

        $repo->shouldReceive('getByKeyAndTimestamp')
            ->with($key, $timestamp)
            ->once()
            ->andReturn($expected);

        // Act
        $result = $service->getByKeyAndTimestamp($key, $timestamp);

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
        $repo = $this->mockObject(StoreRepository::class);
        $service = new StoreService($repo);

        $repo->shouldReceive('getByKeyAndTimestamp')
            ->with($key, $timestamp)
            ->once()
            ->andReturnNull();

        // Act
        $result = $service->getByKeyAndTimestamp($key, $timestamp);

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
        $repo = $this->mockObject(StoreRepository::class);
        $service = new StoreService($repo);

        $repo->shouldReceive('create')
            ->with($details)
            ->once()
            ->andReturn($expected);

        // Act
        $result = $service->store($details);

        // Assert
        $this->assertSame($expected, $result);
    }
}
