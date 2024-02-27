<?php

namespace Libresign\Espeak;

use Stringable;

class InputOptions implements Stringable
{
    use QuoteStringTrait;

    private array $options = [];
    public function setOption(string $name, ?string $value = null)
    {
        $this->options[$name][] = $value;
    }

    public function hasOption(string $name)
    {
        return array_key_exists($name, $this->options);
    }

    private function nameValueToString(string $name, array $values, string $separator, string $type)
    {
        $return = [];
        foreach ($values as $value) {
            if (empty($value)) {
                $return[] = $type . $name;
            } else {
                $return[] = $type . $name . $separator . $this->quoteString($value);
            }
        }
        return implode(' ', $return);
    }

    public function __toString(): string
    {
        $return = [];
        foreach ($this->options as $name => $value) {
            if (strlen($name) === 1) {
                $return[] = $this->nameValueToString($name, $value, ' ', '-');
            } else {
                $return[] = $this->nameValueToString($name, $value, '=', '--');
            }
        }
        return implode(' ', $return);
    }
}
