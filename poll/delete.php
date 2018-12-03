<html>
  <head>
    <basefont face='Arial'>
    <title>Delete</title>
  </head>
  <body>
    <h2>Administration</h2>
    <?php
      if ($_GET['qid'] && is_numeric($_GET['qid'])) {
        // include configuration file
        include('config.php');

        // create mysqli object and open connection
        $mysqli = new mysqli($host, $user, $pass, $db);
        if (mysqli_connect_errno()) {
          die("Unable to connect");
        }

        // create query to get question and execute query
        $query = "SELECT qtitle FROM questions WHERE qid='" .$_GET['qid']. "'";
        if($result = $mysqli->query($query)) {

          // create delete question query and execute query
          $query = "DELETE FROM questions WHERE qid='" .$_GET['qid']. "'";
          $mysqli->query($query);
          if ($mysqli->error == '') {
            // print success message
            echo "Question successfully removed from the database! Click <a href = 'admin.php'>here</a> to return to the main page";
          }
          else {
            // print error message
            echo "Error in query: $query " .$mysqli->error;
          }
        }
        else {
          echo "Error in query: $query " .$mysqli->error;
        }
      }
      else {
        die('ERROR: Data not correctly submitted');
      }
    ?>
  </body>
</html>
