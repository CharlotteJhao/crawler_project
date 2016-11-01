<?php

namespace XXX\Parser;

class Billboard implements IParser
{
    public function getHtmlObject($htmlObj)
    {
        return $htmlObj->find('article.chart-row');
    }

    public function getChartDate($htmlObj)
    {
        return strtotime($htmlObj->find('nav.chart-nav time')->attr('datetime'));
    }

    public function getPosition($pq)
    {
        return trim($pq->find('.chart-row__rank span.chart-row__current-week')->text());
    }

    public function getArtist($pq)
    {
        return trim($pq->find('.chart-row__title a')->text());
    }

    public function getTitle($pq)
    {
        return trim($pq->find('.chart-row__title h2')->text());
    }

    public function getSpotifyId($pq)
    {
        $str = $pq->find('.chart-row__player-content a.chart-row__player-link')->attr('href');
        $arr = explode(":", $str);
        return end($arr);
    }

    public function getRowData($pq, $meta_type)
    {
    }
}
