#!/usr/bin/env php
<?php

require_once(dirname(__FILE__) . '/../../lib/Dispatcher.php' );

$docroot = dirname(__FILE__) . '/../../t/tlib/ondisk_document_root/';

$t = new DevKit_Tester();
DevKit_ErrorHandler::setup();

$rule = $t->new_dies( 'rule + no args ',
    'Dispatcher_Rule_OnDisk', array( )
);

$rule = $t->new_dies( 'rule + wrong args ',
    'Dispatcher_Rule_OnDisk', array( array( 'root' => 1 ) )
);

$rule = $t->new_lives( 'rule + onearg ',
    'Dispatcher_Rule_OnDisk', array( array( 'document_root' => $docroot ) )
);



$dispatcher = $t->new_lives( 'dispatcher + no args',
    'Dispatcher', array()
);

$action = $t->new_lives( 'action fatal+message no args',
    'Dispatcher_Action_Debug', array( )
);

$t->method_call_lives( 'set_dispatcher should work' ,
    $rule, 'set_dispatcher', array( $dispatcher )
);

$t->method_call_lives( ' set the execute action',
    $rule, 'execute', array( $action )
);


$t->isnt( $rule->matches('/'), true, '/ is not a file' );
$t->is( $rule->matches('/afile'), true, '/afile is a file');
$t->isnt( $rule->matches('/adir'), true, '/adir is not a file');
$t->is( $rule->matches('/adir/bfile'), true, '/adir/bfile is a file');

$got_action = $t->method_call_lives( 'get action',
    $rule, 'action', array('/adir/bfile')
);

$t->is(get_class($got_action), 'Dispatcher_Action_Debug', 'Got the right action back');
$t->is(realpath($got_action->set_param_arg['fullpath'][0]['value']), realpath($docroot . 'adir/bfile'),
        'file path is right');
$t->done_testing();
