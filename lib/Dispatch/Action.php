<?php

class Dispatch_Action { 
  public static function fatal( $message = '' ){ 
    return new Dispatcher_Action_Fatal($message);
  }

  public static function redirect( $to, $opts = array() ){ 
    return new Dispatcher_Action_Redirect( $to , $opts );
  }

  public static function subdispatch() {
    return self::fatal("not implemented");
  }
}
