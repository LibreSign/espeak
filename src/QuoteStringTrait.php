<?php

namespace Libresign\Espeak;

trait QuoteStringTrait
{
    public function quoteString(string $value): string
    {
        $value = str_replace('"', '\"', $value);
        if (str_contains($value, ' ')) {
            $value = '"' . $value . '"';
        }
        return $value;
    }
}
