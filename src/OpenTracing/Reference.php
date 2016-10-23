<?php

namespace OpenTracing;

class Reference
{
    const CHILD_OF = 1;
    const FOLLOWS_FROM = 2;

    private $type;
    private $context;

    public static function childOf(SpanContext $context)
    {
        return new self(self::CHILD_OF, $context);
    }

    public static function followsFrom(SpanContext $context)
    {
        return new self(self::FOLLOWS_FROM, $context);
    }

    private function __construct($type, SpanContext $context)
    {
        $this->type = $type;
        $this->context = $context;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getContext()
    {
        return $this->context;
    }
}
