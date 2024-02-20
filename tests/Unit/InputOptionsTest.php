<?php

namespace Libresign\Test;

use Libresign\Espeak\InputOptions;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class InputOptionsTest extends TestCase
{
    public function testHasOptionTrue()
    {
        $inputOptions = new InputOptions();
        $inputOptions->setOption('test');
        $condition = $inputOptions->hasOption('test');
        $this->assertTrue($condition);
    }

    public function testHasOptionFalse()
    {
        $inputOptions = new InputOptions();
        $condition = $inputOptions->hasOption('test');
        $this->assertFalse($condition);
    }

    #[DataProvider('dataStringable')]
    public function testStringable(array $options, string $expected)
    {
        $inputOptions = new InputOptions();
        foreach ($options as $name => $value) {
            if (is_string($name)) {
                $inputOptions->setOption($name, $value);
            } else {
                $inputOptions->setOption($value);
            }
        }
        $this->assertEquals($expected, (string) $inputOptions);
    }

    public static function dataStringable(): array
    {
        return [
            [['test'],'--test'],
            [['t'],'-t'],
            [['t' => '123'],'-t 123'],
            [['t' => '123', 't'],'-t 123 -t'],
        ];
    }
}
