<?php

namespace OpenTracing;

/**
 * An Injector injects Span instances into a format-specific "carrier"
 * object.
 *
 * Typically the carrier will then propagate across a process boundary, often
 * via an RPC (though message queues and other IPC mechanisms are also
 * reasonable places to use an Injector).
 *
 * See Extractor and Tracer.injector().
 *
 * @package OpenTracing
 */
interface Injector
{

    /**
     * Takes $span and injects it into $carrier.
     *
     * The actual type of $carrier depends on the $format value passed to
     * Tracer.injector().
     *
     * Implementations may raise implementation-specific exception
     * if injection fails.
     *
     * @param Span $span
     * @param mixed $carrier
     * @return void
     */
    public function injectSpan(Span $span, &$carrier);
}