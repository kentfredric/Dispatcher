#!/usr/bin/env php
<?php

require_once(dirname(__FILE__) . '/../lib/Dispatcher.php' );

$t = new DevKit_Tester();

try {
    $dispatcher = new Dispatcher();
    $t->pass("Dispatcher is NOT supposed to throw an exception with 0 args");
} catch ( Exception $e ){
    $t->fail("Dispatcher is NOT supposed to throw an exception with 0 args");
    $t->diag_exception( $e );
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
    $t->fail("Not the exception we were looking for.");
    $t->diag_exception( $e );
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
    $t->fail("Not the exception we were looking for.");
    $t->diag_exception( $e );
}

class TEST_MyFakeClass_B implements Dispatcher_Rule {
    private $dispatcher;
    public function set_dispatcher( Dispatcher $d ){
        $this->dispatcher = &$d;
    }
    public function matches( $string ){
        return  false;
    }
    public function action( $string ){
        return false;
    }
}

class TEST_Action implements Dispatcher_Action {
    public function perform(){
        global $stuff;
        $stuff = 1;
    }
    public function set_param( $name, array $paramdata ){

    }
}

class TEST_MyFakeClass_C implements Dispatcher_Rule {
    private $dispatcher;
    public function set_dispatcher( Dispatcher $d ){
        $this->dispatcher = &$d;
    }
    public function matches( $string ){
        return true;
    }
    public function action( $string ){
        return new TEST_Action();
    }
}
try {
    $dispatcher = new Dispatcher( new TEST_MyFakeClass_B() );
    $t->pass("Dispatcher is supposed to not fail");
} catch ( Exception $e ){
    $t->fail("Dispatcher is supposed to not fail");
    $t->diag_exception( $e );
}

try {
    $dispatcher = new Dispatcher( new TEST_MyFakeClass_B() );
    $dispatcher->add_rule( new TEST_MyFakeClass_B() );
    $dispatcher->get_action_for('');
    $t->fail("Dispatcher is supposed to throw an exception with missing dispatch");

} catch ( Dispatcher_Exception_Dispatch $e ){
    $t->pass("Dispatcher is supposed to throw an exception with missing dispatch");
    $t->like($e->getMessage(),
        '/No dispatch rule matched/',
        'Right error for failure'
    );
} catch( Exception $e ){
    $t->fail("Not the exception we were looking for.");
    $t->diag_exception( $e );
}


try {
    $dispatcher = new Dispatcher( new TEST_MyFakeClass_B() );
    $dispatcher->add_rule( new TEST_MyFakeClass_B() );
    $dispatcher->add_rule( new TEST_MyFakeClass_C() );

    $dispatcher->get_action_for('');
    $t->pass("Dispatcher not is supposed to throw an exception with a dispatch match");

} catch ( Exception $e ){
    $t->fail("Dispatcher not is supposed to throw an exception with a dispatch match");
    $t->diag_exception( $e );
}


$t->done_testing();
