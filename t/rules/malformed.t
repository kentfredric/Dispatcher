#!/usr/bin/env php
<?php

require_once(dirname(__FILE__) . '/../../lib/Dispatcher.php' );

$t = new DevKit_Tester();

$rule = $t->new_lives( 'rule + no args ',
    'Dispatcher_Rule_Malformed', array( )
);
$dispatcher = $t->new_lives( 'dispatcher + no args',
    'Dispatcher', array( )
);

$action = $t->new_lives( 'action debug+message no args',
    'Dispatcher_Action_Debug', array( 'Testing' )
);

$t->method_call_lives( 'set_dispatcher should work' ,
    $rule, 'set_dispatcher', array( $dispatcher )
);

$t->method_call_lives( ' set the execute action',
    $rule, 'execute', array( $action )
);


$t->is( $rule->matches('/.'), true, 'dirty single . matches' );
$t->is( $rule->matches('/foo/'), true, 'trailing / matches' );
$t->is( $rule->matches('/..'), true, 'dirty .. matches' );
$t->is( $rule->matches('/foo//bar'), true, 'empty token (//) matches' );

$got_action = $t->method_call_lives( 'get action',
    $rule, 'action', array('/.')
);
$t->is(get_class($got_action), 'Dispatcher_Action_Debug', 'Got the right action back');
$t->is($got_action->set_param_arg['cleanurl'][0]['value'], '/' , 'got expected cleanup');

$got_action = $t->method_call_lives( 'get action',
    $rule, 'action', array('/foo/')
);
$t->is(get_class($got_action), 'Dispatcher_Action_Debug', 'Got the right action back');
$t->is($got_action->set_param_arg['cleanurl'][0]['value'], '/foo' , 'got expected cleanup');

$got_action = $t->method_call_lives( 'get action',
    $rule, 'action', array('/..')
);
$t->is(get_class($got_action), 'Dispatcher_Action_Debug', 'Got the right action back');
$t->is($got_action->set_param_arg['cleanurl'][0]['value'], '/' , 'got expected cleanup');

$got_action = $t->method_call_lives( 'get action',
    $rule, 'action', array('/foo//bar')
);
$t->is(get_class($got_action), 'Dispatcher_Action_Debug', 'Got the right action back');
$t->is($got_action->set_param_arg['cleanurl'][0]['value'], '/foo/bar' , 'got expected cleanup');

$t->isnt( $rule->matches('/'), true, 'clean urls dont hit (/)' );
$t->isnt( $rule->matches('/foo'), true, 'clean urls dont hit (/foo)' );
$t->isnt( $rule->matches('/bar/foo'), true, 'clean urls dont hit (/bar/foo)' );
$t->isnt( $rule->matches('/bar/foo/...'), true, 'clean urls dont hit (/bar/foo/....)' );




$t->done_testing();
