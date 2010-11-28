<?php

class Dispatcher_Rule_Empty implements Dispatcher_Rule { 

  private $dispatcher;
  private $action;

  public function set_dispatcher( Dispatcher &$d ){ 
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
    $this->action = &$action;
    return $this;
  }

  public function action( $request ){ 
    return $this->action;
  }

}
