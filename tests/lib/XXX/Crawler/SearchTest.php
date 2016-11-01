<?php

namespace XXX\Crawler;

class SearchTest extends \PHPUnit_Framework_TestCase
{
    public function testSearchKkbox()
    {
        $kkbox = $this->getMockBuilder('\Chart\Search\Kkbox')
            ->setMethods(['setSearchQuery', 'setAccessToken'])
            ->getMock();
        $kkbox->expects($this->once())->method('setSearchQuery');
        $kkbox->expects($this->once())->method('setAccessToken');

        $search = $this->getMockBuilder('XXX\Crawler\Search')
            ->setMethods(['getSearchDeviceObject', 'getKkboxAccessToken', 'getResult'])
            ->getMock();
        $search->expects($this->once())->method('getResult');
        $search->expects($this->once())
            ->method('getSearchDeviceObject')
            ->willReturn($kkbox);
        $search->expects($this->exactly(2))
            ->method('getKkboxAccessToken')
            ->willReturn('access_token');

        $search->kkbox(['id' => 'id'], 'track');
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Error: Kkbox access_token isn't exist, please call setKkboxAccessToken() at first.
     */
    public function testSearchKkboxAccessTokenNotExistException()
    {
        $kkbox = $this->getMockBuilder('\Chart\Search\Kkbox')
            ->setMethods(['setSearchQuery', 'setAccessToken'])
            ->getMock();
        $kkbox->expects($this->never())->method('setSearchQuery');
        $kkbox->expects($this->never())->method('setAccessToken');

        $search = $this->getMockBuilder('XXX\Crawler\Search')
            ->setMethods(['getSearchDeviceObject', 'getKkboxAccessToken', 'getResult'])
            ->getMock();
        $search->expects($this->never())->method('getResult');
        $search->expects($this->never())->method('getSearchDeviceObject');
        $search->expects($this->once())->method('getKkboxAccessToken');

        $search->kkbox(['id' => 'id'], 'track');
    }

    public function testSearchKkboxQueryEmpty()
    {
        $kkbox = $this->getMockBuilder('\Chart\Search\Kkbox')
            ->setMethods(['setSearchQuery', 'setAccessToken'])
            ->getMock();
        $kkbox->expects($this->never())->method('setSearchQuery');
        $kkbox->expects($this->never())->method('setAccessToken');

        $search = $this->getMockBuilder('XXX\Crawler\Search')
            ->setMethods(['getSearchDeviceObject', 'getKkboxAccessToken', 'getResult'])
            ->getMock();
        $search->expects($this->never())->method('getSearchDeviceObject');
        $search->expects($this->never())->method('getKkboxAccessToken');
        $search->expects($this->never())->method('getResult');

        $this->assertEquals([], $search->kkbox([], 'track'));
    }

    public function testSearchSpotifyQueryEmpty()
    {
        $spotify = $this->getMockBuilder('\Chart\Search\Spotify')
            ->setMethods(['setSearchQuery'])
            ->getMock();
        $spotify->expects($this->never())->method('setSearchQuery');

        $search = $this->getMockBuilder('XXX\Crawler\Search')
            ->setMethods(['getSearchDeviceObject', 'getResult'])
            ->getMock();
        $search->expects($this->never())->method('getSearchDeviceObject');
        $search->expects($this->never())->method('getResult');

        $this->assertEquals([], $search->spotify([], 'track'));
    }

    public function testSearchSpotify()
    {
        $spotify = $this->getMockBuilder('\Chart\Search\Spotify')
            ->setMethods(['setSearchQuery'])
            ->getMock();
        $spotify->expects($this->once())->method('setSearchQuery');

        $search = $this->getMockBuilder('XXX\Crawler\Search')
            ->setMethods(['getSearchDeviceObject', 'getResult'])
            ->getMock();
        $search->expects($this->once())
            ->method('getSearchDeviceObject')
            ->willReturn($spotify);
        $search->expects($this->once())->method('getResult');

        $search->spotify(['id' => 'track:50R3hdsZQeg3k8zJdVphSZ'], 'track');
    }

    public function testGetSearchDeviceObjectWithPropertyExist()
    {
        $s = $this->getMockBuilder('XXX\Crawler\Search')
            ->setMethods(['createSearchDeviceObject', 'setSearchDeviceObject'])
            ->getMock();
        $s->expects($this->once())->method('createSearchDeviceObject');
        $s->expects($this->once())->method('setSearchDeviceObject');
        $s->getSearchDeviceObject('\Chart\Search\Spotify', 'spotifyObj');
    }

    public function testGetSearchDeviceObjectWithPropertyNotExist()
    {
        $s = $this->getMockBuilder('XXX\Crawler\Search')
            ->setMethods(['createSearchDeviceObject', 'setSearchDeviceObject'])
            ->getMock();
        $s->expects($this->never())->method('createSearchDeviceObject');
        $s->expects($this->never())->method('setSearchDeviceObject');


        $ref = new \ReflectionClass('XXX\Crawler\Search');
        $ref_spotify = $ref->getProperty('spotifyObj');
        $ref_spotify->setAccessible(true);
        $ref_spotify->setValue($s, new \Chart\Search\Spotify());

        $s->getSearchDeviceObject('\Chart\Search\Spotify', 'spotifyObj');
    }

    public function testCreateSearchDeviceObject()
    {
        $s = new Search();
        $this->assertTrue(is_object($s->createSearchDeviceObject('Chart\Search\Spotify')));
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Error: Kkbox isn't exist
     */
    public function testCreateSearchDeviceObjectException()
    {
        $s = new Search();
        $s->createSearchDeviceObject('Kkbox');
    }

    public function testSpotifySearchResultFromId()
    {
        $query = ['id' => 'track:50R3hdsZQeg3k8zJdVphSZ'];

        $s = $this->getMockBuilder('Chart\Search\Spotify')
            ->setMethods(['searchById', 'searchByKeyword'])
            ->getMock();
        $s->setSearchQuery($query);
        $s->expects($this->once())
            ->method('searchById')
            ->willReturn(true);
        $s->expects($this->never())
            ->method('searchByKeyword');

        $search = new Search();
        $search->getResult($s, 'track');
    }

    public function testSpotifySearchResultFromKeyword()
    {
        $query = [
            'track' => 'Work',
            'artist' => 'Rihanna Featuring Drake'
        ];

        $s = $this->getMockBuilder('Chart\Search\Spotify')
            ->setMethods(['searchById', 'searchByKeyword'])
            ->getMock();
        $s->setSearchQuery($query);
        $s->expects($this->once())
            ->method('searchById');
        $s->expects($this->once())
            ->method('searchByKeyword');

        $search = new Search();
        $search->getResult($s, 'track');
    }

    public function testKkboxSearchResultFromId()
    {
        $query = ['id' => 'track:4kxvr3wPWkaL9_y3o_'];

        $k = $this->getMockBuilder('Chart\Search\Kkbox')
            ->setMethods(['searchById', 'searchByKeyword'])
            ->getMock();
        $k->setSearchQuery($query);
        $k->expects($this->once())
            ->method('searchById')
            ->willReturn(true);
        $k->expects($this->never())
            ->method('searchByKeyword');

        $search = new Search();
        $search->getResult($k, 'track');
    }

    public function testKkboxSearchResultFromKeyword()
    {
        $query = [
            'track' => 'Work',
            'artist' => 'Rihanna Featuring Drake'
        ];

        $k = $this->getMockBuilder('Chart\Search\Kkbox')
            ->setMethods(['searchById', 'searchByKeyword'])
            ->getMock();
        $k->setSearchQuery($query);
        $k->expects($this->once())
            ->method('searchById');
        $k->expects($this->once())
            ->method('searchByKeyword');

        $search = new Search();
        $search->getResult($k, 'track');
    }
}
