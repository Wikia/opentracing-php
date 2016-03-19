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
    private $baggage = null;

    /**
     * Create new SplitBinaryCarrier and optionally initialize it
     *
     * @param string|null $state
     * @param string|null $baggage
     */
    public function __construct($state = null, $baggage = null)
    {
        $this->state = $state;
        $this->baggage = $baggage;
    }

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
    public function getBaggage()
    {
        return $this->baggage;
    }

    /**
     * @param string $baggage
     * @return SplitBinaryCarrier
     */
    public function setBaggage($baggage)
    {
        $this->baggage = $baggage;

        return $this;
    }

}