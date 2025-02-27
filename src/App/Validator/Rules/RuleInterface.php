<?php 
namespace App\Validator\Rules;

interface RuleInterface { 
    public function validate($value) : bool;
    public function getMessage(): string;
}