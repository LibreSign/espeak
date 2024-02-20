<?php

namespace Libresign\Test;

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
}
