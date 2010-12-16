<?php

  class Dispatcher_Utils {

    public static function vivify_prefix( $prefix, $fgetargs ){
      $first = array_shift( $fgetargs );
      if( is_object( $first ) ){
        return $first;
      }
      $fullname = $prefix . $first;
      if( ! class_exists( $fullname , 1 ) ){
         die("Cant vivify $fullname , class does not exist");
      }

      $reflector = new ReflectionClass( $fullname );

      if( $constructor = $reflector->getConstructor() ){
        return $reflector->newInstanceArgs( $fgetargs );
      }

      if( count( $fgetargs ) > 0 ){
        die("Constructor to $fullname can't take arguements");
      }

      return $reflector->newInstance();

    }
    public static function vivify_action( array $fgetargs ){
      return self::vivify_prefix( 'Dispatcher_Action_', $fgetargs );
    }

    public static function vivify_rule( array $fgetargs ){
      return self::vivify_prefix( 'Dispatcher_Rule_', $fgetargs );
    }

  }
