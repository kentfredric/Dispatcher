<?php

  require_once(realpath(dirname(__FILE__)). '/../extlib/DevKit/lib/DevKit/Autoload.php' );
  DevKit_Autoload::setprefix('Dispatcher', realpath(dirname(__FILE__)) . '/Dispatcher' );
  DevKit_Autoload::setprefix('Dispatch', realpath(dirname(__FILE__)) . '/Dispatch' );

  class Dispatcher {

    private $rules;

    public function __construct(){
      $args = func_get_args();
      $this->rules = array();

      if( count($args) < 1 ){
        throw new Dispatcher_Exception_Construction("Need to pass one or more parameters to constructor for dispatcher");
      }
      foreach ( $args as $i => &$v ){ 
        if( !is_object( $v ) ){ 
          throw new Dispatcher_Exception_Construction("Got something that is not an object for argument $i");
        }
        if( !( $v instanceof Dispatcher_Rule ) ){
          throw new Dispatcher_Exception_Construction("Got something that is not a Dispatcher_Rule for argument $i");
        }
        $this->add_rule( $v );
      }
      return $this;
    }

    public function add_rule( Dispatcher_Rule &$rule ){
      $rule->set_dispatcher( $this );
      array_push( $this->rules, $rule );
      return $this;
    }

    public function get_action_for( $request = '' ){
      foreach( $this->rules as $i => &$v ){ 
        if (  $v->matches( $request ) ){
          $result = $v->action( $request );
          if( !( $result instanceof Dispatcher_Action ) ){ 
            throw new Dispatcher_Exception_Dispatch("Returned from Dispatcher_Rule->action() was not a Dispatcher_Action");
          }
          return $result;
        }
      }
      throw new Dispatcher_Exception_Dispatch("No dispatch rule matched the request. Did you specify a default?");
    }

  }
