<?php

class Dispatcher_Rule_Empty extends Dispatcher_Rule_Base_Basic {

  public function matches( $request ){
    if( is_null( $request ) ){
      return true;
    }
    if ( empty( $request ) ){
      return true;
    }
    if ( !isset( $request ) ){
      return true;
    }
    return false;
  }

}
