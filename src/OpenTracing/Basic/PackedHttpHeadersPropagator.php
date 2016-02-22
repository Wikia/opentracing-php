<?php

namespace OpenTracing\Basic;

use OpenTracing;

class PackedHttpHeadersPropagator extends Propagator
{

    const HTTP_HEADER_STATE_LOWER = 'opentracing-state';
    const HTTP_HEADER_ATTRIBUTES_LOWER = 'opentracing-attributes';

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
    public function joinTrace($operationName, &$carrier)
    {
        $binaryCarrier = [];
        foreach ($carrier as $k => $v) {
            $k = strtolower($k);
            switch ($k) {
                case self::HTTP_HEADER_STATE_LOWER:
                    $binaryCarrier[self::FIELD_STATE] = base64_decode($v);
                    break;
                case self::HTTP_HEADER_ATTRIBUTES_LOWER:
                    $binaryCarrier[self::FIELD_ATTRIBUTES] = base64_decode($v);
                    break;
            }
        }

        return (new SplitBinaryPropagator($this->tracer))->joinTrace($operationName, $binaryCarrier);
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
    public function injectSpan(OpenTracing\Span $span, &$carrier)
    {
        $this->validateSpan($span);

        $binaryCarrier = [];
        (new SplitBinaryPropagator($this->tracer))->injectSpan($span, $binaryCarrier);

        $carrier[self::HTTP_HEADER_STATE_LOWER] = base64_encode($binaryCarrier[self::FIELD_STATE]);
        $carrier[self::HTTP_HEADER_ATTRIBUTES_LOWER] = base64_encode($binaryCarrier[self::FIELD_ATTRIBUTES]);
    }
}