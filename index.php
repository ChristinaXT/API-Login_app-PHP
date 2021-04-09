<?php
    $url = 'https://www.expensify.com/api';
    session_name("expensify_user");
    session_start();
     //  if (!session_id() && !headers_sent()) {
     //     session_start();
     // }
     // isset() function is used to check if a variable has been set or not. This can be useful to check the submit button is clicked or not. The isset() function will return true or false value. The isset() function returns true if variable is set and not null
    if(isset($_POST['logout'])) {
        unset($_SESSION);
        session_destroy(); //destroys all of the data associated with the current session. It does not unset any of the global variables associated with the session, or unset the session cookie
        header("Location:index.php"); //The header() function sends a raw HTTP header to a client. It is important to notice that the header() function must be called before any actual output is sent!
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expensify Take-Home Challenge</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
</head>
<body>
  <div id="welcome">
    <h2>Welcome to Christina's Expensify Challenge</h2>
  </div>
    <div id=<?php echo !isset($_SESSION["authToken"]) ? "loginContent" : "logoutContent" ?>>
        <?php
            if(!isset($_SESSION["authToken"])) {
                echo '<h1>Login Here</h1>';
                echo '<p>Please fill in this form to Login.</p>';
                echo '<hr>';
                echo '<form method="post" id="loginForm" action="">'
                        . '<div class="container">'
                        . '<input type="hidden" name="partnerName" value="applicant"/>'
                        . '<input type="hidden" name="partnerPassword" value="d7c3119c6cdab02d68d9" />'
                        . '<p>Username:</p><input type="text" name="partnerUserID" placeholder="Enter Email" value="" />'
                        . '<p>Password:</p><input type="password" name="partnerUserSecret" placeholder="Enter Password" value="" />'
                        . '<label class="checkbox">'
                        . '<input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me'
                        . '</label>'
                        . '<div class="clearfix">'
                        . '<input type="submit" class="loginbtn" id="loginbtn" name="login" value="LOGIN" />'
                        . '</div>'
                        . '</div>'
                        . '</form>';
            } else {
                echo "<p>".(empty($_SESSION['email']) ? 'Guest' : $_SESSION['email']). "</p>";
                echo ' <form method="post" id="logoutForm" action="">'
                        . '<input type="submit" name="logout" value="Logout" id="logoutBtn" />'
                     .'</form>';
            }
            echo "</div>";

            if(isset($_SESSION["authToken"])) {
                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt($ch, CURLOPT_URL, $url . '?command=Get&authToken=' . $_SESSION['authToken'] . '&returnValueList=transactionList');
                 $response = curl_exec($ch);
                 if ($response === false)
                     $response = curl_error($ch);
                 else {
                     echo '<div id="transactionTable">'
                         . '<h3>Transactions:</h3>'
                         . '<table>'
                         . '<thead>'
                         . '<tr>'
                         . '<th>Transaction Date</th>'
                         . '<th>Merchant</th>'
                         . '<th>Amount</th>'
                         . '</tr>'
                         . '</thead>';

                    //Takes a JSON encoded string and converts it into a PHP
                     $obj = json_decode($response, true);
                     if(array_key_exists('transactionList', $obj)) {
                         $transactions = $obj['transactionList'];
                         if (count($transactions) > 0) {
                             foreach ($transactions as $transaction) {
                                  echo "<tr>"
                                     . "<td>{$transaction["created"]}</td>"
                                     . "<td>" . substr($transaction["merchant"], 0, 15) . "</td>"
                                     . "<td>{$transaction["amount"]}</td>"
                                     . "</tr>";
                             }
                         }
                     } else {
                         echo "<tr><td>There are no Transactions</td></tr>";
                     }
                     echo '<tbody id="transactionTableBody">';
                      // <!-- Add the transaction rows here -->
                     echo '</tbody></table></div>';
                 }
                 echo '<div id="transactionForm">'
                            . '<div class="transactionForm">'
                               // <!-- Add your create transaction form here -->
                            . '<h2 id="transaction-header">Create A Transaction:</h2>'
                            . '<form method="post" id="createTransaction" action="">'
                            . '<input type="text" name="merchant" placeholder="Created: yyyy-mm-dd" value=""/>'

                            . '<input type="text" name="merchant" id="merchant" placeholder="Enter Merchant" value="" size="30"/>'

                            . '<input type="text" name="amount" id="amount" placeholder="Enter $ Amount" value="" />'

                            . '<input type="submit" class="tButton" id="transactionButton" name="transactionButton" value="ADD"/>'
                            . '</form>'
                            . '</div>'
                            . '</div>';
             }
             ?>
    <!-- Javascript Files, we've included JQuery here, feel free to use at your discretion. Add whatever else you may need here too. -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>

</body>
</html>
