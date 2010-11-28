<?php

class Dispatch_Action { 
  public static function fatal( $message = '' ){ 
    return new Dispatcher_Action_Fatal($message);
  }
}
