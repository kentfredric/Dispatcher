<?php

class Dispatcher_Type_Internal implements Dispatcher_Type {

  public function nice_name(){
    return '_internal';
  }

  public function can_coerce( Dispatcher_Type $type ){
    return false;
  }

  public function coerce( $item ){
    throw new Dispatcher_Exception_Type("Cannot coerce (anything) to _internal");
  }
  public function isa( $item ){
    return false;
  }
}
