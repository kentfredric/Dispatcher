<?php

class Dispatcher_Type_Scalar implements Dispatcher_Type { 

  public function nice_name(){ 
    return 'Scalar';
  }

  public function isa( $item ){
    if( !is_scalar( $item ) ){ 
      return false;
    }
    return true;
  }

  public function can_coerce( Dispatcher_Type $type ){ 
    return false;
  }

  public function coerce( $item ){ 
    throw new Dispatcher_Exception_Type("Cannot coerce to scalar (yet)");
  }

}
