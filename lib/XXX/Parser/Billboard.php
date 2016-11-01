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
    }

    public function getArtist($pq)
    {
    }

    public function getTitle($pq)
    {
    }

    public function getSpotifyId($pq)
    {
    }

    public function getRowData($pq, $meta_type)
    {
    }
}
