


<?php
$con = mysql_connect("localhost","root","password@123");
if(!$con)
{
die('Could not Connect: ' . mysql_error());
}
else
{
echo "Congrats";
}
mysql_close($con);
?>
