<?php

namespace OpenTracing;

class Tag
{

    const PEER_SERVICE = "peer.service";
    const PEER_HOSTNAME = "peer.hostname";
    const PEER_HOST_IPV4 = "peer.ipv4";
    const PEER_HOST_IPV6 = "peer.ipv6";
    const PEER_PORT = "peer.port";
    const SAMPLING_PRIORITY = "sampling.priority";

    const SPAN_KIND = 'span.kind';
    const SPAN_KIND_RPC_SERVER = 's';
    const SPAN_KIND_RPC_CLIENT = 'c';

}