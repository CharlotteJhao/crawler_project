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
