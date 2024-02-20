<?php

namespace Libresign\Espeak;

class Espeak{

    public function getVersion(){
        \exec('espeak-ng --version', $output);
        preg_match('/: (?<version>[\d\.]+) /',$output[0], $matches);
        return $matches['version'];
    }

}