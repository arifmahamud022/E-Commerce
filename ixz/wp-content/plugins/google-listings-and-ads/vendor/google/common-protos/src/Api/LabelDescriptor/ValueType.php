<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/label.proto

namespace Google\Api\LabelDescriptor;

use UnexpectedValueException;

/**
 * Value types that can be used as label values.
 *
 * Protobuf type <code>google.api.LabelDescriptor.ValueType</code>
 */
class ValueType
{
    /**
     * A variable-length string. This is the default.
     *
     * Generated from protobuf enum <code>STRING = 0;</code>
     */
    const STRING = 0;
    /**
     * Boolean; true or false.
     *
     * Generated from protobuf enum <code>BOOL = 1;</code>
     */
    const BOOL = 1;
    /**
     * A 64-bit signed integer.
     *
     * Generated from protobuf enum <code>INT64 = 2;</code>
     */
    const INT64 = 2;

    private static $valueToName = [
        self::STRING => 'STRING',
        self::BOOL => 'BOOL',
        self::INT64 => 'INT64',
    ];

    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }


    public static function value($name)
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return constant($const);
    }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ValueType::class, \Google\Api\LabelDescriptor_ValueType::class);

