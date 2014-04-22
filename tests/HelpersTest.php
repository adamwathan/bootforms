<?php

class HelpersTest extends PHPUnit_Framework_TestCase
{
    public function test_can_determine_if_array_is_associative()
    {
        $array = array(1, 2, 3);
        $this->assertFalse(is_assoc($array));

        $array = array(
            '0' => 1,
            '2' => 2,
            '3' => 3,
        );
        $this->assertTrue(is_assoc($array));

        $array = array(1 => 1);
        $this->assertTrue(is_assoc($array));
    }
}
