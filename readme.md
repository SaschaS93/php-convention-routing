# PHP convention routing

Route http requests easily and fast by name convention, just with code.
This library originates from a non-public development tool. It is not ready for public production use yet.

## Installation

Add the library with the following lines to your composer.json

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/SaschaS93/php-convention-routing"
    }
],
"require": {
    "monolog/monolog": "dev-master"
}
```

Don't forget to run composer install after modifying the composer.json

## Usage

You can find a complete example in the example/ folder. Execute the run.sh to run the example with the PHP integrated webserver.

The index.php from the example consists of the following relevant parts:

### Configuration

At the beginning you have to configure the routing.

The **mainPageLocation** specifies where to route when no path in the url is specified.

With **controllerNamespace** you define the prefix of the namespace in which the controller is searched for. Note that the name of the controller must always end with "Controller".

```php
$configuration = new RouterConfiguration();
$configuration->mainPageLocation = "ui/Index"; // Redirect to this location when no path was given
$configuration->controllerNamespace = "SaschaS93\\ConventionRoutingExample\\Controller\\"; // Namespace to search controller
```

### Start the routing

The routing starts with the following lines after the configuration

```php
$router = new Router($configuration);
$router->route();
```

### Routing

Now we're ready to use the routing by simply creating a method like the following in the controller (see example/src/Controller/UiController.php):

```php
public function putSomething(Request $request): Response {
    $response = array(
        "message"   => "I got something!",
        "body"      => json_decode($request->getBody())
    );
    return new Response($response, 200, ContentType::$APPLICATION_JSON);
}
```

This method is callable with a PUT request on the /ui/something path. The request body is delivered by the $request->getBody() method.

GET Parameters works as follows:

```php
public function getIndex(Request $request, string $name = ''): Response {
    return new Response('Hello! '.$name, 200, ContentType::$TEXT_HTML_UTF_8);
}
```

The url will look like the following: http://127.0.0.1:8000/index.php/ui/index/Your+Name

"Index" is used by default, when no method name is defined: http://127.0.0.1:8000/index.php/ui