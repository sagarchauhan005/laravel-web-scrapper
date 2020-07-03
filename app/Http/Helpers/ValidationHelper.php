<?php


namespace App\Http\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationHelper
{

    /** Validates the get parameters for company type
     * @param Request $request
     * @return \Illuminate\Support\MessageBag
     */
    public static function validateCompanyType(Request $request){
        $validator = Validator::make($request->all(), [
            'link' => 'required|string',
        ]);
        return $validator->errors();
    }

    public static function validateCompanyTypeByPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link' => 'required|string',
            'page' => 'required|integer',
        ]);
        return $validator->errors();
    }

}
