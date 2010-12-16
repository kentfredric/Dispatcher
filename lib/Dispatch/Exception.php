<?php

class Dispatch_Exception {
  public static function construction($message){
    throw new Dispatcher_Exception_Construction( $message );
  }
  public static function dispatch( $message ){
    throw new Dispatcher_Exception_Dispatch( $message );
  }
  public static function subdispatch( $message ){
    throw new Dispatcher_Exception_SubDispatch( $message );
  }
}
