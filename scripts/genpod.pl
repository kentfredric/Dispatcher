#!/usr/bin/perl

use strict;
use warnings;

use File::Find::Rule;
use Path::Class qw( file dir );
use FindBin;
use File::Slurp qw( read_file write_file );

my $root = dir($FindBin::Bin)->parent;
my $lib = $root->subdir('lib')->resolve;
my $pod = $root->subdir('pod');
$pod->mkpath();

sub podify {
    my ( $from, $to ) = @_;
#    print ">> $from => $to\n";
#    return;
    my $ofh;
    my $needfh = sub {
        return if defined $ofh;
        open $ofh, '>', $to or die;
    };
    open my $ifh, '<', $from or die;
    while(defined( my $line = <$ifh> ) ){
        next unless $line =~ /#/;
        $line =~ s/^[^#]*#//;
        if( $line =~ m/^=/ ){
            $needfh->();
            print { $ofh } $line;
            print { $ofh } "\n";
            next;
        }
        $line =~ s/^ //;
        $needfh->();
        print { $ofh } $line;
    }
}

sub php_to_pod {
   my $phpname = shift;
   my $ipath = file( $phpname );
   my $rpath = $ipath->relative($lib)->stringify;
   $rpath =~ s/.php$/.pod/;
   $rpath =~ s{/}{_}g;
   my $podpath = $pod->file( $rpath );
   print "$rpath => $podpath\n";
   podify( $ipath->relative('.')->stringify, $podpath->relative('.')->stringify );
}

sub exec2file {
    my ( $file, @exec ) = @_;
    open my $ifh, '-|', @exec or die;
    open my $ofh, '>', $file or die;
    write_file( $ofh, {binmode => ':raw' }, read_file( $ifh, array_ref => 1, binmode => ':raw' ) );

}
sub textize {
    my $podfile = file( shift )->relative('.');
    {
        my $textfile = $podfile;
        $textfile =~ s/.pod/.txt/;
        print "totext: $podfile => $textfile\n";
        exec2file( $textfile, 'pod2text',  $podfile );
    }
    {
        my $textfile = $podfile;
        $textfile =~ s/.pod/.ctxt/;
        print "toctext: $podfile => $textfile\n";
        exec2file( $textfile, 'pod2text', '-c', $podfile );
    }
    {
        my $textfile = $podfile;
        $textfile =~ s/.pod/.1/;
        print "toman: $podfile => $textfile\n";
        exec2file( $textfile, 'pod2man','-u','-c','PHP Dispatcher Documentation', $podfile );
    }
    {
        my $textfile = $podfile;
        $textfile =~ s/.pod/.html/;
        print "tohtml: $podfile => $textfile\n";
        exec2file( $textfile, 'pod2html','--htmlroot=.','--podroot=.','--podpath=./','--infile', $podfile );
    }
}

php_to_pod($_) for  File::Find::Rule->name('*.php')->in($lib);
textize($_) for File::Find::Rule->name('*.pod')->in($pod);
system('pod2latex', '-full','-verbose', '-out', $pod->file('documentation.tex')->stringify, File::Find::Rule->name('*.pod')->in($pod));
open my $fh, '<', $pod->file('documentation.tex')->stringify  or die;
unlink $pod->file('documentation.tex')->stringify;
open my $ofh, '>', $pod->file('documentation.tex')->stringify or die;

while(defined( my $line = <$fh>  ) ){

    if( $line =~ /^\\makeindex/ ){
         $line .= '\usepackage[colorlinks=false,backref,hyperindex=true]{hyperref}' . "\n" .
            '\setcounter{tocdepth}{5}' . "\n";
    }
    $line =~ s/section\*/section/g;
    print { $ofh } $line;
}


#system('texi2dvi', '--tidy','-b',$pod->file('documentation.tex')->relative('.')->stringify );
system('texi2pdf', '--tidy','-b',$pod->file('documentation.tex')->relative('.')->stringify );


