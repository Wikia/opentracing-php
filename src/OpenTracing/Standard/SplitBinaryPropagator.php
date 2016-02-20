<?php

namespace OpenTracing\Standard;

use OpenTracing;

class SplitBinaryPropagator extends Propagator {

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
		if ( !$carrier || !is_array( $carrier ) || empty( $carrier[self::FIELD_STATE] ) || empty( $carrier[self::FIELD_ATTRIBUTES] ) ) {
			throw new \InvalidArgumentException( 'Carrier does not contain valid tracer data' );
		}

		$state = $carrier[self::FIELD_STATE];
		if ( strlen( $state ) != 16 ) {
			throw new \InvalidArgumentException( 'Carrier does not contain valid tracer data' );
		}
		$traceId = substr( $state, 0, 8 );
		$spanId = substr( $state, 8, 8 );

		$attributes = $carrier[self::FIELD_ATTRIBUTES];
		$attributes = $this->decodeArray( $attributes );

		return $this->tracer->createSpan( $traceId, $spanId, $attributes );
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
	public function injectSpan( OpenTracing\Span $span, &$carrier ) {
		$this->validateSpan( $span );

		$spanData = $span->getData();
		$state = $this->formatId( $spanData->traceId ) . $this->formatId( $spanData->spanId );
		$attributes = $this->encodeArray( $spanData->attributes );

		$carrier[self::FIELD_STATE] = $state;
		$carrier[self::FIELD_ATTRIBUTES] = $attributes;
	}

	private function formatId( $id ) {
		if ( !is_string( $id ) || strlen( $id ) != 8 ) {
			return str_repeat( chr( 0 ), 8 );
		}

		return $id;
	}

	private function encodeArray( array $data ) {
		$s = [ ];
		$s[] = pack( 'N', count( $data ) );
		foreach ( $data as $k => $v ) {
			$k = (string)$k;
			$v = (string)$v;
			$s[] = pack( 'N', strlen( $k ) );
			$s[] = $k;
			$s[] = pack( 'N', strlen( $v ) );
			$s[] = $v;
		}

		return implode( '', $s );
	}

	private function decodeArray( $bytes ) {
		$len = strlen( $bytes );
		$pos = 0;
		$count = $this->readInt32( $bytes, $len, $pos );
		$data = [ ];
		for ( $i = 0; $i < $count; $i++ ) {
			$k = $this->readString( $bytes, $len, $pos );
			$v = $this->readString( $bytes, $len, $pos );
			$data[$k] = $v;
		}

		if ( $pos != $len ) {
			throw new \InvalidArgumentException( 'Trailing bytes found when decoding array' );
		}

		return $data;
	}

	private function readString( $bytes, $len, &$pos ) {
		$count = $this->readInt32( $bytes, $len, $pos );

		return $this->readBytes( $bytes, $len, $count, $pos );
	}

	private function readInt32( $bytes, $len, &$pos ) {
		return unpack( 'N', $this->readBytes( $bytes, $len, 4, $pos ) );
	}

	private function readBytes( $bytes, $len, $count, &$pos ) {
		if ( $pos + $count > $len ) {
			throw new \InvalidArgumentException( sprintf( 'Could not read %d bytes from byte stream', $count ) );
		}

		$val = substr( $bytes, $pos, $count );
		$pos += $count;

		return $val;
	}

}