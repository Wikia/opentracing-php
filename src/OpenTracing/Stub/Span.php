<?php

namespace OpenTracing\Stub;

/**
 * Span represents a unit of work executed on behalf of a trace. Examples of
 * spans include a remote procedure call, or a in-process method call to a
 * sub-component. A trace is required to have a single, top level "root"
 * span, and zero or more children spans, which in turns can have their own
 * children spans, thus forming a tree structure.
 *
 * @package OpenTracing
 */
class Span {
	private $tracer = null;

	public function __construct( Tracer $tracer ) {
		$this->tracer = $tracer;
	}

	/**
	 * Sets or changes the operation name.
	 *
	 * @param string $operationName
	 * @return $this
	 */
	public function setOperationName( $operationName ) {
		return $this;
	}

	/**
	 * Indicates that the work represented by this span has been completed
	 * or terminated, and is ready to be sent to the Reporter.
	 *
	 * If any tags / logs need to be added to the span, it should be done
	 * before calling finish(), otherwise they may be ignored.
	 *
	 * @param int $finishTime
	 */
	public function finish( $finishTime = null ) {
		// noop
	}

	/**
	 * Attaches a key/value pair to the span.
	 *
	 * The set of supported value types is implementation specific. It is the
	 * responsibility of the actual tracing system to know how to serialize
	 * and record the values.
	 *
	 * If the user calls set_tag multiple times for the same key,
	 * the behavior of the tracer is undefined, i.e. it is implementation
	 * specific whether the tracer will retain the first value, or the last
	 * value, or pick one randomly, or even keep all of them.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return $this
	 */
	public function setTag( $key, $value ) {
		return $this;
	}

	/**
	 * Logs an event against the span, with the current timestamp.
	 *
	 * @param string $event
	 * @param array $payload
	 * @return $this
	 */
	public function logEvent( $event, $payload = null ) {
		$this->log( null, $event, $payload );

		return $this;
	}

	/**
	 * Records a generic Log event at an arbitrary timestamp.
	 *
	 * @param int $timestamp
	 * @param string $event
	 * @param array $payload
	 * @return $this
	 */
	public function log( $timestamp, $event, $payload = null ) {
		return $this;
	}

	/**
	 * Stores a Trace Attribute in the span as a key/value pair.
	 *
	 * Enables powerful distributed context propagation functionality where
	 * arbitrary application data can be carried along the full path of
	 * request execution throughout the system.
	 *
	 * Note 1: attributes are only propagated to the future (recursive)
	 * children of this Span.
	 *
	 * Note 2: attributes are sent in-band with every subsequent local and
	 * remote calls, so this feature must be used with care.
	 *
	 * Note 3: keys are case-insensitive, to allow propagation via HTTP
	 * headers. Keys must match regexp `(?i:[a-z0-9][-a-z0-9]*)`
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return $this
	 */
	public function setTraceAttribute( $key, $value ) {
		return $this;
	}

	/**
	 * Retrieves value of the Trace Attribute with the given key.
	 *
	 * Returns null if key doesn't exist.
	 *
	 * Key is case-insensitive.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function getTraceAttribute( $key ) {
		return null;
	}

	/**
	 * A shorthand method that starts a child span given a parent span.
	 *
	 * @param string $operationName
	 * @param array $tags
	 * @param int $startTime
	 * @return Span
	 */
	public function startChild( $operationName, $tags = null, $startTime = null ) {
		return $this->getTracer()->startSpan( $operationName, $this, $tags, $startTime );
	}

	/**
	 * Provides access to the Tracer that created this Span.
	 *
	 * @return Tracer
	 */
	public function getTracer() {
		return $this->tracer;
	}
}