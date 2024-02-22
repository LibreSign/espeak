<?php

namespace Libresign\Espeak;

use InvalidArgumentException;

class Espeak
{
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
            $cmd .= ' ' . $argument;
        }
        $output = \shell_exec($cmd);
        return $output;
    }
}
