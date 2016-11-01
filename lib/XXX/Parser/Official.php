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
