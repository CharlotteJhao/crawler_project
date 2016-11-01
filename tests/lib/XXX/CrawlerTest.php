<?php

namespace XXX;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    public function testSetAndGetParser()
    {
        $c = new Crawler();
        $c->setParser(new \XXX\Parser\Billboard());
        $this->assertEquals(new \XXX\Parser\Billboard(), $c->getParser());
    }

    public function testGetDomain()
    {
        $c = $this->getMockBuilder('XXX\Crawler')
            ->setMethods(['setHtmlObj'])->getMock();
        $c->expects($this->once())
            ->method('setHtmlObj')
            ->with('test_url');

        $c->setDomain('test_url');
        $this->assertEquals('test_url', $c->getDomain());
    }

    public function testGetChartType()
    {
        $c = new Crawler();
        $c->setChartType('type');
        $this->assertEquals('type', $c->getChartType());
    }

    public function testSetAndGetHtmlObj()
    {
        $c = $this->getMockBuilder('XXX\Crawler')
            ->setMethods(['curlRequest'])->getMock();
        $c->expects($this->once())
            ->method('curlRequest')
            ->with('test_url')
            ->willReturn('<h1>Hello world!</h1>');

        $c->setHtmlObj('test_url');
        $this->assertEquals('Hello world!', $c->getHtmlObj()->text());
    }

    public function testGetChartList()
    {
        $c = $this->getMockBuilder('XXX\Crawler')
            ->setMethods([
                'getChartData',
                'setHtmlObj'
            ])->getMock();

        $c->expects($this->once())->method('setHtmlObj');
        $c->expects($this->once())->method('getChartData');
        $c->getChartList();
    }
}
