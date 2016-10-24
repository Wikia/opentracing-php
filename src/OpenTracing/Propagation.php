<?php

namespace OpenTracing;

/**
 * Default propagation formats that PHP tracer must support.
 */
class Propagation
{
    /**
     * The ARRAY Format represents a PHP array from string to string.
     *
     * @var string
     */
    const FORMAT_ARRAY = 'array';

    /**
     * The HTTP_HEADERS format represents the $_SERVER HTTP headers array.
     * This can include other http headers that are un
     *
     * NOTE: The HTTP_HEADERS carrier array may contain unrelated data (e.g.,
     * arbitrary gRPC metadata). As such, the Tracer implementation should use a
     * prefix or other convention to distinguish Tracer-specific key:value
     * pairs.
     */
    const FORMAT_HTTP_HEADERS = 'http_headers';
}
