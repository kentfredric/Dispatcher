<?php

class Dispatcher_Rule_Default extends Dispatcher_Rule_Base_Basic {

  public function matches( $request ){
    return true;
  }

}
