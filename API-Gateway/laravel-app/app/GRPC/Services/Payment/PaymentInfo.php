<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: app/Proto/payment.proto

namespace GRPC\Services\Payment;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>microtix.PaymentInfo</code>
 */
class PaymentInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>int32 customer_id = 1;</code>
     */
    protected $customer_id = 0;
    /**
     * Generated from protobuf field <code>int32 event_id = 2;</code>
     */
    protected $event_id = 0;
    /**
     * Generated from protobuf field <code>string email = 3;</code>
     */
    protected $email = '';
    /**
     * Generated from protobuf field <code>string card = 4;</code>
     */
    protected $card = '';
    /**
     * Generated from protobuf field <code>int64 exp_month = 5;</code>
     */
    protected $exp_month = 0;
    /**
     * Generated from protobuf field <code>int64 exp_year = 6;</code>
     */
    protected $exp_year = 0;
    /**
     * Generated from protobuf field <code>string cvv = 7;</code>
     */
    protected $cvv = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $customer_id
     *     @type int $event_id
     *     @type string $email
     *     @type string $card
     *     @type int|string $exp_month
     *     @type int|string $exp_year
     *     @type string $cvv
     * }
     */
    public function __construct($data = NULL) {
        \GRPC\Services\Payment\Meta\Payment::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>int32 customer_id = 1;</code>
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Generated from protobuf field <code>int32 customer_id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setCustomerId($var)
    {
        GPBUtil::checkInt32($var);
        $this->customer_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 event_id = 2;</code>
     * @return int
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * Generated from protobuf field <code>int32 event_id = 2;</code>
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
     * Generated from protobuf field <code>string email = 3;</code>
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Generated from protobuf field <code>string email = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setEmail($var)
    {
        GPBUtil::checkString($var, True);
        $this->email = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string card = 4;</code>
     * @return string
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * Generated from protobuf field <code>string card = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setCard($var)
    {
        GPBUtil::checkString($var, True);
        $this->card = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int64 exp_month = 5;</code>
     * @return int|string
     */
    public function getExpMonth()
    {
        return $this->exp_month;
    }

    /**
     * Generated from protobuf field <code>int64 exp_month = 5;</code>
     * @param int|string $var
     * @return $this
     */
    public function setExpMonth($var)
    {
        GPBUtil::checkInt64($var);
        $this->exp_month = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int64 exp_year = 6;</code>
     * @return int|string
     */
    public function getExpYear()
    {
        return $this->exp_year;
    }

    /**
     * Generated from protobuf field <code>int64 exp_year = 6;</code>
     * @param int|string $var
     * @return $this
     */
    public function setExpYear($var)
    {
        GPBUtil::checkInt64($var);
        $this->exp_year = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string cvv = 7;</code>
     * @return string
     */
    public function getCvv()
    {
        return $this->cvv;
    }

    /**
     * Generated from protobuf field <code>string cvv = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setCvv($var)
    {
        GPBUtil::checkString($var, True);
        $this->cvv = $var;

        return $this;
    }

}

