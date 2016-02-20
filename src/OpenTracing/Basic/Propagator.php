<?php

namespace OpenTracing\Basic;

use OpenTracing;
use OpenTracing\Extractor;
use OpenTracing\Injector;

abstract class Propagator implements Injector, Extractor {

	const FIELD_STATE = 'state';
	const FIELD_ATTRIBUTES = 'attributes';
	const FIELD_TRACE_ID = 'traceid';
	const FIELD_SPAN_ID = 'spanid';

	protected $tracer = null;

	public function __construct( Tracer $tracer ) {
		$this->tracer = $tracer;
	}

	protected function validateSpan( OpenTracing\Span $span ) {
		if ( !$span instanceof Span ) {
			throw new \InvalidArgumentException( 'Unsupported Span object provided' );
		}
	}
}