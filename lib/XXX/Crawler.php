<?php

namespace XXX;

abstract class Crawler
{
    protected $htmlObj;
    private $domain;
    private $chartType;

    abstract public function getChartTypeTarget();

    abstract public function getChartDate();

    abstract public function getChartData($chart_type);

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function getChartType()
    {
        return $this->chartType;
    }

    public function setChartType($type)
    {
        $this->chartType = $type;
    }

    public function getChartList($chart_type)
    {
        if (!array_key_exists($chart_type, $this->getChartTypeTarget())) {
            return [];
        }

        $this->setHtmlObj($this->getDomain() . $this->getChartTypeTarget()[$chart_type]);

        return $this->getChartData($chart_type);
    }

    public function getHtmlObj()
    {
        return $this->htmlObj;
    }

    public function setHtmlObj($url)
    {
        $content = $this->curlRequest($url);
        $this->htmlObj = \phpQuery::newDocumentHTML($content);
    }

    public function curlRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
