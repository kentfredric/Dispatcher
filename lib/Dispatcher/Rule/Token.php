<?php

class Dispatcher_Rule_Token implements Dispatcher_Rule { 

  private $dispatcher;
  private $action;

  public function set_dispatcher( Dispatcher $d ){
    $this->dispatcher = $d;
  }

  public function tokens( $request ){ 
    $bits = explode('/', $url );
    return $bits;
  }

  public function token_n( $request , $token  ){ 
    return array_slice( $this->tokens( $request, 
  }

  public function matches( $request ){ 

  }

  public function execute( $action ){ 
    $this->action = Dispatcher_Utils::vivify_action( func_get_args() );
    return $this;
  }

  public function action( $request ){
    $action = $this->action; 
    $action->set_param( array( 
        'cleanurl' => array( 'value'=> $this->cleanurl( $request ) ),
        'dispatcher' => array( 'value' => &$this->dispatcher ),
        'rule' => array( 'value' => &$this ),
    )); 
  }

}
