<?php

namespace Libresign\Test;

use InvalidArgumentException;
use Libresign\Espeak\Espeak;
use PHPUnit\Framework\TestCase;

class EspeakTest extends TestCase
{
    public function testGetVersion()
    {
        $Espeak = new Espeak();
        $actual = $Espeak->getVersion();
        $this->assertNotEmpty($actual);
    }

    public function testGetVersionUsingOption()
    {
        $actual = (new Espeak())
            ->setOption('version')
            ->execute();
        $this->assertMatchesRegularExpression('/: (?<version>[\d\.]+) /', $actual);
    }

    public function testThrowExceptionWhenOptionIsEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Espeak())->execute();
    }

    public function testSpeakWithSuccess()
    {
        $actual = (new Espeak())
            ->setOption('stdout')
            ->execute('1');
        $this->assertNotEmpty($actual);
    }
}
