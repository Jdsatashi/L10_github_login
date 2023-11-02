<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as BaseModel;

class Model2 extends BaseModel
{
    protected $connection = 'mongodb';
}
