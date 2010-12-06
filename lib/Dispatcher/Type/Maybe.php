<?php

class Dispatcher_Type_Maybe extends Dispatcher_Type_Item { 

  private $maybetype;

  public function __construct( Dispatcher_Type $maybetype ){ 
    $this->maybetype = $maybetype;
  }

  public function nice_name(){ 
    return 'Maybe[' . $this->maybetype->nice_name() . ']';
  }

  public function isa( $item ){
    if( Dispatch_Type::Undef()->isa( $item ) ){
      return true;
    }
    return $this->maybetype->isa( $item );
  }

  public function can_coerce( Dispatcher_Type $type ){ 
    return false;
  }

  public function coerce( $item ){ 
    throw new Dispatcher_Exception_Type("Cannot coerce to " . $this->nice_name);
  }

}
