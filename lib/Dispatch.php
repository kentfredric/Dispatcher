<?php

class Dispatch {

    public static function isempty(){
      return new Dispatcher_Rule_Empty();
    }

    public static function malformed(){
      return new Dispatcher_Rule_Malformed();
    }

    public static function ondisk( $root ){
      return new Dispatcher_Rule_OnDisk($root);
    }

    public static function ondisk_dir( $root ){
      return new Dispatcher_Rule_OnDiskDir($root);
    }
    public static function token( $tokeno, Dispatch_Matcher $matcher ){
      return new Dispatcher_Rule_Token( $tokeno, $matcher );
    }
    public static function isdefault( ){
      return new Dispatcher_Rule_Default();
    }

    #=head1
    #
    #   Dispatch::er('OnDisk', $root )->execute();
    #   Dispatch::er('Malformed')->execute();
    #
    # This really is just an inglorious hack to get around a limitation in php.
    #
    # Normally, you cant do this:
    #
    #   (new Foo())->execute()
    #
    # Because some PHP Deity decided that had no application.
    #
    # Dispatch:: pretty much exists soley as a work-around for this problem.
    #
    # Dispatch::er is there for the case where the rule you want hasn't been
    # added to Dispatch.php yet.
    #
    #   Dispatch::er('Foo',1,2,3,4)->execute()
    #
    # will then do
    #
    #   $x = new Dispatch_Rule_Foo( 1, 2, 3, 4 );
    #   $x->execute
    #
    # but without needing to store $x somewhere it can get hurt.
    #
    #=cut
    #
    public static function er( $rulename ) {
      return Dispatcher_Utils::vivify_rule( func_get_args() );
    }
    public static function Action( $name ){
      return Dispatcher_Utils::vivify_action( func_get_args() );
    }
    public static function Exception( $name ){ 
      throw Dispatcher_Utils::vivify_exception( func_get_args() );
    }
}
