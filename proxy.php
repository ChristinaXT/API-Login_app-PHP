<?php
// echo "hello";
// if (!session_id() && !headers_sent()) {
//    session_start();
// }
session_name("expensify_user");
session_start();

$baseUrl = "'https://www.expensify.com/api";
$url = 'https://www.expensify.com/api';
date_default_timezone_set('UTC');

// isset() function is used to check if a variable has been set or not. This can be useful to check the submit button is clicked or not. The isset() function will return true or false value. The isset() function returns true if variable is set and not null.
if(isset($_POST['partnerName'])) {
    $formData = [
        "partnerName" => $_POST["partnerName"],
        "partnerPassword" => $_POST["partnerPassword"],
        "partnerUserID" => $_POST["partnerUserID"],
        "partnerUserSecret" => $_POST["partnerUserSecret"]
    ];

		// create a new cURL resource
    //  Initiate curl
    $ch = curl_init();
		// set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, $url.'?command=Authenticate');
		// 1. Set the CURLOPT_RETURNTRANSFER option
     // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// 2. Set the CURLOPT_POST option to count formData for POST request
    curl_setopt($ch, CURLOPT_POST, 1);
		// 3. Set the request formData as JSON using json_encode function
    curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);

    // Execute/response
    $response = curl_exec($ch);
    if ($response === false)
        $response = curl_error($ch);
    $obj = json_decode($response);

    if(isset($obj->authToken)) {
        $_SESSION['authToken'] = $obj->authToken;
        $_SESSION['email'] = $obj->email;
        $responseCode = array(2, 'response' => $obj->jsonCode);
    }else{
        $responseCode = array(2, 'response' => $obj->jsonCode, 'message' => $obj->message);
    }
    echo json_encode($responseCode);
    curl_close($ch);
}

if(isset($_POST['merchant'])) {
    $formData = [
        "authToken" => $_SESSION["authToken"],
        "created" => date("Y-m-d"),
        "amount" => $_POST["amount"],
        "merchant" => $_POST["merchant"]
    ];

    //initiate/configure
    $ch = curl_init();
		// set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, $url.'?command=CreateTransaction');
		// 1. Set the CURLOPT_RETURNTRANSFER option to true
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// 2. Set the CURLOPT_POST option to count formData for POST request
    curl_setopt($ch, CURLOPT_POST, 1);
		// 3. Set the request formData as JSON using json_encode function
    curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);

    //response/execute
    $response = curl_exec($ch);
    if ($response === false)
        $response = curl_error($ch);
    $obj = json_decode($response);
    if(isset($obj->jsonCode)) {
        $responseCode = array(1, 'response' => $obj->jsonCode);
        echo json_encode($responseCode);
    }
    curl_close($ch);
}
?>
