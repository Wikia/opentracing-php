<?php

namespace OpenTracing\Basic;

use OpenTracing;

class Tracer implements OpenTracing\Tracer {

	static protected $propagators = null;

	private $recorder = null;

	public function __construct( OpenTracing\Recorder $recorder = null ) {
		$this->recorder = $recorder;
	}

	public function startSpan( $operationName = null, $parent = null, $tags = null, $startTime = null ) {
		if ( !is_null( $parent ) && !$parent instanceof Span ) {
			throw new \InvalidArgumentException( 'Unsupported Span object provided' );
		}

		$newSpanData = new SpanData();
		$newSpanData->startTime = !is_null( $startTime ) ? $startTime : microtime( true );

		if ( !$parent ) {
			$newSpanData->traceId = $this->randomId();
			$newSpanData->spanId = $newSpanData->traceId;
		} else {
			$parentSpanData = $parent->getData();
			$newSpanData->traceId = $parentSpanData->traceId;
			$newSpanData->parentSpanId = $parentSpanData->spanId;
			$newSpanData->spanId = $this->randomId();

			$newSpanData->attributes = $parentSpanData->attributes;
		}

		$newSpanData->operationName = $operationName;
		$newSpanData->startTime = is_null( $startTime ) ? microtime( true ) : $startTime;
		$newSpanData->tags = is_null( $tags ) ? [ ] : $tags;

		return new Span( $this, $newSpanData );
	}

	protected function randomId() {
		if ( function_exists( 'mcrypt_create_iv' ) ) {
			return mcrypt_create_iv( 8, MCRYPT_DEV_RANDOM );
		} else if ( function_exists( 'openssl_random_pseudo_bytes' ) ) {
			return openssl_random_pseudo_bytes( 8 );
		} else {
			$s = '';
			for ( $i = 0; $i < 8; $i++ ) {
				$s .= chr( mt_rand( 0, 256 ) );
			}

			return $s;
		}
	}

	public function injector( $format ) {
		return $this->getPropagator( $format );
	}

	public function createSpan( $traceId, $spanId, $attributes ) {
		$spanData = new SpanData();
		$spanData->traceId = $traceId;
		$spanData->spanId = $spanId;
		$spanData->startTime = microtime(true);
		$spanData->attributes = $attributes;

		return new Span($this, $spanData);
	}

	protected function getPropagator( $format ) {
		$this->initPropagators();

		if ( empty( self::$propagators[$format] ) ) {
			return null;
		}

		return self::$propagators[$format];
	}

	protected function initPropagators() {
		if ( !is_array( self::$propagators ) ) {
			self::$propagators = [
				Format::SPLIT_TEXT => new SplitTextPropagator( $this ),
				Format::SPLIT_BINARY => new SplitBinaryPropagator( $this ),
				Format::PACKED_HTTP_HEADERS => new PackedHttpHeadersPropagator( $this ),
				Format::RAW_HTTP_HEADERS => new RawHttpHeadersPropagator( $this ),
			];
		}
	}

	public function extractor( $format ) {
		return $this->getPropagator( $format );
	}

	public function flush() {

	}
}