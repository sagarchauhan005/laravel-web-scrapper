<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SingleCompanyData extends Model
{
    protected $table='single_company_data';
    public $timestamps=false;
    protected $primaryKey='id';
}
