<?php

namespace XXX\Parser;

interface IParser
{
    public function getHtmlObject($htmlObj);

    public function getChartDate($htmlObj);

    public function getPosition($pq);

    public function getArtist($pq);

    public function getTitle($pq);

    public function getSpotifyId($pq);

    public function getRowData($pq, $meta_type);
}
