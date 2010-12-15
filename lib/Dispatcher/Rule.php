<?php

interface Dispatcher_Rule {

  public function set_dispatcher( Dispatcher $d );
  public function matches( $string );
  public function action( $string );

}
