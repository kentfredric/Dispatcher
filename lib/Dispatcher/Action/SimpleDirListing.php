<?php

class Dispatcher_Action_SimpleDirListing implements Dispatcher_Action {

  private $setparams;
  private $opts;

  public function __construct(array $opts = array() ){
    $this->opts = $opts;
  }

  public function _list_dir( $dir ){
    $fh = opendir( $dir );
    header("Content-Type: text/plain");
    while( false !== ( $file = readdir( $fh ) ) ){
      if( $file == '.' or $file == '..' ){
        continue;
      }
      print "$file\n";
    }
    closedir( $fh );
  }
  public function _dirname(){
    if( array_key_exists('source_param', $this->opts ) ){
      $keyname = $this->opts['source_param'];
      if ( array_key_exists($keyname, $this->setparams ) ){
        return $this->setparams[$keyname];
      }
    }
    if( array_key_exists( 'filename', $this->opts ) ){
      return $this->opts['filename'];
    }
    return false;
  }
  public function perform( ){
    $dir = $this->_dirname();
    if( !$dir ){
      # die!?
    }
    return $this->_list_dir( $dir );
  }

  public function set_param( array $params ){
    $this->setparams = $params;
  }
}
