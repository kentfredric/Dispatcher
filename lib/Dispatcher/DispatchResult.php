<?php

#=head1 Dispatcher_DispatchResult - A Structured value-passing container to facilitate redispatching.
#
#=cut
#

#=head2 SYNOPSIS
#
#   $dr = new Dispatcher_DispatchResult( $dispatcher , '/foo/bar/url' );
#   $action = $dr->dispatch(); #gets the level-1 action in $dispatcher matching $url
#   $action = $dr->dispatch(true); # gets the recursive dispatch with the url.
#
# This is largely a workaround for the fact we can't return curried functions, and we don't want to be injecting the
# request url into the dispatcher itself ( or when the same dispatcher occurs twice in a tree all hell will occur )
# so this object is a good way of passing it around.
#
# Its also useful to be extendable as to how it works.
#
#=cut
#
class Dispatcher_DispatchResult {

  private $_dispatcher;
  private $_url;

  #=head2 METHODS
  #
  #=head3 new
  #
  #   $dr = new Dispatcher_DispatchResult( Dispatcher $dispatcher, $request );
  #
  #=cut
  #

  public function __construct( Dispatcher $dispatcher, $requesturl = null ){
    $this->_dispatcher = $dispatcher;
    $this->_url = $requesturl;
  }

  #=head3 dispatch
  #
  #   $action = dispatch( $recursive = false );
  #
  # See L<< C<Dispatcher>|Dispatcher >> for how this works, its essentially just a wrapper for the 2
  # methods in there that injects a custom request url.
  #
  #=cut
  #
  public function dispatch( $recursive = false ){
    if( ! $recursive ){
      return $this->_dispatcher->get_action_for( $this->_url );
    }
    return $this->_dispatcher->get_recursive_action_for( $this->_url );
  }
}
