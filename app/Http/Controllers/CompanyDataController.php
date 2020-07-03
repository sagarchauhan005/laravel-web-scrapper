<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ValidationHelper;
use Goutte\Client;
use Illuminate\Http\Request;

class CompanyDataController extends Controller
{

    /**
     * Return the view with a list of company data fetched from a website
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public $base_url;
    public function __construct(){
        $this->base_url = "http://www.mycorporateinfo.com/";
    }

    public function index(){
        $client = new Client();
        $crawler = $client->request('GET', $this->base_url.'industry');
        $data = $crawler->filter('li.list-group-item > a')->each(function ($node) {
            return [
                'name'=>$node->text(),
                'link'=>urlencode(str_replace($this->base_url,'',$node->link()->getUri())),
            ];
        });

        return view('pages/index')->with('companies',$data);
    }

    /** Gets the total number of pages for this list
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @return mixed
     */
    private static function getTotalPages(\Symfony\Component\DomCrawler\Crawler $crawler)
    {
        $pages = $crawler->filter('.pagination > li')->each(function ($node) {
            return $node->text();
        });

        //remove the last element
        array_pop($pages);
        return $pages[sizeof($pages)-1];
    }


    public function getCompaniesByPage(Request $request){
        $error = ValidationHelper::validateCompanyTypeByPage($request);
        if(count($error)>0){
            return  redirect()->to('404');
        }
        $next = urldecode($request->get('link'));
        $page = $request->get('page');
        $uri = $next."/page/".$page; //per page URI
        if($page>-1){
            //crawler
            $client = new Client();
            $crawler = $client->request('GET', $this->base_url.$uri);
            $totalPages = self::getTotalPages($crawler);

            $data = $crawler->filter('.table > tbody')->each(function ($node) {
                return $node->html();
            });

            echo "<table class='table table-bordered' data-pages='".$totalPages."' id='table-results'><tbody>";
            if($page<$totalPages){
                foreach ($data as $comp){
                    echo $comp;
                }
            }else{
                echo "<p class='alert alert-danger'>No more data available. Go back</p>";
            }
            echo "</tbody></table>";
        }else{
            return null;
        }
    }
}
