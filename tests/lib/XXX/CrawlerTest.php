<?php

namespace XXX;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDomain()
    {
        $c = $this->getMockBuilder('XXX\Crawler')
            ->setMethods([
                'getChartDate',
                'getChartData',
                'curlRequest'
            ])->getMock();
        $c->setDomain('test_url');
        $this->assertEquals('test_url', $c->getDomain());
    }

    public function testSetAndGetHtmlObj()
    {
        $c = $this->getMockBuilder('XXX\Crawler')
            ->setMethods([
                'getChartTypeTarget',
                'getChartDate',
                'getChartData',
                'curlRequest'
            ])->getMock();
        $c->expects($this->once())
            ->method('curlRequest')
            ->with('test_url')
            ->willReturn('<h1>Hello world!</h1>');

        $c->setHtmlObj('test_url');
        $this->assertEquals('Hello world!', $c->getHtmlObj()->text());
    }

    /**
     * @dataProvider getChartDataProvider
     */
    public function testGetChartList($chart_type, $expect)
    {
        $c = $this->getMockBuilder('XXX\Crawler')
            ->setMethods([
                'getChartDate',
                'getChartData',
                'getChartTypeTarget',
                'setHtmlObj'
            ])->getMock();

        $c->expects($this->any())->method('getChartTypeTarget')->willReturn(['track' => 'A']);
        $c->expects($this->any())->method('getDomain')->willReturn('http://www.test.com/');
        $c->expects($this->any())->method('setHtmlObj');
        $c->expects($this->any())->method('getChartData')->willReturn(['chart_list_array']);

        $this->assertEquals($expect, $c->getChartList($chart_type));
    }

    public function getChartDataProvider()
    {
        return [
            ['type' => 'track', 'expect' => ['chart_list_array']],
            ['type' => 'test', 'expect' => []]
        ];
    }
}
