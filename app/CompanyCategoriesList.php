<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCategoriesList extends Model
{
    protected $table='companies_by_type_list';
    protected $primaryKey='list_id';
    public $timestamps=false;
}
