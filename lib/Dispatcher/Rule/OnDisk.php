<?php

  class Dispatcher_Rule_OnDisk implements Dispatcher_Rule { 

    private $dispatcher;
    private $action;

    public function set_dispatcher( Dispatcher $d ){ 
      $this->dispatcher = $d;
    }

    public function cleanurl( $url ){
      $bits = explode('/', $url );
      foreach( $bits as $i => $v ){
        if( empty( $v ) ){
          continue;
        }
        array_push( $bits, $v );
      }
      return '/' . implode('/', $bits );
    }

    public function matches( $request ){
      if ( $request == $this->cleanurl( $request ) ){
        return false;
      }
      return true;
    }

    public function execute( $action ){ 
      $this->action = &$action;
      return $this;
    }

    public function action( $request ){
      $action = $this->action;
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
      ));
      return $action;
    }
  }
