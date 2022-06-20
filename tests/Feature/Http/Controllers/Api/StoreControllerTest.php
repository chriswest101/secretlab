<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\TestHelper;

class StoreControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * @group Feature
     */
    public function test_all_route_returns_data()
    {
        // Arrange
        $store = Store::factory()->create();

        // Act
        $response = $this->get(route("secretlab.all"));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $this->assertJson($response->baseResponse->getContent());
        $this->assertEquals(json_encode([
            'status_code' => Response::HTTP_OK,
            'message' => "Success",
            'data' => [[
                'id' => $store->id,
                'mykey' => $store->mykey,
                'value' => $store->value,
                'created_at' => $store->created_at,
                'updated_at' => $store->updated_at,
            ]]
            
        ]), $response->baseResponse->getContent());
    }

    /**
     * @group Feature
     */
    public function test_all_route_returns_null()
    {
        // Arrange

        // Act
        $response = $this->get(route("secretlab.all"));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $this->assertJson($response->baseResponse->getContent());
        $this->assertEquals(json_encode([
            'status_code' => Response::HTTP_OK,
            'message' => "Success",
            'data' => []
            
        ]), $response->baseResponse->getContent());
    }

    /**
     * @group Feature
     */
    public function test_get_by_key_route_returns_404()
    {
        // Arrange
        $store = Store::factory()->create();

        // Act
        $response = $this->get(route("secretlab.get", ["myKey" => "UnknownKey"]));

        // Assert
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $this->assertJson($response->baseResponse->getContent());
        $this->assertEquals(json_encode([
            'status_code' => Response::HTTP_NOT_FOUND,
            'message' => "Resource Not Found",
            'data' => null
            
        ]), $response->baseResponse->getContent());
    }

    /**
     * @group Feature
     * @dataProvider timestampCases
     */
    public function test_get_by_key_route_with_invalid_timestamp($timestamp)
    {
        // Arrange
        $store = Store::factory()->create();

        // Act
        $response = $this->get(route("secretlab.get", ["myKey" => $store->mykey, "timestamp" => $timestamp]));

        // Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJson($response->baseResponse->getContent());
        $this->assertEquals(json_encode([
            'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => null,
            'data' => [
                'message' => "Validation failed",
                'errors' => [
                    "Timestamp is not a valid timestamp. It must be in the past and a valid Unix Timestamp."
                ]
            ]
            
        ]), $response->baseResponse->getContent());
    }

    /**
     * @group Feature
     */
    public function test_get_by_key_route_without_timestamp()
    {
        // Arrange
        $store = Store::factory()->create();

        // Act
        $response = $this->get(route("secretlab.get", ["myKey" => $store->mykey]));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $this->assertJson($response->baseResponse->getContent());
        $this->assertEquals(json_encode([
            'status_code' => Response::HTTP_OK,
            'message' => "Success",
            'data' => [
                'id' => $store->id,
                'mykey' => $store->mykey,
                'value' => $store->value,
                'created_at' => $store->created_at,
                'updated_at' => $store->updated_at,
            ]
            
        ]), $response->baseResponse->getContent());
    }

    /**
     * @group Feature
     */
    public function test_get_by_key_route_with_timestamp()
    {
        // Arrange
        $store = Store::factory()->create();

        // Act
        $response = $this->get(route("secretlab.get", ["myKey" => $store->mykey, "timestamp" => strtotime($store->created_at)]));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $this->assertJson($response->baseResponse->getContent());
        $this->assertEquals(json_encode([
            'status_code' => Response::HTTP_OK,
            'message' => "Success",
            'data' => [
                'id' => $store->id,
                'mykey' => $store->mykey,
                'value' => $store->value,
                'created_at' => $store->created_at,
                'updated_at' => $store->updated_at,
            ]
            
        ]), $response->baseResponse->getContent());
    }

    /**
     * @group Feature
     */
    public function test_get_by_key_route_with_timestamp_and_multiple_already_exist_and_the_correct_pair_is_returned()
    {
        // Arrange
        $store1 = Store::factory()->create();
        $store2 = Store::factory()->create();
        $store3 = Store::factory()->create();

        // Act
        $response = $this->get(route("secretlab.get", ["myKey" => $store2->mykey, "timestamp" => strtotime($store2->created_at)]));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $this->assertJson($response->baseResponse->getContent());
        $this->assertEquals(json_encode([
            'status_code' => Response::HTTP_OK,
            'message' => "Success",
            'data' => [
                'id' => $store2->id,
                'mykey' => $store2->mykey,
                'value' => $store2->value,
                'created_at' => $store2->created_at,
                'updated_at' => $store2->updated_at,
            ]
            
        ]), $response->baseResponse->getContent());
    }

    /**
     * @group Feature
     */
    public function test_store_route_is_successful()
    {
        // Arrange
        $myKey = TestHelper::getTestString();
        $value = TestHelper::getTestString();

        // Act
        $response = $this->post(route("secretlab.store"), [
            'mykey' => $myKey,
            'value' => $value
        ]);

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $this->assertJson($response->baseResponse->getContent());
        $response->assertJsonStructure([
            'status_code',
            'message',
            'data',
            
        ]);
    }

    public function timestampCases()
    {
        return [
            [
                'timestamp' => 0,
                'timestamp' => -1,
                'timestamp' => "non-numeric",
            ],
        ];
    }
}
