<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: app/Proto/notification.proto

namespace GRPC\Services\Notification;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>microtix.EventDeleteData</code>
 */
class EventDeleteData extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>int32 event_id = 1;</code>
     */
    protected $event_id = 0;
    /**
     * Generated from protobuf field <code>string event_name = 2;</code>
     */
    protected $event_name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $event_id
     *     @type string $event_name
     * }
     */
    public function __construct($data = NULL) {
        \GRPC\Services\Notification\Meta\Notification::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>int32 event_id = 1;</code>
     * @return int
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * Generated from protobuf field <code>int32 event_id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setEventId($var)
    {
        GPBUtil::checkInt32($var);
        $this->event_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string event_name = 2;</code>
     * @return string
     */
    public function getEventName()
    {
        return $this->event_name;
    }

    /**
     * Generated from protobuf field <code>string event_name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setEventName($var)
    {
        GPBUtil::checkString($var, True);
        $this->event_name = $var;

        return $this;
    }

}

