<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CompanyBusinessPageParser;
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


    /**
     * Returns all the company page by page
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|null
     */
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

    /**
     * Returns specific company data
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getBusiness(Request $request){
        $error = ValidationHelper::validateBusiness($request);
        if(count($error)>0){
            return  redirect()->to('404');
        }

        $company  = $request->get('company');
        $uri = "business/".$company;
        $client = new Client();
        $crawler = $client->request('GET', $this->base_url.$uri);

        //start fetching data
        $response = self::getCompanyData($crawler);
        //echo "<pre>"; print_r($response); die();
        return view('pages/get-companies-business-page')->with('company',$response);
    }

    /**
     * Collate all the data;
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @return array
     */
    private static function getCompanyData(\Symfony\Component\DomCrawler\Crawler $crawler)
    {
        $parser = new CompanyBusinessPageParser($crawler);
        $heading = $parser->getHeading();
        $companyDesc = $parser->getDescription();
        $companyInfo = $parser->getCompanyTableByPath('#companyinformation > table > tbody');
        $companyContact = $parser->getCompanyTableByPath('#contactdetails > table > tbody');
        $companyCompliance = $parser->getCompanyTableByPath('#listingandannualcomplaincedetails > table > tbody');
        $companyLocation = $parser->getCompanyTableByPath('#otherinformation > table > tbody');
        $companyClassification = $parser->getCompanyTableByPath('#industryclassification > table > tbody');
        $companyDirector = $parser->getCompanyDirector();
        $companyFaqs = $parser->getCompanyFaqs();

        return [
            'heading'=>$heading,
            'description'=>$companyDesc,
            'information'=>$companyInfo,
            'contact'=>$companyContact,
            'compliance'=>$companyCompliance,
            'location'=>$companyLocation,
            'classification'=>$companyClassification,
            'directors'=>$companyDirector,
            'faqs'=>$companyFaqs,
        ];
    }
}
