<?php

namespace Controller;

interface ControllerInterface {
    function action();
    function httpResponse($message);
}