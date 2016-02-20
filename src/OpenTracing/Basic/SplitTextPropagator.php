<?php

namespace OpenTracing\Basic;

use OpenTracing;

class SplitTextPropagator extends Propagator {

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
	function joinTrace( $operationName, &$carrier ) {
		if ( !$carrier || !is_array($carrier) || empty($carrier[self::FIELD_STATE]) || empty($carrier[self::FIELD_ATTRIBUTES])
			|| !array_key_exists(self::FIELD_TRACE_ID, $carrier[self::FIELD_STATE])
			|| !array_key_exists(self::FIELD_SPAN_ID, $carrier[self::FIELD_STATE])
		) {
			throw new \InvalidArgumentException('Carrier does not contain valid tracer data');
		}

		$traceId = $carrier[self::FIELD_STATE][self::FIELD_TRACE_ID];
		$spanId = $carrier[self::FIELD_STATE][self::FIELD_SPAN_ID];
		$attributes = $carrier[self::FIELD_ATTRIBUTES];

		return $this->tracer->createSpan($traceId, $spanId, $attributes);
	}

	/**
	 * Takes $span and injects it into $carrier.
	 *
	 * The actual type of $carrier depends on the $format value passed to
	 * Tracer.injector().
	 *
	 * Implementations may raise implementation-specific exception
	 * if injection fails.
	 *
	 * @param OpenTracing\Span $span
	 * @param $carrier
	 * @return void
	 */
	function injectSpan( OpenTracing\Span $span, &$carrier ) {
		$this->validateSpan($span);

		$spanData = $span->getData();
		$carrier[self::FIELD_STATE] = [
			self::FIELD_TRACE_ID => $spanData->traceId,
			self::FIELD_SPAN_ID => $spanData->spanId,
		];
		$carrier[self::FIELD_ATTRIBUTES] = $spanData->attributes;
	}
}