<?php

namespace XXX;

class Crawler
{
    protected $htmlObj;
    private $domain;
    private $chartType;
    private $parser;

    public function getChartDate()
    {
        return $this->getParser()->getChartDate($this->getHtmlObj());
    }

    public function getChartData()
    {
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
        $this->setHtmlObj($domain);
    }

    public function getChartType()
    {
        return $this->chartType;
    }

    public function setChartType($type)
    {
        $this->chartType = $type;
    }

    public function getChartList()
    {
        $this->setHtmlObj($this->domain);

        return $this->getChartData();
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

    public function getParser()
    {
        return $this->parser;
    }

    public function setParser($parser)
    {
        $this->parser = $parser;
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
