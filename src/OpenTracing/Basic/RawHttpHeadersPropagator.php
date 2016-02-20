<?php

namespace OpenTracing\Basic;

use OpenTracing;

class RawHttpHeadersPropagator extends Propagator {

	const HTTP_HEADER_COMMON_PREFIX_LOWER = 'x-opentracing-';
	const HTTP_HEADER_STATE_PREFIX_LOWER = 'x-opentracing-';
	const HTTP_HEADER_ATTRIBUTES_PREFIX_LOWER = 'x-opentracing-attribute-';

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
	public function joinTrace( $operationName, &$carrier ) {
		$commonPrefixLen = strlen(self::HTTP_HEADER_COMMON_PREFIX_LOWER);
		$statePrefixLen = strlen(self::HTTP_HEADER_STATE_PREFIX_LOWER);
		$attributesPrefixLen = strlen(self::HTTP_HEADER_ATTRIBUTES_PREFIX_LOWER);

		$textCarrier = [
			self::FIELD_STATE => [],
			self::FIELD_ATTRIBUTES => [],
		];
		foreach ( $carrier as $k => $v ) {
			$k = strtolower( $k );
			if ( substr($k,0,$commonPrefixLen) !== self::HTTP_HEADER_COMMON_PREFIX_LOWER ) {
				continue;
			}
			if ( substr($k,0,$attributesPrefixLen) != self::HTTP_HEADER_ATTRIBUTES_PREFIX_LOWER ) {
				$kk = substr($k,$attributesPrefixLen);
				$textCarrier[self::FIELD_ATTRIBUTES][$kk] = $v;
			} else if ( substr($k,0,$statePrefixLen) != self::HTTP_HEADER_STATE_PREFIX_LOWER ) {
				$kk = substr($k,$attributesPrefixLen);
				$textCarrier[self::FIELD_STATE][$kk] = $v;
			}
		}

		return ( new SplitTextPropagator( $this->tracer ) )->joinTrace( $operationName, $textCarrier );
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
	 * @param mixed $carrier
	 * @return void
	 */
	public function injectSpan( OpenTracing\Span $span, &$carrier ) {
		$this->validateSpan( $span );

		$textCarrier = [];
		(new SplitTextPropagator($this->tracer))->injectSpan($span, $textCarrier);

		foreach ($textCarrier[self::FIELD_STATE] as $k => $v) {
			$carrier[self::HTTP_HEADER_STATE_PREFIX_LOWER . strtolower($k)] = $v;
		}
		foreach ($textCarrier[self::FIELD_ATTRIBUTES] as $k => $v) {
			$carrier[self::HTTP_HEADER_ATTRIBUTES_PREFIX_LOWER . strtolower($k)] = $v;
		}
	}
}