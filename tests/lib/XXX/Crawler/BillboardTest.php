<?php

namespace XXX\Crawler;

class BillboardTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDomain()
    {
        $c = new Billboard();
        $this->assertEquals('http://www.billboard.com/charts/', $c->getDomain());
    }

    public function testGetChartTypeTarget()
    {
        $c = new Billboard();
        $this->assertEquals(
            [
                'track' => 'hot-100',
                'album' => 'billboard-200'
            ],
            $c->getChartTypeTarget()
        );
    }

    public function testGetChartDataByHot100()
    {
        $content = file_get_contents(__DIR__ . '/billboard_song.html');
        $html_obj = \phpQuery::newDocumentHTML($content);
        $b = new Billboard();

        $ref = new \ReflectionClass('XXX\Crawler\Billboard');
        $ref_htmlobj = $ref->getProperty('htmlObj');
        $ref_htmlobj->setAccessible(true);
        $ref_htmlobj->setValue($b, $html_obj);

        $this->assertEquals(
            [
                1 => [
                    'position' => "1",
                    'track' => "Work",
                    'artist' => "Rihanna Featuring Drake",
                    'spotify_id' => "track:50R3hdsZQeg3k8zJdVphSZ",
                ]
            ],
            $b->getChartData('track')
        );
    }

    public function testGetChartDataByBillbaord200()
    {
        $content = file_get_contents(__DIR__ . '/billboard_album.html');
        $html_obj = \phpQuery::newDocumentHTML($content);
        $b = new Billboard();

        $ref = new \ReflectionClass('XXX\Crawler\Billboard');
        $ref_htmlobj = $ref->getProperty('htmlObj');
        $ref_htmlobj->setAccessible(true);
        $ref_htmlobj->setValue($b, $html_obj);

        $this->assertEquals(
            [
                1 => [
                    'position' => '1',
                    'album' => '25',
                    'artist' => 'Adele',
                    'spotify_id' => 'album:1pOiW2SuKzAV6zl7UTKvWt'
                ]
            ],
            $b->getChartData('album')
        );
    }

    public function testGetChartDate()
    {
        $content = file_get_contents(__DIR__ . '/billboard_chartdate.html');
        $html_obj = \phpQuery::newDocumentHTML($content);
        $b = new Billboard();

        $ref = new \ReflectionClass('XXX\Crawler\Billboard');
        $ref_htmlobj = $ref->getProperty('htmlObj');
        $ref_htmlobj->setAccessible(true);
        $ref_htmlobj->setValue($b, $html_obj);

        $this->assertEquals(1457712000, $b->getChartDate());

    }

    /**
     * @dataProvider getChartDataProvider
     */
    public function testGetChartList($type, $html_obj, $expect)
    {
        $b = $this->getMockBuilder('XXX\Crawler\Billboard')
            ->setMethods(['setHtmlObj'])
            ->getMock();

        if (null != $html_obj) {
            $b->expects($this->once())->method('setHtmlObj');

            $ref = new \ReflectionClass('XXX\Crawler\Billboard');
            $ref_htmlobj = $ref->getProperty('htmlObj');
            $ref_htmlobj->setAccessible(true);
            $ref_htmlobj->setValue($b, $html_obj);
        }

        $this->assertEquals($expect, $b->getChartList($type));
    }

    public function getChartDataProvider()
    {
        $song_html_obj = \phpQuery::newDocumentHTML(file_get_contents(__DIR__ . '/billboard_song.html'));
        $album_html_obj = \phpQuery::newDocumentHTML(file_get_contents(__DIR__ . '/billboard_album.html'));
        return [
            [
                'type' => 'track',
                'html_obj' => $song_html_obj,
                'expect' => [
                    1 => [
                        'position' => "1",
                        'track' => "Work",
                        'artist' => "Rihanna Featuring Drake",
                        'spotify_id' => "track:50R3hdsZQeg3k8zJdVphSZ",
                    ]
                ]
            ],
            [
                'type' => 'album',
                'html_obj' => $album_html_obj,
                'expect' => [
                    1 => [
                        'position' => '1',
                        'album' => '25',
                        'artist' => 'Adele',
                        'spotify_id' => 'album:1pOiW2SuKzAV6zl7UTKvWt'
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
