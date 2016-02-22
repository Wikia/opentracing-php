<?php

namespace OpenTracing;

class GlobalTracer
{

    /**
     * @var Tracer
     */
    private static $instance = null;

    /**
     * Initialized the GlobalTracer singleton with the provided Tracer instance
     *
     * @param Tracer $tracer
     */
    public static function init(Tracer $tracer)
    {
        self::$instance = $tracer;
    }

    /**
     * Gets current GlobalTracer singleton.
     *
     * Returns null if not initialized yet.
     *
     * @return Tracer|null
     */
    public static function get()
    {
        return self::$instance;
    }

    /**
     * Starts a Span without a parent using GlobalTracer singleton
     *
     * @param string $operationName
     * @return Span
     */
    public static function startSpan($operationName)
    {
        return self::$instance->startSpan($operationName);
    }
}