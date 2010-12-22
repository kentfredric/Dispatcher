<?php

abstract class Dispatcher_Rule_Base_Basic implements Dispatcher_Rule {

  public $dispatcher;
  public $action;

  public function set_dispatcher( Dispatcher $d ){
    $this->dispatcher = $d;
  }

  public function execute( $action ){ 
    $this->action = Dispatcher_Utils::vivify_action(func_get_args());
    return $this;
  }

  public function action( $request ){ 
    $action = $this->action;
    if( !isset( $this->action ) ){ 
      Dispatch::Exception('Dispatch', 'Cannot get action for ' . get_class($this) . ', no action specified in advance, did you remember to call ->execute( $action ) ?');
    }
    $action->set_param('rule_class', array( 'value' => get_class( $this )  ) );
    $action->set_param('request' , array( 'value' => $request ) );
    $action->set_param( 'dispatcher' , array( 'value' => &$this->dispatcher ));
    $action->set_param( 'rule', array( 'value' => $this ) );
    return $action;
  }

}
