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
interface Tracer {
	/**
	 * Starts and returns a new Span representing a unit of work.
	 *
	 * @param string $operationName
	 * @param Span $parent
	 * @param array $tags
	 * @param float $startTime
	 * @return Span
	 */
	public function startSpan( $operationName = null, $parent = null, $tags = null, $startTime = null );

	/**
	 * Returns an Injector instance corresponding to $format
	 *
	 * @param string $format
	 * @return Injector
	 */
	public function injector( $format );

	/**
	 * Returns an Extractor instance corresponding to $format
	 *
	 * @param string $format
	 * @return Extractor
	 */
	public function extractor( $format );

	/**
	 * Flushes any trace data that may be buffered in memory, presumably
	 * out of the process.
	 *
	 * @return void
	 */
	public function flush();
}