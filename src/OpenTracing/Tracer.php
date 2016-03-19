<?php

namespace OpenTracing;

/**
 * Tracer is the entry point API between instrumentation code and the
 * tracing implementation.
 *
 * This implementation both defines the public Tracer API, and provides
 * a default no-op behavior.
 *
 * @package OpenTracing
 */
abstract class Tracer
{
    /**
     * @var Tracer
     */
    private static $globalTracerInstance = null;

    /**
     * Starts and returns a new Span representing a unit of work.
     *
     * @param string $operationName
     * @param Span $parent
     * @param array $tags
     * @param float $startTime
     * @return Span
     */
    abstract public function startSpan($operationName = null, $parent = null, $tags = null, $startTime = null);

    /**
     * Takes $span and injects it into $carrier.
     *
     * The actual type of $carrier depends on the $format.
     *
     * Implementations may raise implementation-specific exception
     * if injection fails.
     *
     * @param Span $span
     * @param string $format
     * @param mixed $carrier
     * @throws \OpenTracing\Exception
     */
    abstract public function inject(Span $span, $format, &$carrier);

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
     * @return Span
     */
    abstract public function join($operationName, $format, $carrier);

    /**
     * Flushes any trace data that may be buffered in memory, presumably
     * out of the process.
     *
     * @return void
     */
    abstract public function flush();

    /**
     * Initialize the GlobalTracer singleton with the provided Tracer instance
     *
     * @param Tracer $tracer
     */
    public static final function setGlobalTracer(Tracer $tracer)
    {
        self::$globalTracerInstance = $tracer;
    }

    /**
     * Gets current GlobalTracer singleton.
     *
     * Returns stub tracer if not initialized yet.
     *
     * @return Tracer|null
     */
    public static final function getGlobalTracer()
    {
        if ( self::$globalTracerInstance === null ) {
            self::$globalTracerInstance = new Stub\Tracer();
        }

        return self::$globalTracerInstance;
    }

}