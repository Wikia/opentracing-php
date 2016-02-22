<?php

namespace OpenTracing;

/**
 * An Extractor extracts Span instances from a format-specific "carrier" object.
 *
 * Typically the carrier has just arrived across a process boundary, often via
 * an RPC (though message queues and other IPC mechanisms are also reasonable
 * places to use an Extractor).
 *
 * See Injector and Tracer.extractor().
 *
 * @package OpenTracing
 */
interface Extractor
{

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
     * @param mixed $carrier
     * @return Span
     */
    public function joinTrace($operationName, &$carrier);
}