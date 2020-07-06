<?php


namespace App\Http\Helpers;


use App\CompanyCategories;
use App\CompanyCategoriesList;
use App\SingleCompanyData;

class DatabaseController
{

    /** Saves the list of companies categories
     * @param $name
     * @return bool
     */
    public static function saveCompaniesCategories($name){
        $check = CompanyCategories::where('company_name','=',$name)->get()->toArray();
        if(sizeof($check)==0){
            $cat = new CompanyCategories();
            $cat->company_name = $name;
            return $cat->save();
        }
        return $check[0]['cmp_id'];
    }

    /** Saves the list of company
     * @param $data
     * @param $cmp_id
     * @param $page
     * @return void
     */
    public static function savesListOfCompanies($data, $cmp_id, $page){
        $check = CompanyCategoriesList::where([
            ['cmp_id','=',$cmp_id],
            ['page','=',$page],
        ])->get()->toArray();
        if(sizeof($check)==0){
            $list = new CompanyCategoriesList();
            $list->page = $page;
            $list->cmp_id = $cmp_id;
            $list->list = json_encode($data);
            $list->save();
        }
    }

    /**
     * Save single company data to db
     * @param $data
     * @param $cmp_id
     * @return void
     */
    public static function savesSingleCompanyData($data, $cmp_id)
    {
        $check = SingleCompanyData::where([
            ['cmp_id','=',$cmp_id],
        ])->get()->toArray();
        if(sizeof($check)==0){
            $comp = new SingleCompanyData();
            $comp->cmp_id = $cmp_id;
            $comp->data = json_encode($data);
            $comp->save();
        }
    }
}
