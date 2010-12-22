<?php

  class Dispatcher_Rule_OnDiskDir extends Dispatcher_Rule_Base_Basic {

    private $root;

    public function __construct( $root ){
      $this->root = $root;
    }

    public function _fullpath( $request ){
      $root = preg_replace('/\/?$/','/', $this->root );
      $request = preg_replace('/^\/?/','', $request );
      $fulluri = $root . $request;
      return $fulluri;
    }
    public function matches( $request ){
      $fp = $this->_fullpath( $request);
#      print "Testing if exists $fp\n";
      if( file_exists( $fp ) && is_dir( $fp ) ){
        return true;
      }
      return false;
    }

    public function action( $request ){
      $action = parent::action( $request );
      $action->set_param( 'fullpath', array( 'value' => $this->_fullpath( $request ) ) );
      return $action;
    }
  }
