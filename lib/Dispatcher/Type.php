<?php

interface Dispatcher_Type {

  public function nice_name();
  public function isa( $item );
  public function can_coerce( Dispatcher_Type $item );
  public function coerce( $item );
}
