<html>
  <head>
    <basefont face='Arial'>
    <title>Admin</title>
  </head>
  <body>
    <h2>Administration</h2>

    <h4>Current Questions:</h4>
    <table border='0' cellspacing='10'>
      <?php
        // include configuration file
        include('config.php');

        // create mysqli object and open connection
        $mysqli = new mysqli($host, $user, $pass, $db);
        if (mysqli_connect_errno()) {
          die('Unable to connect!');
        }

        // create query to select question and execute query
        $query = 'SELECT qid, qtitle, qdate FROM questions ORDER BY qdate DESC';
        if ($result = $mysqli->query($query)) {

          // if question present
          if ($result->num_rows > 0) {

            // iterate through result set and print questions title
            while ($row = $result->fetch_object()) {
      ?>
              <tr>
                <td><?php echo $row->qtitle; ?></td>
                <td><font size='-2'><a href='view.php?qid=<?php echo $row->qid; ?>'>view report</a></font></td>
                <td><font size='-2'><a href='delete.php?qid=<?php echo $row->qid; ?>'>delete</a></font></td>
              </tr>
      <?php
            }
          }

          // if no question present
          else {
      ?>
            <font size='-1'>No questions currently configured</font>
      <?php
          }
        }
        else {
          // print error message
          echo "Error in query: $query " .$mysqli->error;
        }

        // close connection
        $mysqli->close();
      ?>
    </table>

    <h4>Add New Question:</h4>
    <form action='add.php' method='post'>
      <table border='0' cellspacing='5'>
        <tr>
          <td>Question</td>
          <td><input type='text' name='qtitle'></td>
        </tr>
        <tr>
          <td>Option #1</td>
          <td><input type='text' name='options[]'></td>
        </tr>
        <tr>
          <td>Option #2</td>
          <td><input type='text' name='options[]'></td>
        </tr>
        <tr>
          <td>Option #3</td>
          <td><input type='text' name='options[]'></td>
        </tr>
        <tr>
          <td>Option #4</td>
          <td><input type='text' name='options[]'></td>
        </tr>
        <tr>
          <td>Option #5</td>
          <td><input type='text' name='options[]'></td>
        </tr>
        <tr>
          <td colspan='2' align='right'><input type='submit' name='submit' value='Add Question'></td>
        </tr>
      </table>
    </form>
  </body>
</html>
