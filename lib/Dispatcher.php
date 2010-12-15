<?php

#=head1 Dispatcher - A Powerful and Simple Dispatch library for PHP
#
#=head2 SYNOPSIS
#
# Recommended use is in conjuiction with DevKit's Autoload function in your class.
#
# In your Top Level PHP script:
#   
#   if( !defined( 'DEVKIT_AUTOLOAD' ) ){
#     require_once(realpath(dirname(__FILE__)) . '/../path/to/DevKit/Autoload.php' );
#   }
#   DevKit_Autoload::setprefix('YourBaseClass', realpath( $pathtoyourbaseclass ) );
#
#   # YourBaseClass, YourBaseClass_* classes now all dynamically loaded
#
#   require_once(realpath(dirname(__FILE__)) . '/../path/to/Dispatcher.php' );
#
#   # Dispatcher, Dispatcher_* , Dispatch, Dispatch_* classes now all dynamically loaded.
#
#=cut

if( !defined( 'DEVKIT_AUTOLOAD' ) ){ 
  require_once(realpath(dirname(__FILE__)). '/../extlib/DevKit/lib/DevKit/Autoload.php' );
}
DevKit_Autoload::setprefix('Dispatcher', realpath(dirname(__FILE__)) . '/Dispatcher' );
DevKit_Autoload::setprefix('Dispatch', realpath(dirname(__FILE__)) . '/Dispatch' );

class Dispatcher {

  private $rules;

  #=head2 METHODS
  #

  #=head3 new Dispatcher
  #
  #   $dispatcher = new Dispatcher( 
  #      Dispatch::empty()->execute( $action ),
  #      ... more disptachers ... 
  #      Dispatch::default()->execute( $action ),
  #   );
  #
  # This generates a new Dispatcher Object with a top-to-bottom list of rules/instructions to execute.
  # The dispatch tree is executed Once and Once only so this can be taken like a syntactic tree of complex
  # if() statements. 
  #
  #=cut

  public function __construct(){
    $args = func_get_args();
    $this->rules = array();

    foreach ( $args as $i => &$v ){
      if( !is_object( $v ) ){
        Dispatch_Exception::construction("Got something that is not an object for argument $i");
      }
      if( !( $v instanceof Dispatcher_Rule ) ){
        Dispatch_Exception::construction("Got something that is not a Dispatcher_Rule for argument $i");
      }
      $this->add_rule( $v );
    }
    return $this;
  }

  #=head3 add_rule
  #
  # The constructor syntax is pretty much just a big pile of sugar that internally calls this method on all passed
  # arguments.
  #
  #
  #   $dispatcher = new Dispatcher();
  #   $dispatcher
  #     ->add_rule( Dispatch::empty()->execute( $action ) )
  #     ->add_rule( Dispatch::default()->execute( $action ) );
  #
  #=cut

  public function add_rule( Dispatcher_Rule $rule ){
    $rule->set_dispatcher( $this );
    $record = new stdClass();
    $record->rule = &$rule;
    array_push( $this->rules, $record );
    return $this;
  }

  #=head3 get_action_for
  #
  # This method executes the dispatch tree and traverses it doing rule matching. 
  #
  # $action = $dispatcher->get_action_for( '/foo/bar/baz' );
  # $action->perform(); 
  #
  #=cut

  public function get_action_for( $request = '' ){

    if( count($this->rules) < 1 ){
      Dispatch_Exception::dispatch("Dispatcher has no rules, pass one during construction or add it" . 
        "with ->add_rule");
    }

    foreach( $this->rules as $i => &$v ){
      if (! $v->rule->matches( $request ) ){
        continue;
      }
      $result = $v->rule->action( $request );
      if( $result instanceof Dispatcher_Action ){ 
        return $result;
      }
      Dispatch_Exception::dispatch("Returned from Dispatcher_Rule->action() was not a Dispatcher_Action");
    }
    Dispatch_Exception::dispatch("No dispatch rule matched the request. Did you specify a default?");
  }

  #=head3 get_recursive_action_for
  #
  # This is the heart of any deep recursive dispatching. 
  #
  # Identical to get_action_for on non-recursive matches,
  # but does deep recursion on all items that are 'recursive' actions until
  # it finds a non-recursive action.
  #
  #=cut

  public function get_recursive_action_for( $request = '' ){ 

    $myrule = $this->get_action_for( $request );

    if(!( $myrule instanceof Dispatcher_RecursiveAction )){
      return $myrule;
    }

    $subdispatch = $myrule->perform( $request );

    if(!( $subdispatch instanceof Dispatcher_DispatchResult ) ){ 
      Dispatcher_Exception::subdispatch("Item returned from 'perform' on recursive dispatchers must be a Dispatcher_DispatchResult");
    }

    return $subdispatch->dispatch( true );

  }
}
