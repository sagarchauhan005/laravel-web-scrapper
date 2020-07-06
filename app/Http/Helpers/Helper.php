<?php


namespace App\Http\Helpers;


class Helper
{

    /** Gets the total number of pages for this list
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @return mixed
     */
    public static function getTotalPages(\Symfony\Component\DomCrawler\Crawler $crawler)
    {
        $pages = $crawler->filter('.pagination > li')->each(function ($node) {
            return $node->text();
        });

        //remove the last element
        array_pop($pages);
        return $pages[sizeof($pages)-1];
    }
}
