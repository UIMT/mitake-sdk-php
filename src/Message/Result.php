<?php

namespace Mitake\Message;

/**
 * Class Result
 * @package Mitake\Message
 */
class Result
{
    /**
     * @var string
     */
    protected $msgid;

    /**
     * @var StatusCode
     */
    protected $statuscode;

    /**
     * @var string
     */
    protected $error;

    /**
     * @return string
     */
    public function getMsgid()
    {
        return $this->msgid;
    }

    /**
     * @param string $msgid
     * @return $this
     */
    public function setMsgid($msgid)
    {
        $this->msgid = $msgid;

        return $this;
    }

    /**
     * @return StatusCode
     */
    public function getStatuscode()
    {
        return $this->statuscode;
    }

    /**
     * @param StatusCode $statuscode
     * @return $this
     */
    public function setStatuscode(StatusCode $statuscode)
    {
        $this->statuscode = $statuscode;

        return $this;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'msgid' => $this->msgid,
            'statuscode' => (is_null($this->statuscode)) ? null : $this->statuscode->__toString(),
            'error' => $this->error,
        ];
    }
}
