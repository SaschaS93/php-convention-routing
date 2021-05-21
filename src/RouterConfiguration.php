<?php

namespace SaschaS93\ConventionRouting;

class RouterConfiguration {

    private string $mainPageLocation = "";

    private string $controllerNamespace = "";

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }
}
