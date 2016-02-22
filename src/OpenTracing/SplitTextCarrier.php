<?php

namespace OpenTracing;

class SplitTextCarrier
{
    /**
     * @var array
     */
    private $state = null;
    /**
     * @var array
     */
    private $attributes = null;

    /**
     * @return array
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param array $state
     * @return SplitTextCarrier
     */
    public function setState(array $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return SplitTextCarrier
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

}