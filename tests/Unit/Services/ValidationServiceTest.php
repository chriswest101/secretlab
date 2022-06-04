<?php

namespace Tests\Unit\Services;

use App\Services\ValidationService;
use Tests\TestCase;
use Tests\TestHelper;

class ValidationServiceTest extends TestCase
{
    /**
     * @group Unit
     */
    public function test_store_validate_my_key_too_long()
    {
        // Arrange
        $key = TestHelper::getTestString(256);
        $value = TestHelper::getTestString();
        $details = [
            'mykey' => $key,
            'value' => $value,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->storeValidate($details);

        // Assert
        $this->assertNotEmpty($result->messages());
        $this->assertArrayHasKey("mykey", $result->messages());
        $this->assertSame("The mykey must not be greater than 255 characters.", $result->messages()['mykey'][0]);
    }

    /**
     * @group Unit
     */
    public function test_store_validate_my_key_is_max_length()
    {
        // Arrange
        $key = TestHelper::getTestString(255);
        $value = TestHelper::getTestString();
        $details = [
            'mykey' => $key,
            'value' => $value,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->storeValidate($details);

        // Assert
        $this->assertEmpty($result->messages());
    }

    /**
     * @group Unit
     */
    public function test_store_validate_my_key_is_one_below_max_length()
    {
        // Arrange
        $key = TestHelper::getTestString(254);
        $value = TestHelper::getTestString();
        $details = [
            'mykey' => $key,
            'value' => $value,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->storeValidate($details);

        // Assert
        $this->assertEmpty($result->messages());
    }

    /**
     * @group Unit
     */
    public function test_store_validate_my_key_is_empty()
    {
        // Arrange
        $key = TestHelper::getTestString(0);
        $value = TestHelper::getTestString();
        $details = [
            'mykey' => $key,
            'value' => $value,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->storeValidate($details);

        // Assert
        $this->assertNotEmpty($result->messages());
        $this->assertArrayHasKey("mykey", $result->messages());
        $this->assertSame("The mykey field is required.", $result->messages()['mykey'][0]);
    }

    /**
     * @group Unit
     */
    public function test_store_validate_value_too_long()
    {
        // Arrange
        $key = TestHelper::getTestString();
        $value = TestHelper::getTestString(65536);
        $details = [
            'mykey' => $key,
            'value' => $value,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->storeValidate($details);

        // Assert
        $this->assertNotEmpty($result->messages());
        $this->assertArrayHasKey("value", $result->messages());
        $this->assertSame("The value must not be greater than 65535 characters.", $result->messages()['value'][0]);
    }

    /**
     * @group Unit
     */
    public function test_store_validate_value_is_max_length()
    {
        // Arrange
        $key = TestHelper::getTestString();
        $value = TestHelper::getTestString(65535);
        $details = [
            'mykey' => $key,
            'value' => $value,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->storeValidate($details);

        // Assert
        $this->assertEmpty($result->messages());
    }

    /**
     * @group Unit
     */
    public function test_store_validate_value_is_one_below_max_length()
    {
        // Arrange
        $key = TestHelper::getTestString();
        $value = TestHelper::getTestString(65534);
        $details = [
            'mykey' => $key,
            'value' => $value,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->storeValidate($details);

        // Assert
        $this->assertEmpty($result->messages());
    }

    /**
     * @group Unit
     */
    public function test_store_validate_value_is_empty()
    {
        // Arrange
        $key = TestHelper::getTestString();
        $value = TestHelper::getTestString(0);
        $details = [
            'mykey' => $key,
            'value' => $value,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->storeValidate($details);

        // Assert
        $this->assertNotEmpty($result->messages());
        $this->assertArrayHasKey("value", $result->messages());
        $this->assertSame("The value field is required.", $result->messages()['value'][0]);
    }

    /**
     * @group Unit
     */
    public function test_get_validate_timestamp_is_empty()
    {
        // Arrange
        $details = [
            'timestamp' => null,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->getValidate($details);

        // Assert
        $this->assertEmpty($result->messages());
    }

    /**
     * @group Unit
     */
    public function test_get_validate_timestamp_is_in_the_future()
    {
        // Arrange
        $timestamp = strtotime("+1 minute");
        $details = [
            'timestamp' => $timestamp,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->getValidate($details);

        // Assert
        $this->assertNotEmpty($result->messages());
        $this->assertArrayHasKey("timestamp", $result->messages());
        $this->assertSame("Timestamp is not a valid timestamp. It must be in the past and a valid Unix Timestamp.", $result->messages()['timestamp'][0]);
    }

    /**
     * @group Unit
     */
    public function test_get_validate_timestamp_is_before_epoch()
    {
        // Arrange
        $timestamp = TestHelper::getTestInt(-1, -1);
        $details = [
            'timestamp' => $timestamp,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->getValidate($details);

        // Assert
        $this->assertNotEmpty($result->messages());
        $this->assertArrayHasKey("timestamp", $result->messages());
        $this->assertSame("Timestamp is not a valid timestamp. It must be in the past and a valid Unix Timestamp.", $result->messages()['timestamp'][0]);
    }

    /**
     * @group Unit
     */
    public function test_get_validate_timestamp_is_after_epoch()
    {
        // Arrange
        $timestamp = TestHelper::getTestInt(0, 0);
        $details = [
            'timestamp' => $timestamp,
        ];
        $service = new ValidationService();

        // Act
        $result = $service->getValidate($details);

        // Assert
        $this->assertEmpty($result->messages());
    }
}

// public function storeValidate(array $details): MessageBag
// {
//     $rules = [
//         "mykey" => "required|max:255",
//         "value" => "required|max:65535",
//     ];

//     return Validator::make($details, $rules)->errors();
// }

// public function getValidate(array $details): MessageBag
// {
//     $rules = [
//         "timestamp" => [new IsUnixTimestamp],
//     ];

//     return Validator::make($details, $rules)->errors();
// }