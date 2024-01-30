<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: app/Proto/event.proto

namespace GRPC\Services\Event;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>microtix.Status</code>
 */
class Status extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>bool success = 1;</code>
     */
    protected $success = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $success
     * }
     */
    public function __construct($data = NULL) {
        \GRPC\Services\Event\Meta\Event::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>bool success = 1;</code>
     * @return bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Generated from protobuf field <code>bool success = 1;</code>
     * @param bool $var
     * @return $this
     */
    public function setSuccess($var)
    {
        GPBUtil::checkBool($var);
        $this->success = $var;

        return $this;
    }

}
