<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueTwoColumnValidation implements Rule
{
    protected $table, $firstcolumn, $secondcolumn, $firstcolumnvalue, $secondcolumnvalue, $id, $primraykeyColumn;

    public function __construct($table, $firstcolumn, $firstcolumnvalue, $id = null, $primraykeyColumn = null)
    {
        $this->table = $table;
        $this->firstcolumn = $firstcolumn;
        $this->firstcolumnvalue = $firstcolumnvalue;
        $this->id = $id;
        $this->primraykeyColumn = $primraykeyColumn;
    }

    public function passes($attribute, $value)
    {
        $this->secondcolumn = $attribute;
        $this->secondcolumnvalue = $value;
        $query = DB::table($this->table)
            ->where($this->firstcolumn, $this->firstcolumnvalue)
            ->where($this->secondcolumn, $this->secondcolumnvalue)
        ;
        if ($this->id) {
            $primraykeyColumn = $this->primraykeyColumn ? $this->primraykeyColumn : 'id';
            $query->where($primraykeyColumn, '!=', $this->id);
        }
        return $query->doesntExist();
    }

    public function message()
    {
        return 'The combination of ' . $this->firstcolumn . ' and ' . $this->secondcolumn . ' must be unique.';
    }
}
