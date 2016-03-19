<?php

namespace OpenTracing\Stub;

use OpenTracing;

/**
 * Tracer is the entry point API between instrumentation code and the
 * tracing implementation.
 *
 * This implementation both defines the public Tracer API, and provides
 * a default no-op behavior.
 *
 * @package OpenTracing
 */
class Tracer extends OpenTracing\Tracer
{
    private $noopSpan = null;

    public function __construct()
    {
        $this->noopSpan = new Span($this);
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
     * Takes $span and injects it into $carrier.
     *
     * The actual type of $carrier depends on the $format.
     *
     * Implementations may raise implementation-specific exception
     * if injection fails.
     *
     * @param OpenTracing\Span $span
     * @param string $format
     * @param mixed $carrier
     * @throws \OpenTracing\Exception
     */
    public function inject(OpenTracing\Span $span, $format, &$carrier) {
        // noop
    }

    /**
     * Returns a Span instance with operation name $operationName
     * that's joined to the trace state embedded within $carrier, or null if
     * no such trace state could be found.
     *
     * Implementations may raise implementation-specific errors
     * if there are more fundamental problems with `carrier`.
     *
     * Upon success, the returned Span instance is already started.
     *
     * @param string $operationName
     * @param string $format
     * @param mixed $carrier
     * @throws \OpenTracing\Exception
     * @return OpenTracing\Span
     */
    public function join($operationName, $format, $carrier) {
        return $this->noopSpan;
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