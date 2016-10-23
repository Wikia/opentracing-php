<?php

namespace OpenTracing;

/**
 * Tracer is the entry point API between instrumentation code and the
 * tracing implementation.
 *
 * This implementation both defines the public Tracer API, and provides
 * a default no-op behavior.
 */
interface Tracer
{
    /**
     * Starts and returns a new Span representing a unit of work.
     *
     * @param string $operationName
     * @param array $options
     *      'child_of' (optional) a Span or SpanContext instance representing
     *                 the parent in a REFERENCE_CHILD_OF Reference. If
     *                 specified, the `references` parameter must be omitted.
     *      'references' (optional) a list of Reference objects that identify one or more parent SpanContexts.
     *                   (See the Reference documentation for detail)
     *      'tags' an optional dictionary of Span Tags.
     *      'start_time' an explicit Span start time as a {@link \DateTime}
     * @return Span
     */
    public function startSpan($operationName = null, array $options = array());

    /**
     * Injects `span_context` into `carrier`.
     *
     * The type of `carrier` is determined by `format`. See the
     * {@link \OpenTracing\Propagation} class/namespace for the built-in
     * OpenTracing formats.
     *
     * Implementations MUST raise {@link OpenTracing\UnsupportedFormatException} if
     * `format` is unknown or disallowed.
     *
     * The actual type of $carrier depends on the $format.
     *
     * @param SpanContext $context
     * @param string $format
     * @param mixed $carrier
     * @throws \OpenTracing\UnsupportedFormatException
     */
    public function inject(SpanContext $context, $format, &$carrier);

    /**
     * Returns a SpanContext instance extracted from a `carrier` of the given `format`, or None if no such SpanContext could be found.
     *
     * The type of `carrier` is determined by `format`. See the
     * {@link OpenTracing\Propagation} class/namespace for the built-in
     * OpenTracing formats.
     *
     * Implementations MUST raise {@link OpenTracing\UnsupportedFormatException} if
     * `format` is unknown or disallowed.
     *
     * Implementations may raise {@link OpenTracing\InvalidCarrierException},
     * {@link OpenTracing\SpanContextCorruptedException}, or
     * implementation-specific errors if there are problems with `carrier`.
     *
     * @param string $format
     * @param mixed $carrier
     * @throws \OpenTracing\UnsupportedFormatException
     * @throws \OpenTracing\InvalidCarrierException
     * @return SpanContext
     */
    public function extract($format, $carrier);
}
