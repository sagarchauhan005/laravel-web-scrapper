<?php


namespace App\Http\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ValidationHelper
{

    /** Validates the get parameters for company type
     * @param Request $request
     * @return MessageBag
     */
    public static function validateCompanyType(Request $request){
        $validator = Validator::make($request->all(), [
            'link' => 'required|string',
        ]);
        return $validator->errors();
    }

    /**
     * Validates company by page
     * @param Request $request
     * @return MessageBag
     */
    public static function validateCompanyTypeByPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link' => 'required|string',
            'page' => 'required|integer',
            'totalPages'=>'required|integer',
            'id'=>'required|integer'
        ]);
        return $validator->errors();
    }

    /**
     * Validates the business name
     * @param Request $request
     * @return MessageBag
     */
    public static function validateBusiness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company' => 'required|string',
            'id'=>'required|integer'
        ]);
        return $validator->errors();
    }

}
