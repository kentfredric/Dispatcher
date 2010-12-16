<?php

class Dispatch_Type {

  public static function Undef(){
    return new Dispatcher_Type_Undef();
  }
  public static function Maybe( $maybetype ){
    $maybe = null;

    if( is_scalar($maybetype) ){
      $maybe = $this->$maybetype();
    } elseif ( is_object( $maybetype ) && ( $maybetype instanceof Dispatcher_Type ) ){
      $maybe = $maybetype;
    } else {
      throw new Dispatcher_Exception_Type("Weird paramater $maybetype to Dispatch_Type::Maybe( )");
    }
    return new Dispatcher_Type_Maybe( $maybe );
  }
  public static function Str( ){
    return new Dispatcher_Type_Str();
  }
  public static function Item(){
    return new Dispatcher_Type_Item();
  }
  public static function Any(){
    return new Dispatcher_Type_Any();
  }
  public static function Bool(){
    return new Dispatcher_Type_Bool();
  }
  public static function Defined(){
    return new Dispatcher_Type_Defined();
  }
}
