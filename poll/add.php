<html>
  <head>
    <basefont face='Arial'>
    <title>Add</title>
  </head>
  <body>
    <h2>Administration</h2>
    <?php
    if (isset($_POST['submit'])) {
      // check form input for errors

      // check title
      if (trim($_POST['qtitle'] == '')) {
        die('ERROR: Please enter a question');
      }

      // clean up options
      // add valid ones to a new array
      foreach ($_POST['options'] as $o) {
        if (trim($o) != '') {
          $atitles[] =  $o;
        }
      }

      // check for at least two options
      if (sizeof($atitles) <= 1) {
        die('ERROR: Please enter at least two answer choices');
      }

      // include configuration file
      include('config.php');

      // create mysqli object and open connection
      $mysqli = new mysqli($host, $user, $pass, $db);
      if (mysqli_connect_errno()) {
        die("Unable to connect!");
      }

      // create query to insert question and execute query
      $query = "INSERT INTO questions (qtitle, qdate) VALUES ('{$_POST['qtitle']}', NOW())";
      if ($result = $mysqli->query($query)) {

        // get id of inserted record
        $qid = $mysqli->insert_id;

        // create query to insert options and linking each with qid and execute query
        foreach ($atitles as $atitle) {
          $query = "INSERT INTO answers (qid, atitle, acount) VALUES ('$qid', '$atitle', '0')";
          $result = $mysqli->query($query);
        }
        if ($mysqli->error == '') {
          // print success message
          echo "Question successfully added to the database! Click <a href='admin.php'>here</a> to return to the main page";
        }
        else {
          // print error message
          echo "Error in query: $query " .$mysqli->error;
        }
      }
      else {
        // print error message
        echo "Error in query: $query " .$mysqli->error;
      }
      $mysqli->close();
    }
    else {
      die('ERROR: Data not correctly submitted');
    }
    ?>
  </body>
</html>
