<?php 
namespace App\Validator\Rules;

class PositiveNumberRule implements RuleInterface {
    public function validate ($value) : bool 
    {
        
        return is_numeric($value) && $value > 0;
    }

    public function getMessage(): string
    {
        return "O valor Preço precisa um numero e ser positivo.";
    }
}