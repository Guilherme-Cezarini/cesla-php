<?php 
namespace App\Validator\Rules;

class RequiredRule implements RuleInterface {
    public function validate ($value) : bool 
    {
        return !empty($value);
    }

    public function getMessage(): string
    {
        return "O campo Nome e obrigatorio";
    }
}