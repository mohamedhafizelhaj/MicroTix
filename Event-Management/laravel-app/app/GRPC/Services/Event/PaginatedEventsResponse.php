<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: app/Proto/event.proto

namespace GRPC\Services\Event;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>microtix.PaginatedEventsResponse</code>
 */
class PaginatedEventsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .microtix.EventInstance events = 1;</code>
     */
    private $events;
    /**
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     */
    protected $next_page_token = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \GRPC\Services\Event\EventInstance[]|\Google\Protobuf\Internal\RepeatedField $events
     *     @type string $next_page_token
     * }
     */
    public function __construct($data = NULL) {
        \GRPC\Services\Event\Meta\Event::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .microtix.EventInstance events = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Generated from protobuf field <code>repeated .microtix.EventInstance events = 1;</code>
     * @param \GRPC\Services\Event\EventInstance[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setEvents($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \GRPC\Services\Event\EventInstance::class);
        $this->events = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setNextPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->next_page_token = $var;

        return $this;
    }

}

