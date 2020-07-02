<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;

class IndexPageController extends Controller
{
    public static function index(){
        $client = new Client();
        $crawler = $client->request('GET', 'http://www.mycorporateinfo.com/industry');
        $data = $crawler->filter('li.list-group-item > a')->each(function ($node) {
            return [
                'name'=>$node->text(),
                'link'=>$node->link()->getUri(),
            ];
        });

        return view('pages/index')->with('companies',$data);
    }
}
