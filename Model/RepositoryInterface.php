<?php

namespace Model;

interface RepositoryInterface {
    function get(...$p);
    function post(...$p);
    function delete(...$p);
    function put(...$p);
}