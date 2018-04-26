<?php

namespace App\Service;

use Doctrine\Instantiator\Exception\UnexpectedValueException;

class Calculator
{
    public function add($a, $b)
    {
        $this->validateInput($a, $b);
        return $a + $b;
    }

    public function subtract($a, $b)
    {
        $this->validateInput($a, $b);
        return $a - $b;
    }

    /**
     * @param $a
     * @param $b
     */
    private function validateInput($a, $b): void
    {
        if (!is_int($a) || !is_int($b)) {
            throw new UnexpectedValueException();
        }
    }
}