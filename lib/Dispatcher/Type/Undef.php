<?php

class Dispatcher_Type_Undef extends Dispatcher_Type_Item { 

  public function nice_name(){ 
    return 'Undef';
  }

  public function isa( $item ){
    if( !isset( $item ) ){ 
      return true;
    }
    if( is_null( $item ) ){ 
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
