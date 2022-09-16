<?php

add_action('rest_api_init', function () {
    $namespace = 'myplugin/v1';
    $rout = '/example-test/(?P<id>\d+)';
    $rout_params = [
        'methods'  => 'GET',
        'callback' => 'my_func',
    ];
    register_rest_route($namespace, $rout, $rout_params);
});

function my_func($request)
{
    return $request['id'];
}
