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
     * Create new SplitTextCarrier and optionally initialize it
     *
     * @param array|null $state
     * @param array|null $baggage
     */
    public function __construct(array $state = null, array $baggage = null)
    {
        $this->state = $state;
        $this->baggage = $baggage;
    }

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