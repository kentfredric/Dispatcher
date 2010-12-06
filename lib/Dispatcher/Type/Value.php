<?php

class Dispatcher_Type_Value extends Dispatcher_Type_Defined { 

  public function nice_name(){ 
    return 'Value';
  }

  public function isa( $item ){
    if( ! parent::isa( $item ) ){
      return false;
    }
    if( is_scalar( $item ) ){ 
      return true;
    }
    return false;
  }

  public function can_coerce( Dispatcher_Type $type ){ 
    return false;
  }

  public function coerce( $item ){ 
    throw new Dispatcher_Exception_Type("Cannot coerce to " . $this->nice_name);
  }

}
