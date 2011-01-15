<?php
mysql_connect();
mysql_select_db('core');
$stdin = fopen ('php://stdin', 'r');
ob_implicit_flush (true); // Use unbuffered output
while ($line = fgets ($stdin))
{
//print $line;
//mail('service@mdwestserve.com',$line,$line);
@mysql_query("insert into apacheErrors (message) values ('$line')");
}
?>
