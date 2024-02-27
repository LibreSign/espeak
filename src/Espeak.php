<?php

namespace Libresign\Espeak;

use InvalidArgumentException;

class Espeak
{
    use QuoteStringTrait;

    private InputOptions $inputOptions;
    public function __construct()
    {
        $this->inputOptions = new InputOptions();
    }

    public function getVersion()
    {
        $this->setOption('version');
        $output = $this->execute();
        preg_match('/: (?<version>[\d\.]+) /', $output, $matches);
        return $matches['version'];
    }

    public function setOption(string $name, ?string $value = null): self
    {
        $this->inputOptions->setOption($name, $value);
        return $this;
    }

    public function execute(string $argument = ''): string
    {
        $options = ' ' . $this->inputOptions;
        if (strlen($options) === 1) {
            throw new InvalidArgumentException();
        }
        $cmd = 'espeak-ng' . $options;
        if (strlen($argument) > 0) {
            $cmd .= ' ' . $this->quoteString($argument);
        }
        $output = \shell_exec($cmd);
        return $output;
    }

    public function getVoiceCode(string $language): string
    {
        if (empty($language)) {
            return 'en';
        }
        $language = strtolower($language);
        $languages = explode(',', $language);
        $voiceCode = $languages[0];
        $voices = $this->getAvailableVoices();
        if (!in_array($voiceCode, $voices)) {
            return 'en';
        }
        return $voiceCode;
    }

    public function getAvailableVoices(): array
    {
        $this->setOption('voice');
        $output = $this->execute();
        $data = explode(PHP_EOL, $output);
        $return = [];
        foreach ($data as $value) {
            preg_match('/^ +\d+ +(?<language>[\w-]+) +--/', $value, $matches);
            if (!isset($matches['language'])) {
                continue;
            }
            $return[] = $matches['language'];
        }
        return $return;
    }
}
