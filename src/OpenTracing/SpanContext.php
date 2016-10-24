<?php

namespace OpenTracing;

/**
 * SpanContext represents Span state that must propagate to descendant Spans and across process boundaries.
 *
 * SpanContext is logically divided into two pieces: the user-level "Baggage"
 * (see {@link Span::setBaggageItem} and {@link Span::setBaggageItem}) that
 * propagates across Span boundaries and any Tracer-implementation-specific
 * fields that are needed to identify or otherwise contextualize the associated
 * Span instance (e.g., a <trace_id, span_id, sampled> tuple).
 */
interface SpanContext
{
    /**
     * Return baggage associated with this SpanContext.
     *
     * If no baggage has been added to the span, returns an empty dict.
     *
     * @return array<string,string>
     */
    public function getBaggage();
}
