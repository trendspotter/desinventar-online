#!/usr/bin/perl
#
# Control Script for DICORE Server
# (c) 2007 Corporacion OSSO 
# 2008-08-20 Jhon H. Caicedo <jhcaiced@desinventar.org>
#

#use strict;
#use warnings;
use Frontier::Client;
use Getopt::Long;
use Data::Dumper;

my $sURL   = "http://localhost:8081";
#if (!GetOptions('help|h'   => \$bHelp,
#                'start'  => \$bStart,
#                'stop'   => \$bStop,
#                'save'   => \$bSave
#   )) {
#   die "Error : Incorrect parameter lit, please use --help\n"; 
#}

my $client = Frontier::Client->new(url => $sURL, debug => 0);

$sSessionUUID = $client->call('RpcUserOperations.openUserSession', ('root','97ossonp'));
print "Session : " . $sSessionUUID . "\n";
$sRegionUUID = 'BOLIVIA';
$sInfo = $client->call('RpcSessionOperations.existSession', ($sSessionUUID));
print Dumper($sInfo);
sleep(10);
$sInfo = $client->call('RpcSessionOperations.existSession', ($sSessionUUID));
print Dumper($sInfo);
$client->call('RpcUserOperations.closeUserSession', ($sSessionUUID));
#