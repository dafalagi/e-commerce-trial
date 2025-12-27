<?php

namespace App\Rules;

use App\Models\BaseModel;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ExistsUuid implements ValidationRule
{
    protected $table, $cols, $vals, $no_deleted_at;

    public function __construct($table, $cols = null, $vals = null, $no_deleted_at = false)
    {
        $this->table = $table;
        $this->cols = $cols;
        $this->vals = $vals;
        $this->no_deleted_at = $no_deleted_at;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (!$this->table instanceof \Illuminate\Database\Eloquent\Model and !$this->table instanceof BaseModel) {
            $this->table = DB::table($this->table);
        }

        if (strpos($value, ',') !== false) {
            $splittedValue = explode(',', $value);

            if($this->no_deleted_at){
                $query = $this->table->whereIn('uuid', $splittedValue);
            } else {
                $query = $this->table->whereIn('uuid', $splittedValue)->where('deleted_at', null);
            }
        } else {
            if($this->no_deleted_at){
                $query = $this->table->where('uuid', $value);
            } else {
                $query = $this->table->where('uuid', $value)->where('deleted_at', null);
            }
        }

        $this->cols != null and $this->vals != null ? $query->where($this->cols, $this->vals) : '';
        $result = !empty($query->first()) ? true : false;

        if(!$result)
            $fail(__('validation.custom.uuid.exists'));
    }
}
