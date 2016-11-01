<?php

namespace XXX\Crawler;

class OfficialTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDomain()
    {
        $c = new Official();
        $this->assertEquals('http://www.officialcharts.com/charts/', $c->getDomain());
    }

    public function testGetChartTypeTarget()
    {
        $c = new Official();
        $this->assertEquals(
            [
                'track' => 'singles-chart/',
                'album' => 'albums-chart/'
            ],
            $c->getChartTypeTarget()
        );
    }

    public function testGetChartDataBySingles()
    {
        $content = file_get_contents(__DIR__ . '/official_song.html');
        $html_obj = \phpQuery::newDocumentHTML($content);
        $b = new Official();

        $ref = new \ReflectionClass('XXX\Crawler\Official');
        $ref_htmlobj = $ref->getProperty('htmlObj');
        $ref_htmlobj->setAccessible(true);
        $ref_htmlobj->setValue($b, $html_obj);

        $this->assertEquals(
            [
                1 => [
                    'position' => "1",
                    'track' => "7 years",
                    'artist' => "Lukas Graham",
                    'spotify_id' => "track:2vDT1uU6hZgdp3PbWGr0Xy",
                ]
            ],
            $b->getChartData('track')
        );
    }

    public function testGetChartDataByAlbums()
    {
        $content = file_get_contents(__DIR__ . '/official_album.html');
        $html_obj = \phpQuery::newDocumentHTML($content);
        $b = new Official();

        $ref = new \ReflectionClass('XXX\Crawler\Official');
        $ref_htmlobj = $ref->getProperty('htmlObj');
        $ref_htmlobj->setAccessible(true);
        $ref_htmlobj->setValue($b, $html_obj);

        $this->assertEquals(
            [
                1 => [
                    'position' => "1",
                    'album' => "25",
                    'artist' => "Adele",
                    'spotify_id' => "track:2GvHzQ7VnDEFnpVpRK5vlZ",
                ]
            ],
            $b->getChartData('album')
        );
    }

    public function testGetChartDate()
    {
        $content = file_get_contents(__DIR__ . '/official_chartdate.html');
        $html_obj = \phpQuery::newDocumentHTML($content);
        $b = new Official();

        $ref = new \ReflectionClass('XXX\Crawler\Official');
        $ref_htmlobj = $ref->getProperty('htmlObj');
        $ref_htmlobj->setAccessible(true);
        $ref_htmlobj->setValue($b, $html_obj);

        $this->assertEquals(1456934400, $b->getChartDate());

    }

    /**
     * @dataProvider getChartDataProvider
     */
    public function testGetChartList($type, $html_obj, $expect)
    {
        $b = $this->getMockBuilder('XXX\Crawler\Official')
            ->setMethods(['setHtmlObj'])
            ->getMock();

        if (null != $html_obj) {
            $b->expects($this->once())->method('setHtmlObj');

            $ref = new \ReflectionClass('XXX\Crawler\Official');
            $ref_htmlobj = $ref->getProperty('htmlObj');
            $ref_htmlobj->setAccessible(true);
            $ref_htmlobj->setValue($b, $html_obj);
        }

        $this->assertEquals($expect, $b->getChartList($type));
    }

    public function getChartDataProvider()
    {
        $song_html_obj = \phpQuery::newDocumentHTML(file_get_contents(__DIR__ . '/official_song.html'));
        $album_html_obj = \phpQuery::newDocumentHTML(file_get_contents(__DIR__ . '/official_album.html'));
        return [
            [
                'type' => 'track',
                'html_obj' => $song_html_obj,
                'expect' => [
                    1 => [
                        'position' => "1",
                        'track' => "7 years",
                        'artist' => "Lukas Graham",
                        'spotify_id' => "track:2vDT1uU6hZgdp3PbWGr0Xy",
                    ]
                ]
            ],
            [
                'type' => 'album',
                'html_obj' => $album_html_obj,
                'expect' => [
                    1 => [
                        'position' => "1",
                        'album' => "25",
                        'artist' => "Adele",
                        'spotify_id' => "track:2GvHzQ7VnDEFnpVpRK5vlZ",
                    ]
                ]
            ],
            [
                'type' => 'test',
                'html_obj' => null,
                'expect' => []
            ]
        ];
    }
}
