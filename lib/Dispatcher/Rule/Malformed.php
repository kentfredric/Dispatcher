<?php

  class Dispatcher_Rule_Malformed extends Dispatcher_Rule_Base_Basic {

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


    public function action( $request ){
      $action = parent::action( $request );
      $action->set_param( 'cleanurl' , array( 'value' => $this->cleanurl($request)));
      return $action;
    }
  }
