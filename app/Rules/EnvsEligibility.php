<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnvsEligibility implements ValidationRule
{
    protected $valid_envs = ['admin', 'web', 'mobile'];

    public function __construct()
    {
        // Constructor can be used to initialize any properties if needed
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)) {
            $value = explode(',', $value);
        }

        if (array_diff($value, $this->valid_envs)) {
            $fail(__('error.audit.invalid_envs_eligibility', ['valid_envs' => implode(', ', $this->valid_envs)]));
        }
    }
}
