<html>
  <head>
    <basefont face='Arial'>
    <title>User</title>
  </head>
  <body>
    <?php
    include('config.php');
    // create mysqli object and open connection
    $mysqli = new mysqli($host, $user, $pass, $db);
    // check for connection errors
    if (mysqli_connect_errno()) {
      die("Unable to connect!");
    }
    // create query to select title and execute query
    $query = "SELECT qid, qtitle FROM questions ORDER BY qdate DESC LIMIT 0, 1";
    if ($result = $mysqli->query($query)) {
      // if questions present
      if ($result->num_rows > 0) {
        // get question ID and title
        $row = $result->fetch_object();
        $qid = $row->qid;
        echo '<h2>' .$row->qtitle. '</h2>';
        echo "<form method='post' action='user_submit.php'>";
        // create query to select answer for qid and execute query
        $query = "SELECT aid, atitle FROM answers WHERE qid='$qid'";
        if ($result = $mysqli->query($query)) {
          // if answers present
          if ($result->num_rows > 0) {
            // print answer list as radio buttons
            while ($row = $result->fetch_object()) {
              echo "<input type='radio' name='aid' value='" .$row->aid. "'>'" .$row->atitle. "'<br />";
            }
            echo "<input type='hidden' name='qid' value='" .$qid. "'><br>";
            echo "<input type='submit' name='submit' value='Vote!'>";
          }
          // if no answers present, display message
          else {
            echo '<font size="-1">No answer currently configured for this question</font>';
          }
        }
        else {
          // print error message
          echo "Error in query: $query" .$mysqli->error;
        }
        echo '</form>';
      }
      // if no questions present, display message
      else {
        echo '<font size="-1">No questions currently configured</font>';
      }
    }
    else {
      // print error message
      echo "Error in query: $query" .$mysqli->error;
    }
    // close connection
    $mysqli->close();
    ?>
  </body>
</html>
