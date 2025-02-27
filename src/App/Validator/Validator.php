<?php 
namespace App\Validator;

use App\Validator\Rules\RuleInterface;

class Validator 
{
    private $rules = [];
    private $errors = [];

    public function addRule(string $field, RuleInterface $rule): self {
        if (!isset($this->rules[$field])) {
            $this->rules[$field] = [];
        }
        $this->rules[$field][] = $rule;
        return $this;
    }

    public function validate(array $data): bool {
        $this->errors = [];

        foreach ($this->rules as $field => $rules) {
            $value = $data[$field] ?? null;

            foreach ($rules as $rule) {
                if (!$rule->validate($value)) {
                    $this->errors[$field][] = $rule->getMessage();
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors(): array {
        return $this->errors;
    }

    public function getFirstError(): array {
        
        if(!empty($this->errors)){ 
            $keyOfFirstValue = array_key_first($this->errors);
            return $this->errors[$keyOfFirstValue];
        }
        return [];

    }
}