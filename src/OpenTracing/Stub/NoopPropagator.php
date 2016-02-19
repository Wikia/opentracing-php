<?php

namespace OpenTracing\Stub;

use OpenTracing\Injector;
use OpenTracing\Extractor;

class NoopPropagator implements Injector, Extractor {
	private $tracer = null;
	private $noopSpan = null;

	function __construct( Tracer $tracer, Span $noopSpan ) {
		$this->tracer = $tracer;
		$this->noopSpan = $noopSpan;
	}

	function injectSpan( Span $span, $carrier ) {
		// noop
	}

	function joinTrace( $operationName, $carrier ) {
		return $this->noopSpan;
	}
}