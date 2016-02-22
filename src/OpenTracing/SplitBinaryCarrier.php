<?php

namespace OpenTracing;

class SplitBinaryCarrier
{

    /**
     * @var string
     */
    private $state = null;
    /**
     * @var string
     */
    private $attributes = null;

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return SplitBinaryCarrier
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $attributes
     * @return SplitBinaryCarrier
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

}