<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

abstract class Elegant extends Model
{

    public function errors()
    {
        return $this->errors;
    }

    public function getAll()
    {
        return $this->select("{$this->getTable()}.*");
    }
}
