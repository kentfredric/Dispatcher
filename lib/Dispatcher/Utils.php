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
  public static function vivify_exception( array $fgetargs ){ 
    return self::vivify_prefix('Dispatcher_Exception_', $fgetargs );
  }


  public static function extract_param( array $parammap, array $spec ){ 
    $paramname = $spec['name'];
    $required  = $spec['required'];
    $default = null; #  = $spec['default'];
    $param   = null; #
    $has_default = array_key_exists( 'default',$spec );
    if( $has_default ){ 
      $default = $spec['default'];
    }
    $has_param   = array_key_exists( $paramname, $parammap );
    if( $has_param ){ 
      $param = $parammap[$paramname];
    }

    if( $required && !$has_param) { 
      Dispatch::Exception('Parameters_Required', 'required parameter ' . $paramname . ' was not found' );
    }
    if( !$has_param  && $has_default ){ 
      return $default;
    }
    if( !$has_param && !$has_default ){ 
      return null;
    }  
    return $param;
  }

}
