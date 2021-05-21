<?php

namespace SaschaS93\ConventionRoutingExample\Controller;

use SaschaS93\ConventionRouting\Request;
use SaschaS93\ConventionRouting\Response;
use SaschaS93\ConventionRouting\ContentType;

class UiController {

    public function getIndex(Request $request, string $name = ''): Response {
        return new Response('Hello! '.$name, 200, ContentType::$TEXT_HTML_UTF_8);
    }

    public function putSomething(Request $request): Response {
        $response = array(
            "message"   => "I got something!",
            "body"      => json_decode($request->getBody())
        );
        return new Response($response, 200, ContentType::$APPLICATION_JSON);
    }

}