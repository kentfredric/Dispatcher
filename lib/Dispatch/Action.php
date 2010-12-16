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
  public static function debug(){ 
    $args = func_get_args();
    $reflector = new ReflectionClass ('Dispatcher_Action_Debug'); 
    return $reflector->newInstanceArgs( $args );
  }
  public static function staticfile( array $config ){ 
    return new Dispatcher_Action_StaticFile( $config );
  }
  public static function simpledirlisting( array $config ){ 
    return new Dispatcher_Action_SimpleDirListing( $config );
  }
}
