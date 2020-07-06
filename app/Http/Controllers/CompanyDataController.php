<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CompanyDataParser;
use App\Http\Helpers\DatabaseController;
use App\Http\Helpers\Helper;
use App\Http\Helpers\ValidationHelper;
use Goutte\Client;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\DomCrawler\Crawler;

class CompanyDataController extends Controller
{

    /**
     * Return the view with a list of company data fetched from a website
     * @return Factory|View
     */

    public $base_url;
    public function __construct(){
        $this->base_url = "http://www.mycorporateinfo.com/";
    }

    /**
     *  STEP 1
     * Renders the index page
     * @return Factory|View
     */
    public function index(){
        $client = new Client();
        $crawler = $client->request('GET', $this->base_url.'industry');
        $data = $crawler->filter('li.list-group-item > a')->each(function ($node) {
            $id = DatabaseController::saveCompaniesCategories($node->text()); //updates the database
            $link = $node->link()->getUri();
            return [
                'name'=>$node->text(),
                'link'=>urlencode(str_replace($this->base_url,'',$link)),
                'cmp_id'=>$id
            ];
        });

        return view('pages/index')->with('companies',$data);
    }


    /**
     * STEP 2
     * Returns all the company page by page
     * @param Request $request
     * @return array|RedirectResponse|null
     */
    public function getCompaniesByPage(Request $request){
        $error = ValidationHelper::validateCompanyTypeByPage($request);
        if(count($error)>0){
            return  redirect()->to('404');
        }

        $next = urldecode($request->get('link'));
        $page = $request->get('page');
        $cmp_id = $request->get('id');
        $totalPages = $request->get('totalPages');
        $uri = $next."/page/".$page; //per page URI

        if($page>-1){

            //crawler
            $client = new Client();
            $crawler = $client->request('GET', $this->base_url.$uri);
            $totalPages = ($totalPages==0) ? Helper::getTotalPages($crawler) : $totalPages;

            // gets the list
            $data = CompanyDataParser::getCompaniesList($crawler, $cmp_id);
            if(sizeof($data)>0){
                unset($data[0]); //removes the first element for heading
                $response = ($page<$totalPages) ? array_values($data) : [];
                DatabaseController::savesListOfCompanies($data, $cmp_id, $page); //updates the database
                return [
                    'response'=>$response,
                    'total_pages'=>$totalPages,
                ];
            }

            return null;
        }

        return null;
    }

    /**
     * STEP 3
     * Returns specific company data
     * @param Request $request
     * @return Factory|RedirectResponse|View
     */
    public function getBusiness(Request $request){
        $error = ValidationHelper::validateBusiness($request);
        if(count($error)>0){
            return  redirect()->to('404');
        }

        $company  = $request->get('company');
        $cmp_id  = $request->get('id');
        $uri = "business/".$company;
        $client = new Client();
        $crawler = $client->request('GET', $this->base_url.$uri);

        //start fetching data
        $response = self::getCompanyData($crawler);
        DatabaseController::savesSingleCompanyData($response, $cmp_id); //updates the database
        return view('pages/get-companies-business-page')->with('company',$response);
    }

    /**
     * STEP 3.1
     * Collate all the data;
     * @param Crawler $crawler
     * @return array
     */
    private static function getCompanyData(Crawler $crawler)
    {
        $parser = new CompanyDataParser($crawler);
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
