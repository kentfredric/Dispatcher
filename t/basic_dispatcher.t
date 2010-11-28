#!/usr/bin/env php
<?php

require_once(dirname(__FILE__) . '/../lib/Dispatcher.php' );

$t = new DevKit_Tester();

$dispatcher = new Dispatcher(
    Dispatch::isempty()->execute( Dispatch_Action::fatal("Empty Request") ),
    Dispatch::isdefault()->execute( Dispatch_Action::fatal("Default") )
);

#$action = $dispatcher->get_action_for(null);
$action = $dispatcher->get_action_for(" hello");
$action->perform();
