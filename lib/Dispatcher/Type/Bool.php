<?php

class Dispatcher_Type_Bool extends Dispatcher_Type_Item {

  public function nice_name(){
    return 'Bool';
  }

  public function isa( $item ){
    if( !isset( $item ) ){
      return true;
    }
    if( is_null( $item ) ){
      return true;
    }
    if( !is_scalar( $item ) ){
      return false;
    }
    if( is_bool( $item ) ){
      return true;
    }
    if( "1" === "$item" ){
      return true;
    }
    if( "0" === "$item" ){
      return true;
    }
    if( "" === "$item" ){
      return true;
    }
  }

  public function can_coerce( Dispatcher_Type $type ){
    if( $type instanceof Dispatcher_Type_Bool ){
      return true;
    }
    return false;
  }

  public function coerce( $item ){
    if( $this->isa( $item ) ){
      if( !isset($item) || is_null( $item ) || $item === false || "$item" === "0" || "$item" === "" ){
        return false;
      }
      return true;
    }
    throw new Dispatcher_Exception_Type("Cannot coerce to Bool");
  }

}
