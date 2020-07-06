<?php


namespace App\Http\Helpers;


use Illuminate\Support\Str;

class CompanyBusinessPageParser
{

    public $crawler;
    public function __construct($crawler)
    {
        $this->crawler = $crawler;
    }

    /** Gets the heading of the company
     * @return mixed
     */
    public function getHeading()
    {
        return $this->crawler->filter('.main_test > h2')->first()->text();
    }

    /** Gets the description of the company
     * @return mixed
     */
    public function getDescription()
    {
        return $this->crawler->filter('.main_test > p')->first()->text();
    }


    /** Gets the different table data of the company
     * @param $path
     * @return mixed
     */
    public function getCompanyTableByPath($path)
    {
        return $this->crawler->filter($path)->filter('tr')->each(function ($tr, $i) {
            $data = $tr->filter('td')->each(function ($td, $i) {
                return trim($td->text());
            });
            return [
                'table-heading'=>$data[0],
                'table-data' => $data[1],
            ];
        });
    }

    /** Gets the director of the company
     * @return array
     */
    public function getCompanyDirector()
    {
        // fetches all the table heads
        $tableHeads = $this->crawler->filter('#directors > .table-responsive > .table-responsive > table > tbody > tr > th')->each(function ($node) {
            return $node->text();
        });

        //fetches the data
        $data = $this->crawler->filter('#directors > .table-responsive > .table-responsive > table > tbody')->filter('tr')->each(function ($tr, $i) use ($tableHeads){
            if($i>0){
                return $data = $tr->filter('td')->each(function ($td, $i) use ($tableHeads) {
                    $text = trim($td->text());
                    $head = $tableHeads[$i];
                    return [
                      'table-heading'=>$head,
                      'table-data'=>$text,
                    ];
                });
            }
        });

        unset($data[0]); //removes the first element for heading
        return array_values($data);
    }

    /** Gets the frequently asked questions of the company
     * @return mixed
     */
    public function getCompanyFaqs()
    {
        $questions = $this->crawler->filter('.panel > .panel-heading > .panel-title')->each(function ($node) {
            return $node->text();
        });

        return $this->crawler->filter('.panel > .panel-body > p')->each(function ($node, $i) use ($questions) {
            return [
                'questions'=>$questions[$i],
                'answers'=>$node->text(),
            ];
        });
     }
}
