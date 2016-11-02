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
        $content = file_get_contents(__DIR__ . '/Parser/billboard_song.html');
        $html_obj = \phpQuery::newDocumentHTML($content);
        $pq = pq($html_obj{0});

        $p = $this->getMockBuilder('XXX\Parser\Billboard')
            ->setMethods(['getHtmlObject', 'getRowData', 'getParser'])->getMock();
        $p->expects($this->once())
            ->method('getHtmlObject')
            ->with($html_obj)
            ->willReturn([$html_obj{0}]);
        $p->expects($this->any())
            ->method('getRowData')
            ->with($pq, 'track')
            ->willReturn([]);

        $c = $this->getMockBuilder('XXX\Crawler')
            ->setMethods([
                'getParser',
                'getChartType',
                'getHtmlObj'
            ])->getMock();
        $c->setParser($p);
        $c->expects($this->once())->method('getParser')->willReturn($p);
        $c->expects($this->once())->method('getChartType')->willReturn('track');
        $c->expects($this->once())->method('getHtmlObj')->willReturn($html_obj);

        $c->getChartList();
    }

    public function testGetChartDate()
    {
        $p = $this->getMockBuilder('XXX\Parser\Billboard')
            ->setMethods(['getChartDate'])->getMock();
        $p->expects($this->once())
            ->method('getChartDate')
            ->with('html_obj')
            ->willReturn(1457712000);

        $c = $this->getMockBuilder('XXX\Crawler')
            ->setMethods([
                'getParser',
                'getHtmlObj'
            ])->getMock();
        $c->setParser($p);
        $c->expects($this->once())->method('getParser')->wiLLReturn($p);
        $c->expects($this->once())->method('getHtmlObj')->willReturn('html_obj');

        $c->getChartDate();
    }
}
