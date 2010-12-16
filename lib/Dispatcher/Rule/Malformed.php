<?php

  class Dispatcher_Rule_Malformed implements Dispatcher_Rule {

    private $dispatcher;
    private $action;

    public function set_dispatcher( Dispatcher $d ){
      $this->dispatcher = $d;
    }

    public function cleanurl( $url ){
      $bits = explode('/', $url );
      $newbits = array();
      foreach( $bits as $i => $v ){
        if( empty( $v ) ){
          continue;
        }
        if( $v === '.' ){
          continue;
        }
        if( $v === '..' ){
          array_pop( $newbits );
          continue;
        }
        array_push( $newbits, $v );
      }
      return '/' . implode('/', $newbits );
    }

    public function matches( $request ){
      if ( $request == $this->cleanurl( $request ) ){
        return false;
      }
      return true;
    }

    public function execute( $action ){
      $this->action = Dispatcher_Utils::vivify_action( func_get_args() );
      return $this;
    }

    public function action( $request ){
      $action = $this->action;
      /*
      $action->add_param( array(
        'name' => 'cleanurl',
        'type' => 'url',
        'value' => $this->cleanurl( $request ),
      ));
      $action->add_param( array(
        'type' => '_internal',
        'name' => 'dispatcher',
        'value' => &$this->dispatcher
      ));
      $action->add_param( array(
        'type' => '_internal',
        'name' => 'rule',
        'value' => &$this
      ));*/
      $action->set_param(array(
        'cleanurl' => array( 'value'=> $this->cleanurl( $request ) ),
        'dispatcher' => array( 'value' => &$this->dispatcher ),
        'rule' => array( 'value' => &$this ),
      ));
      return $action;
    }
  }
