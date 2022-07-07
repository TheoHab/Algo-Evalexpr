<?php

function eval_expr($expr)
{

    $queu = [];
    $stack = [];
    $number = "";

    for ($i = 0; $i < strlen($expr); $i++) {
        if (!is_numeric($expr[0])) {
            $expr = "0" . $expr;
        }

        if (is_numeric($expr[$i])) {
            $number = $number . $expr[$i];
            continue;
        } else {
            if ($number != "")
                array_push($queu, $number);
            $number = "";

            if (count($stack) === 0) {
                array_push($stack, $expr[$i]);
            } else {
                if (end($stack) == "*" || end($stack) == "/" || end($stack) == "%" || end($stack) == "(" || end($stack) == ")") {
                    if ($expr[$i] == "+" || $expr[$i] == "-") {
                        $tmp = array_pop($stack);
                        array_push($queu, $tmp);
                        array_push($stack, $expr[$i]);
                    } else {
                        array_push($stack, $expr[$i]);
                    }
                } else {
                    array_push($stack, $expr[$i]);
                }

            }
        }
    }
    if ($number != "") {
        array_push($queu, $number);
    }
    foreach ($stack as $stk) {
        $pop = array_pop($stack);
        array_push($queu, $pop);
    }

    while (count($queu) != 0) {
        if (is_numeric($queu[0])) {
            $shift = array_shift($queu);
            array_push($stack, $shift);
       
        } else {
            switch ($queu[0]) {
                case "*":
                    $right = array_pop($stack);
                    $left = array_pop($stack);
                    $calc = ($left) * ($right);
                    array_push($stack, "" . $calc . "");
                    array_shift($queu);
                    break;
                case "-":
                    $right = array_pop($stack);
                    $left = array_pop($stack);
                    $calc = ($left) - ($right) ;
                    array_push($stack, "" . $calc . "");
                    array_shift($queu);
                    break;
                case "+":
                    $right = array_pop($stack);
                    $left = array_pop($stack);
                    $calc = ($left) + ($right);
                    array_push($stack, "" . $calc . "");
                    array_shift($queu);
                    break;
                case "/":
                    $right = array_pop($stack);
                    $left = array_pop($stack);
                    $calc = ($left) / ($right);
                    array_push($stack, "" . $calc . "");
                    array_shift($queu);
                    break;
                case "%":
                    $right = array_pop($stack);
                    $left = array_pop($stack);
                    $calc = ($left) % ($right);
                    array_push($stack, "" . $calc . "");
                    array_shift($queu);
                    break;
                case "(":
                    array_shift($queu);
                    break;
                case ")":
                    array_shift($queu);
                    break;
            }
        }
    }
    return $stack[0];
}

echo eval_expr("-5-2");
