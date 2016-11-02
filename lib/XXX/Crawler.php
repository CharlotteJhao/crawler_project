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
        $tmpArr = [];
        $chart_type = $this->getChartType();
        $parser = $this->getParser();

        foreach ($parser->getHtmlObject($this->getHtmlObj()) as $v) {
            $row = $parser->getRowData(pq($v), $chart_type);
            if ($row) {
                $tmpArr[] = $row;
            }
        }

        return $tmpArr;
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
