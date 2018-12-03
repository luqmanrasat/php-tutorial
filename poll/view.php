<html>
  <head>
    <basefont face='Arial'>
    <title>View</title>
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
        die("Unable to connect!");
      }

      // create query to get question and execute query
      $query = "SELECT qtitle FROM questions WHERE qid='" .$_GET['qid']. "'";
      $result = $mysqli->query($query) or die("ERROR: $query. " .$mysqli->error);

      // print question
      $row = $result->fetch_object();
      echo '<h3>'.$row->qtitle.'</h3>';

      // create query to count total votes and execute query
      $query = "SELECT qid, SUM(acount) AS total FROM answers GROUP BY qid HAVING qid='" .$_GET['qid']. "'";
      $result = $mysqli->query($query) or die("ERROR: $query. " .$mysqli->error);
      $row = $result->fetch_object();
      $total = $row->total;

      // if votes has been cast
      if ($total > 0) {
        // create query to get votes for each answer and execute query
        $query = "SELECT atitle, acount FROM answers WHERE qid='" .$_GET['qid']. "'";
        $result = $mysqli->query($query) or die("ERROR: $query. " .$mysqli->error);

        if ($result->num_rows > 0) {
          // print vote result
          echo '<table border=1 cellspacing=0 cellpadding=15>';
          while ($row = $result->fetch_object()) {
    ?>
            <tr>
              <td><?php echo $row->atitle; ?></td>
              <td><?php echo $row->acount; ?></td>
              <td><?php echo round(($row->acount / $total) * 100, 2) ."%"; ?></td>
            </tr>
    <?php
          }
          // print total votes
    ?>
            <tr>
              <td><u>TOTAL</u></td>
              <td><?php echo $total; ?></td>
              <td>100%</td>
            </tr>
          </table>
    <?php
        }
      }
      // if votes has not been cast
      else {
        echo 'No votes cast yet';
      }

      // close connection
      $mysqli->close();
    }
    else {
      die('ERROR: Data not correctly submitted');
    }
    ?>
  </body>
</html>
