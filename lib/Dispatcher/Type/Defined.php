<?php

class Dispatcher_Type_Defined extends Dispatcher_Type_Item {

  public function nice_name(){
    return 'Defined';
  }

  public function isa( $item ){
    if( Dispatch_Type::Undef()->isa( $item ) ){
      return false;
    }
    return true;
  }

  public function can_coerce( Dispatcher_Type $type ){
    return false;
  }

  public function coerce( $item ){
    throw new Dispatcher_Exception_Type("Cannot coerce to " . $this->nice_name);
  }

}
