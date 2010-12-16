<?php

#=head1 Dispatcher_Action - Abstract Interface for Actions
#
#=cut

interface Dispatcher_Action {

  #=head2 REQUIRED METHODS
  #
  #=head3 perform
  #
  #=over 4
  #
  #=item C<perform()> performs the perscribed action.
  #
  #=item Use C<set_param()> to pass parameters.
  #
  # Any parameters perform needs to see should be passed in
  # by C<set_param()> prior to C<perform()> being called.
  #
  #=item C<perform()> is not expected to return anything of value.
  #
  # At least, nothing of value in the normal case, but it can anyway.
  # This is used by the L<Dispatcher_RecursiveAction> interface to return generated
  # dispatch-tables for sub-dispatching. Generally speaking however, you should assume nothing
  # is going to see your return value, and that the program
  # will terminate and do cleanup after you return.
  #
  #=item You should B<NOT> call C<exit()>.
  #
  # Because otherwise higher level output processing things such as gzip encoding may fail.
  #
  #=back
  #
  #=cut
  public function perform();

  #=head3 set_param
  #
  # this function is required for this class to be of any value,
  # and various dispatcher rules will feed you with data based
  # on what they've worked out.
  #
  # if you want to rely on a regular-experession or other partial-match
  # based value extraction as part of the match rule, you'll need to
  # implement this function to have that data fed to you.
  #
  #=cut
  #
  public function set_param( array $paramdata );
}
