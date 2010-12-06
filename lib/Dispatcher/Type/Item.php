<?php

class Dispatcher_Type_Item implements Dispatcher_Type { 

  public function nice_name(){ 
    return 'Item';
  }

  public function isa( $item ){
    return true;
  }

  public function can_coerce( Dispatcher_Type $type ){ 
    return false;
  }

  public function coerce( $item ){ 
    throw new Dispatcher_Exception_Type("Cannot coerce to Item");
  }

}
