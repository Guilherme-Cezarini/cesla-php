<?php 
namespace App\Validator\Rules;

class PositiveNumberRule implements RuleInterface {
    public function validate ($value) : bool 
    {
        return $value > 0;
    }

    public function getMessage(): string
    {
        return "O valor Preço precisa ser positivo.";
    }
}