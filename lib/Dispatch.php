<?php

class Dispatch { 

    public static function isempty(){ 
      return new Dispatcher_Rule_Empty();
    }

    public static function malformed(){
      return new Dispatcher_Rule_Malformed();
    }

    public static function ondisk(){
      return new Dispatcher_Rule_OnDisk();
    }
    public static function token( $tokeno, Dispatch_Matcher $matcher ){
      return new Dispatcher_Rule_Token( $tokeno, $matcher );
    }
    public static function isdefault( ){
      return new Dispatcher_Rule_Default();
    }
}
