<?php

  class Dispatcher_Rule_OnDisk extends Dispatcher_Rule_Base_Basic {

    private $document_root;

    public function __construct( array $config ){
      $this->document_root = Dispatcher_Utils::extract_param( $config, array( 
        'name' => 'document_root',
        'required' => true,
      ));
    }

    public function _fullpath( $request ){
      $root = preg_replace('/\/?$/','/', $this->document_root );
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


    public function action( $request ){
      $action = parent::action($request);
      $action->set_param('fullpath', array( 'value' => $this->_fullpath( $request ) ) );
      return $action;
    }

  }
