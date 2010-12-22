#!/usr/bin/env php
<?php

require_once(dirname(__FILE__) . '/../../lib/Dispatcher.php' );

$t = new DevKit_Tester();

$rule = $t->new_lives( 'rule + no args ',
    'Dispatcher_Rule_Empty', array( )
);
$dispatcher = $t->new_lives( 'dispatcher + no args',
    'Dispatcher', array( )
);

$action = $t->new_lives( 'action fatal+message no args',
    'Dispatcher_Action_Fatal', array( 'Testing' )
);

$t->method_call_lives( 'set_dispatcher should work' ,
    $rule, 'set_dispatcher', array( $dispatcher )
);

$t->method_call_lives( ' set the execute action',
    $rule, 'execute', array( $action )
);


$t->is( $rule->matches(''), true, 'Empty String matches' );
$t->isnt( $rule->matches('asdasdasd'), true, 'NonEmpty string doesn\'t match');

$got_action = $t->method_call_lives( 'get action',
    $rule, 'action', array('')
);

$t->done_testing();
