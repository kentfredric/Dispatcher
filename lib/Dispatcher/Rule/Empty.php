<?php

class Dispatcher_Rule_Empty implements Dispatcher_Rule {

  private $dispatcher;
  private $action;

  public function set_dispatcher( Dispatcher $d ){
    $this->dispatcher = $d;
  }

  public function matches( $request ){
    if( is_null( $request ) ){
      return true;
    }
    if ( empty( $request ) ){
      return true;
    }
    if ( !isset( $request ) ){
      return true;
    }
    return false;
  }
  public function execute( $action ){
    $this->action = Dispatcher_Utils::vivify_action( func_get_args() );
    return $this;
  }

  public function action( $request ){
    $action = $this->action;
    $action->set_param(array(
        'dispatcher' => array( 'value' => &$this->dispatcher ),
        'rule' => array( 'value' => &$this ),
      ));
    return $action;
  }

}
