<?php
mysql_connect(); //connect to database (pconnect?)
mysql_select_db('apache'); // select database
$stdin = fopen ('php://stdin', 'r');
ob_implicit_flush (true); // Use unbuffered output
while ($line = fgets ($stdin))
{
error_log($line,3,"/var/log/httpd/error_log"); //uncomment to write to default error log (centos5)
//mail('insidenothing@gmail.com','Apache Error',$line); //uncomment to send email containing error
@mysql_query("insert into apacheErrors (message) values ('$line')"); //uncomment to record to database
}
?>
