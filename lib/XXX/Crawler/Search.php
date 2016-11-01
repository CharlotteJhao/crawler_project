<?php

namespace XXX\Crawler;

class Search
{
    protected $spotifyObj;
    protected $kkboxObj;
    protected $kkboxAccessToken;

    public function kkbox(array $query, $type, $territory_code = null)
    {
        if (empty($query)) {
            return [];
        }

        if (0 === strlen($this->getKkboxAccessToken())) {
            throw new \Exception(
                "Error: Kkbox access_token isn't exist, please call setKkboxAccessToken() at first."
            );
        }

        $kkbox = $this->getSearchDeviceObject('\Chart\Search\Kkbox', 'kkboxObj');
        $kkbox->setAccessToken($this->getKkboxAccessToken());
        $kkbox->setSearchQuery($query);

        return $this->getResult($kkbox, $type, $territory_code);
    }

    public function spotify(array $query, $type, $territory_code = null)
    {
        if (empty($query)) {
            return [];
        }

        $spotify = $this->getSearchDeviceObject('\Chart\Search\Spotify', 'spotifyObj');
        $spotify->setSearchQuery($query);

        return $this->getResult($spotify, $type, $territory_code);
    }

    public function getSearchDeviceObject($class, $property_name)
    {
        if (!$this->$property_name) {
            $this->setSearchDeviceObject($property_name, $this->createSearchDeviceObject($class));
        }

        return $this->$property_name;
    }

    public function setSearchDeviceObject($property_name, $device_obj)
    {
        $this->$property_name = $device_obj;
    }

    public function createSearchDeviceObject($class)
    {
        if (class_exists($class)) {
            return new $class();
        } else {
            throw new \Exception("Error: {$class} isn't exist");
        }
    }

    public function getResult(\Chart\Search $search, $type, $territory_code = null)
    {
        $result = $this->searchById($search);
        return ($result) ?: $this->searchByKeyword($search, $type, $territory_code);
    }

    public function searchById(\Chart\Search $search, $territory_code = null)
    {
        return $search->searchById($territory_code);
    }

    public function searchByKeyword(\Chart\Search $search, $type, $territory_code = null)
    {
        return $search->searchByKeyword($type, $territory_code);
    }

    public function getKkboxAccessToken()
    {
        return $this->kkboxAccessToken;
    }

    public function setKkboxAccessToken($access_token)
    {
        $this->kkboxAccessToken = $access_token;
    }
}
