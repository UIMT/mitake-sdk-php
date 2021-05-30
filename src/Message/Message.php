<?php

namespace Mitake\Message;

/**
 * Class Message
 * @package Mitake
 */
class Message
{
    private $queryData = [];

    public function __construct($queryData)
    {
        $this->queryData = $queryData;
    }

    public function set($key, $value)
    {
        $this->queryData[$key] = $value;
        return $this;
    }

    public function get($key)
    {
        return isset($this->queryData[$key]) ? $this->queryData[$key] : null;
    }

    public function getQueryString()
    {
        return http_build_query($this->queryData);
    }

    public function getBulkString()
    {
        return implode('$$', [
            $this->queryData['clientid'],
            $this->queryData['dstaddr'],
            $this->queryData['dlvtime'] ?? '',
            $this->queryData['vldtime'] ?? '',
            $this->queryData['destname'] ?? '',
            $this->queryData['response'] ?? '',
            $this->queryData['smbody'],
        ]) . "\n";
    }
}
