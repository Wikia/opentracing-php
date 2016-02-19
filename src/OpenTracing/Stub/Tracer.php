<?php

namespace OpenTracing\Stub;

use OpenTracing\Injector;
use OpenTracing\Extractor;

/**
 * Tracer is the entry point API between instrumentation code and the
 * tracing implementation.
 *
 * This implementation both defines the public Tracer API, and provides
 * a default no-op behavior.
 *
 * @package OpenTracing
 */
class Tracer {
	private $noopSpan = null;
	private $noopPropagator = null;

	function __construct() {
		$this->noopSpan = new Span( $this );
		$this->noopPropagator = new NoopPropagator( $this, $this->noopSpan );
	}

	/**
	 * Starts and returns a new Span representing a unit of work.
	 *
	 * @param string $operationName
	 * @param Span $parent
	 * @param array $tags
	 * @param int $startTime
	 * @return Span
	 */
	function startSpan( $operationName = null, $parent = null, $tags = null, $startTime = null ) {
		return $this->noopSpan;
	}

	/**
	 * Returns an Injector instance corresponding to $format
	 *
	 * @param string $format
	 * @return Injector
	 */
	function injector( $format ) {
		return $this->noopPropagator;
	}

	/**
	 * Returns an Extractor instance corresponding to $format
	 *
	 * @param string $format
	 * @return Extractor
	 */
	function extractor( $format ) {
		return $this->noopPropagator;
	}

	/**
	 * Flushes any trace data that may be buffered in memory, presumably
	 * out of the process.
	 *
	 * @return void
	 */
	function flush() {
		// noop
	}
}