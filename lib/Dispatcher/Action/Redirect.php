<?php

class Dispatcher_Action_Redirect implements Dispatcher_Action { 

  private $destination;
  private $setparams; 
  private $opts;

  public function __construct($destination, $opts = array() ){ 
    $this->destination = $destination;
    $this->opts = $opts;
    if( !array_key_exists( 'params',$this->opts ) ) { 
      $this->opts['params'] = array();
    }
  }

  public function perform( ){ 
    $sprintfarray = array($this->destination); 
    sort( $this->opts['params'] );
    foreach ( $this->opts['params'] as $i => $v ){ 
      array_push( $sprintfarray, $this->setparams[$v]['value'] );
    }
    $uri = call_user_func_array('sprintf', $sprintfarray );
    header("Location: $uri" );
  }

  public function set_param( array $params ){
    $this->setparams = $params;
  }
}
