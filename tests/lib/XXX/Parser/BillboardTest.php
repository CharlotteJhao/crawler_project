<?php

namespace XXX\Parser;

class BillboardTest extends \PHPUnit_Framework_TestCase
{
    protected $htmlObj;

    public function setUp()
    {
        $content = file_get_contents(__DIR__ . '/billboard_song.html');
        $this->htmlObj = \phpQuery::newDocumentHTML($content);
    }

    public function testGetHtmlObject()
    {
        $b = new Billboard();
        $this->assertNotEmpty($b->getHtmlObject($this->htmlObj));
    }

    public function testGetChartDate()
    {
        $content = file_get_contents(__DIR__ . '/billboard_chartdate.html');
        $html_obj = \phpQuery::newDocumentHTML($content);
        $b = new Billboard();
        $this->assertEquals(1457712000, $b->getChartDate($html_obj));
    }
}
