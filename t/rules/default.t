#!/usr/bin/env php
<?php

require_once(dirname(__FILE__) . '/../../lib/Dispatcher.php' );

$t = new DevKit_Tester();

$rule = $t->new_lives( 'rule + no args ',
    'Dispatcher_Rule_Default', array( )
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


$t->is( $rule->matches('asded'), true, 'Empty String matches' );
$t->is( $rule->matches('asdasdasd'), true, 'NonEmpty string matches');

$got_action = $t->method_call_lives( 'get action',
    $rule, 'action', array('')
);

$t->is(get_class($got_action), 'Dispatcher_Action_Fatal', 'Got the right action back');
$t->done_testing();
