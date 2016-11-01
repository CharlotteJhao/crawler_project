<?php

namespace XXX\Crawler;

class Official extends \XXX\Crawler
{
    private $domain = 'http://www.officialcharts.com/charts/';
    private $chartTypeTarget = [
        'track' => 'singles-chart/',
        'album' => 'albums-chart/'
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
        list(, $chart_date) = explode(" - ", $this->htmlObj->find('p.article-date')->eq(0)->text());
        return strtotime(trim($chart_date));
    }

    public function getChartData($chart_type)
    {
        $tmpArr = array();

        foreach ($this->htmlObj->find('table.chart-positions tr:not(.headings, .mobile-actions, .actions-view)') as $v) {
            $position = $artist = $title = '';
            $odd = pq($v);

            //get span position
            $position = (int) trim($odd->find('td span.position')->text());

            //get artist
            $artist = trim($odd->find('td div.track div.title-artist div.artist a')->text());

            //get song or album name
            $title = trim($odd->find('td div.track div.title-artist div.title a')->text());

            #FIXME: get spotify id, official only provide spotify track id no matter what chart type
            $spotify = $this->htmlObj->find("tr.actions-view-listen-{$position} a.spotify")->attr('href');
            $spotify = str_replace("/", ":", strrchr($spotify, "track/"));

            //output array
            if ($position > 0) {
                $tmpArr[$position] = array(
                    'position'  => $position,
                    $chart_type => ucfirst(strtolower($title)),
                    'artist'    => ucwords(strtolower($artist)),
                    'spotify_id' => $spotify
                );
            }
        }

        return $tmpArr;
    }
}
