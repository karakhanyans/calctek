<?php

namespace App\Services;

use MathParser\Interpreting\Evaluator;
use MathParser\StdMathParser;

class MathService
{
    /**
     * @param $expression
     * @return float
     */
    public function calculate($expression): float
    {
        $parser = new StdMathParser();
        $AST = $parser->parse($expression);
        $evaluator = new Evaluator();

        return $AST->accept($evaluator);
    }
}
