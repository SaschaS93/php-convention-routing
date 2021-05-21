<?php

namespace SaschaS93\ConventionRouting;

class Request {

    private string $method;

    private string $uri;

    private string $body;

    public function __construct(
        string $method,
        string $uri,
        string $body
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->body = $body;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getUri(): string {
        return $this->uri;
    }

    public function getBody(): string {
        return $this->body;
    }

}