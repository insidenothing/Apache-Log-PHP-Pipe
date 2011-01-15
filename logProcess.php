<?php
mysql_connect(); //connect to database (pconnect?)
mysql_select_db('apache'); // select database
$stdin = fopen ('php://stdin', 'r');
ob_implicit_flush (true); // Use unbuffered output
while ($line = fgets ($stdin))
{
//print $line; //uncomment to pipe output to default error log
//mail('insidenothing@gmail.com','Apache Error',$line); //uncomment to send email containing error
@mysql_query("insert into apacheErrors (message) values ('$line')"); //uncomment to record to database
}
?>
