<?php

namespace SaschaS93\ConventionRouting;

use Exception;

class Router {

    private RouterConfiguration $configuration;

    public function __construct(RouterConfiguration $configuration) {
        $this->configuration = $configuration;
    }

    public function route(): void {
        $request = new Request(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
            file_get_contents("php://input")
        );

        $args = explode('/', substr($request->getUri(), 1));

        // Cleanup args
        if ($args[0] == 'index.php') array_shift($args);

        // Redirect to main page if no argument is set.
        if (sizeof($args) <= 0 || $args[0] == '') {
            header('Location: '.$this->configuration->mainPageLocation);
            return;
        }

        // Use "index" as default method
        if (sizeof($args) < 2 || $args[1] == '') {
            $args[1] = 'Index';
        }

        $controllerClass = $this->configuration->controllerNamespace.ucfirst($args[0]).'Controller';

        $controllerMethod = strtolower(ucfirst($request->getMethod())).$args[1];

        // Remove controller name
        array_shift($args);

        // Remove method name
        array_shift($args);

        foreach($args as &$arg) {
            $arg = urldecode($arg);
        }

        $response = null;

        try {
            if (!class_exists($controllerClass)) throw new Exception('Controller class "'.$controllerClass.'" not found!');
            $controller = new $controllerClass();
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), 404);
            self::sendResponse($response);
            return;
        }
        
        try {
            if (!method_exists($controller, $controllerMethod)) throw new Exception('Method "'.$controllerMethod.'" in class "'.$controllerClass.'" not found!');
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), 404);
        }

        // Set request as first argument
        array_unshift($args, $request);

        try {
            $reflectionMethod = new \ReflectionMethod($controllerClass, $controllerMethod);

            if ($reflectionMethod->getNumberOfRequiredParameters() > sizeof($args))  throw new Exception('Numbers of parameters for function "'.$controllerMethod.'" in class "'.$controllerClass.'" not met!');

            $response = call_user_func_array(array($controller, $controllerMethod), $args);
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), 500);
            self::sendResponse($response);
            return;
        }

        self::sendResponse($response);
    }

    private static function sendResponse(Response $response): void {
        http_response_code($response->getHttpcode());

        header('Content-Type: '.$response->getContenttype());

        $responseContent = self::prepareResponseContent($response);

        echo $responseContent;
    }

    private static function prepareResponseContent(Response $response): ?string {
        $responseContent = $response->getContent();
        if ($response->getContenttype() == ContentType::$APPLICATION_JSON) {
            // Check if responseContent is json. If not then create a json from it
            if (is_string($responseContent)) {
                $json = json_decode($responseContent);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $responseContent = json_encode($responseContent);
                }
            } else {
                $responseContent = json_encode($responseContent);
            }
        }
        return $responseContent;
    }

}