<?PHP
// Configuration 
$database = "ON"; // (ON/OFF)
$hardlog = "ON"; // (ON/OFF)
$email = "OFF"; // (ON/OFF)
$logfile = "/var/log/httpd/error_log"; // full path to error log (make sure apache can write to log)
$email_subject = "Apache Error at ".time(); // subject with time since the Unix Epoch appended
$email_to = ""; // email address to send error to

// Application
if($database == "ON"){
 mysql_connect(); //connect to database
 mysql_select_db('apache'); // select database
}
$stdin = fopen ('php://stdin', 'r');
ob_implicit_flush (true); // Use unbuffered output
while ($line = fgets ($stdin))
{
 if($hardlog == "ON" && file_exists($logfile)){ 
  error_log($line,3,$logfile);
 } 
 if($email == "ON" && $email_to && $email_subject){
  mail($email_to,$email_subject,$line); 
 }
 if($database == "ON"){
  @mysql_query("insert into apacheErrors (message) values ('$line')"); 
 }
}
?>