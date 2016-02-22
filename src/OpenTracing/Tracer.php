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
     * Returns an Injector instance corresponding to $format
     *
     * @param string $format
     * @return Injector
     */
    abstract public function injector($format);

    /**
     * Returns an Extractor instance corresponding to $format
     *
     * @param string $format
     * @return Extractor
     */
    abstract public function extractor($format);

    /**
     * Flushes any trace data that may be buffered in memory, presumably
     * out of the process.
     *
     * @return void
     */
    abstract public function flush();

    /**
     * Initialized the GlobalTracer singleton with the provided Tracer instance
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
     * Returns null if not initialized yet.
     *
     * @return Tracer|null
     */
    public static final function getGlobalTracer()
    {
        return self::$globalTracerInstance;
    }

}