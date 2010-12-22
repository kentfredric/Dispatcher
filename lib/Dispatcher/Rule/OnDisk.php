<?php

  class Dispatcher_Rule_OnDisk implements Dispatcher_Rule {

    private $dispatcher;
    private $action;
    private $root;
    private $document_root;

    public function __construct( array $config ){
      $this->document_root = Dispatcher_Utils::extract_param( $config, array( 
        'name' => 'document_root',
        'required' => true,
      ));
    }

    public function set_dispatcher( Dispatcher $d ){
      $this->dispatcher = $d;
    }

    public function _fullpath( $request ){
      $root = preg_replace('/\/?$/','/', $this->root );
      $request = preg_replace('/^\/?/','', $request );
      $fulluri = $root . $request;
      return $fulluri;
    }

    public function matches( $request ){
      $fp = $this->_fullpath( $request);
      if( file_exists( $fp ) && is_file( $fp ) ){
        return true;
      }
      return false;
    }

    public function execute( $action ){
      $this->action = Dispatcher_Utils::vivify_action( func_get_args() );
      return $this;
    }

    public function action( $request ){
      $action = $this->action;
      $action->set_param(array(
        'dispatcher' => &$this->dispatcher,
        'rule' => &$this,
        'fullpath' => $this->_fullpath( $request )
      ));
      return $action;
    }
  }
