<?php

class Dispatcher_Action_StaticFile implements Dispatcher_Action { 

  private $setparams; 
  private $opts;

  public function __construct(array $opts = array() ){ 
    $this->opts = $opts;
  }

  public function _deliver_file( $rawname, $type ){ 

    header("Content-Type: $type");
    readfile( $rawname );

  }

  public function _filename(){
    if( array_key_exists( 'source_param' , $this->opts ) ){
      $keyname = $this->opts['source_param'];
      if( array_key_exists($keyname, $this->setparams ) ){ 
        return $this->setparams[$keyname];
      }
    }
    if( array_key_exists('filename' , $this->opts ) ){
      return $this->opts['filename'];
    }
  }
  public function _typemap(){
    if( ! array_key_exists( 'typemap' , $this->opts ) ){ 
      $this->opts['typemap'] = 'default';
    }
    if( $this->opts['typemap'] !== 'default' ){ 
      return $this->opts['typemap'];
    }
    $defaultmap = array( 
      "::DEFAULT::" => 'application/octet-stream',
      '.php'        => 'text/plain',
      '.txt'        => 'text/plain',
      '.css'        => 'text/css',
      '.html'       => 'text/html', 
      '.png'        => 'image/png', 
      '.jpg'        => 'image/jpeg', 
      '.gif'        => 'image/gif',
      '.js'         => 'application/javascript',
    );
    return $defaultmap;

  }
  public function _type() {
    if( ! array_key_exists( 'type' , $this->opts ) ){ 
      $this->opts['type'] = 'auto';
    }
    if( $this->opts['type'] === 'auto' ){ 
      $typemap = $this->_typemap();
      #print_r($typemap); die;
      $pathinfo = pathinfo( $this->_filename() ); 
      $extension = '.' . $pathinfo['extension'];
      if( array_key_exists( $extension , $typemap ) ){ 
        return $typemap[$extension];
      }
      if( array_key_exists( '::DEFAULT::', $typemap )){ 
        return $typemap['::DEFAULT::'];
      }
      return 'application/octet-stream';
    }
    return $this->opts['type'];
  }

  public function perform( ){ 
    $filename = $this->_filename();
    if( !$filename ){ 
      #?die?
    }
    $type = $this->_type();
    return $this->_deliver_file( $filename, $type );
  }

  public function set_param( array $params ){
    $this->setparams = $params;
  }
}
