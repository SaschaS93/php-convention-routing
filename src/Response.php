<?php

namespace SaschaS93\ConventionRouting;

class Response {

    private $content;

    private int $httpcode;

    private string $contenttype;

    public function __construct(
        $content,
        int $httpcode = 200,
        string $contenttype = null
    ) {
        if ($contenttype == null) $contenttype = ContentType::$TEXT_HTML_UTF_8;
        $this->content = $content;
        $this->httpcode = $httpcode;
        $this->contenttype = $contenttype;
    }

    public function getContent() {
        return $this->content;
    }

    public function getHttpcode(): int {
        return $this->httpcode;
    }

    public function getContenttype(): string {
        return $this->contenttype;
    }

}