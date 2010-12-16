<?php

class Dispatcher_Rule_Default implements Dispatcher_Rule { 

  private $dispatcher;
  private $action;

  public function set_dispatcher( Dispatcher $d ){ 
    $this->dispatcher = $d;
  }

  public function matches( $request ){ 
    return true;
  }
  
  public function execute( $action ){ 
    $this->action = &$action;
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
