<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCategories extends Model
{
    protected $table='companies_categories';
    protected $primaryKey='cmp_id';
    public $timestamps = false;
}
