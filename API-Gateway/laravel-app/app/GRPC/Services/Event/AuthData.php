<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: app/Proto/event.proto

namespace GRPC\Services\Event;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>microtix.AuthData</code>
 */
class AuthData extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>int32 EventId = 1;</code>
     */
    protected $EventId = 0;
    /**
     * Generated from protobuf field <code>int32 OrganizerId = 2;</code>
     */
    protected $OrganizerId = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $EventId
     *     @type int $OrganizerId
     * }
     */
    public function __construct($data = NULL) {
        \GRPC\Services\Event\Meta\Event::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>int32 EventId = 1;</code>
     * @return int
     */
    public function getEventId()
    {
        return $this->EventId;
    }

    /**
     * Generated from protobuf field <code>int32 EventId = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setEventId($var)
    {
        GPBUtil::checkInt32($var);
        $this->EventId = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 OrganizerId = 2;</code>
     * @return int
     */
    public function getOrganizerId()
    {
        return $this->OrganizerId;
    }

    /**
     * Generated from protobuf field <code>int32 OrganizerId = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setOrganizerId($var)
    {
        GPBUtil::checkInt32($var);
        $this->OrganizerId = $var;

        return $this;
    }

}

