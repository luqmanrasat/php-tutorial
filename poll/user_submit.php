<html>
  <head>
    <basefont face='Arial'>
    <title>User Submit</title>
  </head>
  <body>
    <?php
      // check if a cookie exist for this question and deny access if exist
      if (isset($_COOKIE) && !empty($_COOKIE)) {
        if ($_COOKIE['lastpoll'] && $_COOKIE['lastpoll'] == $_POST['qid']) {
          die('ERROR: You have already voted in this poll');
        }
      }

      // set cookie
      setCookie('lastpoll', $_POST['qid'], time() + 2592000);

      if (isset($_POST['submit'])) {
        if (!isset($_POST['aid'])) {
          die('ERROR: Please select one of the available choices');
        }
        // include configuration file
        include('config.php');
        // create mysqli object and open connection
        $mysqli = new mysqli($host, $user, $pass, $db);
        // check for connection errors
        if (mysqli_connect_errno()) {
          die("Unable to connect!");
        }
        // create query to update vote counter and execute query
        $query = "UPDATE answers SET acount = acount + 1 WHERE aid = " .$_POST['aid']. " AND qid = " .$_POST['qid'];
        if($result = $mysqli->query($query)) {

          // print success message
          echo 'Your vote was succesfully registered!';
        }
        else {
          // print error message
          echo "Error in query: $query" .$mysqli->error;
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
