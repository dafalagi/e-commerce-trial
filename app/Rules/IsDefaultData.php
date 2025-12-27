<?php

namespace App\Rules;

use App\Models\BaseModel;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IsDefaultData implements ValidationRule
{
    protected $table, $identifier;

    public function __construct($table, $identifier)
    {
        $this->table = $table;
        $this->identifier = $identifier;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!$this->table instanceof \Illuminate\Database\Eloquent\Model and !$this->table instanceof BaseModel) {
            $this->table = DB::table($this->table);
        }
        
        if(Str::isUuid($this->identifier)) {
            $filter = $this->table->where('uuid', $this->identifier);
        }else {
            $filter = $this->table->where('id', $this->identifier);
        }

        $data = $filter->where('is_default', false)
            ->where('deleted_at', null);
        
        if(empty($data->first()))
            $fail(__('validation.custom.default_data'));
    }
}
