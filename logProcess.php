<?PHP
// Configuration
$database = "ON"; // (ON/OFF)
$hardlog = "OFF"; // (ON/OFF)
$email = "OFF"; // (ON/OFF)
$logfile = "/var/log/httpd/error_log"; // full path to error log (make sure apache can write to log)
$email_subject = "Apache Error at ".time(); // subject with time since the Unix Epoch appended
$email_to = ""; // email address to send error to
// Functions
function getProTable($string){
// determine what table we should store the message in (apacheError/apacheLog)
return $table;
}
function getProType($string){
// determine which of the 4 types of messages (GET/POST/error/notice)
return $type;
}
function getProFile($string){
// attempt to pull the file name out of the message (full path/relative path/single file name)
return $file;
}
// Application
if($database == "ON"){
 mysql_connect(''); //connect to database
 mysql_select_db(''); // select database
}
$stdin = fopen ('php://stdin', 'r');
ob_implicit_flush (true); // Use unbuffered output
while ($line = fgets ($stdin))
{
 $table = getProTable($line);
 $type = getProType($line);
 $file = getProFile($line);
 if($hardlog == "ON" && file_exists($logfile)){
  error_log($line,3,$logfile);
 }
 if($email == "ON" && $email_to && $email_subject){
  mail($email_to,$email_subject,$line);
 }
 if($database == "ON"){
$line = substr($line, 27);
$parts=explode(']',$line);
$line = $parts[2];

$rTest=@mysql_query("select id, counter from apacheErrors where message = '".addslashes($line)."'");
$dTest=mysql_fetch_array($rTest,MYSQL_ASSOC);
if(!$dTest[id]){
@mysql_query("insert into apacheErrors (message, counter, lastTime) values ('".addslashes($line)."','1',NOW())");
}else{
$counter = $dTest[counter]+1;
@mysql_query("update apacheErrors set counter = '$counter', lastTime= NOW() where id = $dTest[id] ");
}
 }
}
?>
