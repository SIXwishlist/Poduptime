<?php
 include('config.php');
if (!$_POST['username']){
  echo "no username given";
 die;
}
if (!$_POST['userurl']){
  echo "no userurl given";
 die;
}
if (!$_POST['domain']){
  echo "no pod domain given";
 die;
}
if (!$_POST['comment']){
  echo "no comment";
 die;
}
if (!$_POST['rating']){
  echo "no rating given";
 die;
}

 $dbh = pg_connect("dbname=$pgdb user=$pguser password=$pgpass");
     if (!$dbh) {
         die("Error in connection: " . pg_last_error());
     }
     $sql = "INSERT INTO rating_comments (domain, comment, rating, username, userurl) VALUES($1, $2, $3, $4, $5)";
     $result = pg_query_params($dbh, $sql, array($_POST['domain'], $_POST['comment'], $_POST['rating'], $_POST['username'], $_POST['userurl']));
     if (!$result) {
         die("Error in SQL query: " . pg_last_error());
     }
     $to = $adminemail;
     $subject = "New rating added to poduptime ";
     $message = "Pod:" . $_POST["domain"] . $_POST['domain'] . $_POST['username'] . $_POST['userurl'] . $_POST['comment'] . $_POST['rating'] . "\n\n";
     $headers = "From: ".$_POST["email"]."\r\n";
     @mail( $to, $subject, $message, $headers );    

     echo "Comment posted!";
     pg_free_result($result);
     pg_close($dbh);

?>
