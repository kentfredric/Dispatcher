#!/usr/bin/env php
<?php

require_once(dirname(__FILE__) . '/../lib/Dispatcher.php' );

$t = new DevKit_Tester();

try {
    $dispatcher = new Dispatcher();
    $t->fail("Dispatcher is supposed to throw an exception with 0 args");
} catch ( Dispatcher_Exception_Construction $e ){
    $t->pass("Dispatcher is supposed to throw an exception with 0 args");
    $t->like($e->getMessage(),
        '/Need to pass one or more/',
        'Right error for missing args'
    );
} catch ( Exception $e ){
    $t->fail("Not the exception we were looking for $e");
}

try {
    $dispatcher = new Dispatcher('Hello');
    $t->fail("Dispatcher is supposed to throw an exception with non-objects");
} catch ( Dispatcher_Exception_Construction $e ){
    $t->pass("Dispatcher is supposed to throw an exception with non-objects");
    $t->like($e->getMessage(),
        '/Got something that is not an object/',
        'Right error for bnon-objects'
    );
} catch ( Exception $e ){
    $t->fail("Not the exception we were looking for $e");
}


$t->done_testing();
