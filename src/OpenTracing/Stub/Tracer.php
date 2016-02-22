<?php

namespace OpenTracing\Stub;

use OpenTracing\Injector;
use OpenTracing\Extractor;

/**
 * Tracer is the entry point API between instrumentation code and the
 * tracing implementation.
 *
 * This implementation both defines the public Tracer API, and provides
 * a default no-op behavior.
 *
 * @package OpenTracing
 */
class Tracer
{
    private $noopSpan = null;
    private $noopPropagator = null;

    public function __construct()
    {
        $this->noopSpan = new Span($this);
        $this->noopPropagator = new Propagator($this, $this->noopSpan);
    }

    /**
     * Starts and returns a new Span representing a unit of work.
     *
     * @param string $operationName
     * @param Span $parent
     * @param array $tags
     * @param float $startTime
     * @return Span
     */
    public function startSpan($operationName = null, $parent = null, $tags = null, $startTime = null)
    {
        return $this->noopSpan;
    }

    /**
     * Returns an Injector instance corresponding to $format
     *
     * @param string $format
     * @return Injector
     */
    public function injector($format)
    {
        return $this->noopPropagator;
    }

    /**
     * Returns an Extractor instance corresponding to $format
     *
     * @param string $format
     * @return Extractor
     */
    public function extractor($format)
    {
        return $this->noopPropagator;
    }

    /**
     * Flushes any trace data that may be buffered in memory, presumably
     * out of the process.
     *
     * @return void
     */
    public function flush()
    {
        // noop
    }
}