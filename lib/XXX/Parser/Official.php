<?php

namespace XXX\Parser;

class Official implements IParser
{
    public function getHtmlObject($htmlObj)
    {
        return $htmlObj->find('table.chart-positions tr:not(.headings, .mobile-actions, .actions-view)');
    }

    public function getChartDate($htmlObj)
    {
        list(, $chart_date) = explode(" - ", $htmlObj->find('p.article-date')->eq(0)->text());
        return strtotime(trim($chart_date));
    }

    public function getPosition($pq)
    {
        return (int) trim($pq->find('td span.position')->text());
    }

    public function getArtist($pq)
    {
        return trim($pq->find('td div.track div.title-artist div.artist a')->text());
    }

    public function getTitle($pq)
    {
        return trim($pq->find('td div.track div.title-artist div.title a')->text());
    }

    public function getSpotifyId($pq)
    {
    }

    public function getRowData($pq, $meta_type)
    {
    }
}
