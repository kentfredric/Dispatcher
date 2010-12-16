<?php

class Dispatcher_Action_Debug implements Dispatcher_Action {

  private $message;

  public function __construct(){
    $args = func_get_args();
    $this->constructor_args = $args;
  }

  public function perform( ){
    $args = func_get_args();
    $this->perform_args = $args;
    header("Content-Type: text/plain");
    print_r( $this );
    die();
  }

  public function set_param( array $params ){
    $args = func_get_args();
    $this->set_param_args = $args;
  }
}
