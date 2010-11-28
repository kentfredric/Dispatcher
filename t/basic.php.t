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
        'Right error for non-objects'
    );
} catch ( Exception $e ){
    $t->fail("Not the exception we were looking for $e");
}

class TEST_MyFakeClass { }

try {
    $dispatcher = new Dispatcher( new TEST_MyFakeClass() );
    $t->fail("Dispatcher is supposed to throw an exception with wrong classes");
} catch ( Dispatcher_Exception_Construction $e ){
    $t->pass("Dispatcher is supposed to throw an exception with wrong classes");
    $t->like($e->getMessage(),
        '/Got something that is not a Dispatcher_Rule/',
        'Right error for non-rules'
    );
} catch ( Exception $e ){
    $t->fail("Not the exception we were looking for $e");
}

class TEST_MyFakeClass_B implements Dispatcher_Rule { }

try {
    $dispatcher = new Dispatcher( new TEST_MyFakeClass_B() );
    $t->pass("Dispatcher is supposed to not fail");
} catch ( Exception $e ){
    $t->fail("Dispatcher is supposed to not fail");
}

$t->done_testing();
