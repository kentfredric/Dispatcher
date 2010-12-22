<?php

class Dispatcher_Action_Fatal implements Dispatcher_Action {

  private $message;

  public function __construct($message){
    $this->message = $message;
  }

  public function perform( ){
    die($this->message);
  }

  public function set_param( $name, array $params ){

  }
}
