<?php

namespace XXX\Parser;

class BillboardTest extends \PHPUnit_Framework_TestCase
{
    protected $htmlObj;
    protected $phpQueryObj;

    public function setUp()
    {
        $content = file_get_contents(__DIR__ . '/billboard_song.html');
        $this->htmlObj = \phpQuery::newDocumentHTML($content);
        $this->phpQueryObj = pq($this->htmlObj{0});
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

    public function testGetPosition()
    {
        $b = new Billboard();
        $this->assertEquals(1, $b->getPosition($this->phpQueryObj));
    }

    public function testGetArtist()
    {
        $b = new Billboard();
        $this->assertEquals('Rihanna Featuring Drake', $b->getArtist($this->phpQueryObj));
    }

    public function testGetTitile()
    {
        $b = new Billboard();
        $this->assertEquals('Work', $b->getTitle($this->phpQueryObj));
    }

    public function testGetSpotifyId()
    {
        $b = new Billboard();
        $this->assertEquals('50R3hdsZQeg3k8zJdVphSZ', $b->getSpotifyId($this->phpQueryObj));
    }

    public function testGetRowData()
    {
        $b = new Billboard();
        $this->assertEquals(
            [
                'position' => "1",
                'track' => "Work",
                'artist' => "Rihanna Featuring Drake",
                'spotify_id' => "track:50R3hdsZQeg3k8zJdVphSZ",
            ],
            $b->getRowData($this->phpQueryObj, 'track')
        );
    }
}
