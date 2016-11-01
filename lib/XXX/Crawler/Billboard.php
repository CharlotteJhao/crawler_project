<?php

namespace XXX\Crawler;

class Billboard extends \XXX\Crawler
{
    private $domain = 'http://www.billboard.com/charts/';
    private $chartTypeTarget = [
        'track' => 'hot-100',
        'album' => 'billboard-200'
    ];

    public function getDomain()
    {
        return $this->domain;
    }

    public function getChartTypeTarget()
    {
        return $this->chartTypeTarget;
    }

    public function getChartDate()
    {
        return strtotime($this->htmlObj->find('nav.chart-nav time')->attr('datetime'));
    }

    public function getChartData($chart_type)
    {
        $tmpArr = [];

        foreach ($this->htmlObj->find('article.chart-row') as $v) {
            $position = $artist = $title = $spotify = '';
            $header = pq($v);

            //get span position
            $position = trim($header->find('.chart-row__rank span.chart-row__current-week')->text());

            //get artist
            $artist = trim($header->find('.chart-row__title a')->text());

            //get song/album name
            $title = trim($header->find('.chart-row__title h2')->text());

            //get spotify id
            $spotify = $header->find('.chart-row__player-content a.chart-row__player-link')->attr('href');
            $spotify = strrchr($spotify, "{$chart_type}:");

            //output array
            if (false === array_search('', [$position, $title])) {
                $tmpArr[$position] = array(
                    'position'   => $position,
                    $chart_type  => $title,
                    'artist'     => $artist,
                    'spotify_id' => $spotify
                );
            }
        }

        return $tmpArr;
    }
}
