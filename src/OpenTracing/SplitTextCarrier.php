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
    private $baggage = null;

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
    public function getBaggage()
    {
        return $this->baggage;
    }

    /**
     * @param array $baggage
     * @return SplitTextCarrier
     */
    public function setBaggage(array $baggage)
    {
        $this->baggage = $baggage;

        return $this;
    }

}