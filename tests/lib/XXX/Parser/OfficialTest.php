<?php

namespace XXX\Parser;

class OfficialTest extends \PHPUnit_Framework_TestCase
{
    protected $htmlObj;
    protected $phpQueryObj;

    public function setUp()
    {
        $content = file_get_contents(__DIR__ . '/official_song.html');
        $this->htmlObj = \phpQuery::newDocumentHTML($content);
        $this->phpQueryObj = pq($this->htmlObj{0});
    }

    public function testGetHtmlObject()
    {
        $o = new Official();
        $this->assertNotEmpty($o->getHtmlObject($this->htmlObj));
    }

    public function testGetChartDate()
    {
        $content = file_get_contents(__DIR__ . '/official_chartdate.html');
        $html_obj = \phpQuery::newDocumentHTML($content);
        $o = new Official();
        $this->assertEquals(1456934400, $o->getChartDate($html_obj));
    }

    public function testGetPosition()
    {
        $o = new Official();
        $this->assertEquals(1, $o->getPosition($this->phpQueryObj));
    }

    public function testGetArtist()
    {
        $o = new Official();
        $this->assertEquals('LUKAS GRAHAM', $o->getArtist($this->phpQueryObj));
    }

    public function testGetTitile()
    {
        $o = new Official();
        $this->assertEquals('7 YEARS', $o->getTitle($this->phpQueryObj));
    }

    public function testGetSpotifyId()
    {
        $o = new Official();
        $this->assertEquals('2vDT1uU6hZgdp3PbWGr0Xy', $o->getSpotifyId($this->phpQueryObj));
    }

    public function testGetRowData()
    {
        $o = new Official();
        $this->assertEquals(
            [
                'position' => "1",
                'track' => "7 years",
                'artist' => "Lukas Graham",
                'spotify_id' => "track:2vDT1uU6hZgdp3PbWGr0Xy",
            ],
            $o->getRowData($this->phpQueryObj, 'track')
        );
    }
}
