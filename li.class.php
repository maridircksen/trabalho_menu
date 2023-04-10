<?php
include_once "autoload.php";

    class Li {
        private $value;

        function __construct($value) {
            $this->value = $value;
        }

        function __toString() {
            return "<li>{$this->value}</li>";
        }
    }