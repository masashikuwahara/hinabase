<?php

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testExample()
    {
        $this->assertEquals(2, 1 + 1); // 1+1は2なので、テストが成功する
    }
}