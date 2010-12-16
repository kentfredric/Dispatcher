<?php

class Dispatcher_Action_StaticFile implements Dispatcher_Action { 

  private $setparams; 
  private $opts;

  public function __construct(array $opts = array() ){ 
    $this->opts = $opts;
  }

  public function _deliver_file( $rawname ){ 


  }

  public function perform( ){ 
    if( array_key_exists( 'source_param' , $this->opts ) ){
      $keyname = $this->opts['source_param'];
      if( array_key_exists($keyname, $this->setparams ) ){ 
        return $this->_deliver_file( $this->setparams[$keyname]);
      }
      # Crap.
    } elseif ( array_key_exists('filename' , $this->opts ) ){ 
      return $this->_deliver_file( $this->opts['filename'] );
    } else {
      # CRAP.
    }
  }

  public function set_param( array $params ){
    $this->setparams = $params;
  }
}
