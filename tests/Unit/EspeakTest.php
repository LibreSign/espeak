<?php

namespace Libresign\Test;

use InvalidArgumentException;
use Libresign\Espeak\Espeak;
use PHPUnit\Framework\Attributes\DataProvider;
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

    #[DataProvider('dataGetVoiceCode')]
    public function testeGetVoiceCode($acceptLanguage, $expected)
    {
        $espeak = new Espeak();
        $actual = $espeak->getVoiceCode($acceptLanguage);
        $this->assertEquals($expected, $actual);
    }

    public static function dataGetVoiceCode(): array
    {
        return [
            ['', 'en'],
            ['pt', 'pt'],
            ['pt-BR', 'pt-br'],
            ['pt-BR,pt;q=0.9', 'pt-br'],
            ['invalid', 'en'],
        ];
    }

    public function testAvailableVoicesNotEmpty()
    {
        $espeak = new Espeak();
        $this->assertNotEmpty($espeak->getAvailableVoices());
    }

    public function testAvailableVoiceIsValid()
    {
        $espeak = new Espeak();
        $voices = $espeak->getAvailableVoices();
        foreach ($voices as $voice) {
            $this->assertMatchesRegularExpression('/^[\w-]+$/', $voice);
        }
    }
}
