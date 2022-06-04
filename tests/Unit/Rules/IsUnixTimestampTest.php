<?php

namespace Tests\Unit\Rules;

use App\Rules\IsUnixTimestamp;
use PHPUnit\Framework\TestCase;
use Tests\TestHelper;

class IsUnixTimestampTest extends TestCase
{
    /**
     * @group Unit
     */
    public function test_message()
    {
        // Arrange
        $rule = new IsUnixTimestamp();

        // Assert
        $this->assertSame("Timestamp is not a valid timestamp. It must be in the past and a valid Unix Timestamp.", $rule->message());
    }

    /**
     * @group Unit
     */
    public function test_get_validate_timestamp_is_empty()
    {
        // Arrange
        $value = null;
        $rule = new IsUnixTimestamp();

        // Act
        $result = $rule->passes("", $value);

        // Assert
        $this->assertTrue($result);
    }

    /**
     * @group Unit
     */
    public function test_get_validate_timestamp_is_in_the_future()
    {
        // Arrange
        $value = strtotime("+1 minute");
        $rule = new IsUnixTimestamp();

        // Act
        $result = $rule->passes("", $value);

        // Assert
        $this->assertFalse($result);
    }

    /**
     * @group Unit
     */
    public function test_get_validate_timestamp_is_before_epoch()
    {
        // Arrange
        $value = TestHelper::getTestInt(-1, -1);
        $rule = new IsUnixTimestamp();

        // Act
        $result = $rule->passes("", $value);

        // Assert
        $this->assertFalse($result);
    }

    /**
     * @group Unit
     */
    public function test_get_validate_timestamp_is_after_epoch()
    {
        // Arrange
        $value = TestHelper::getTestInt(0, 0);
        $rule = new IsUnixTimestamp();

        // Act
        $result = $rule->passes("", $value);

        // Assert
        $this->assertTrue($result);
    }
}
