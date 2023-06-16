<?php
$g_currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$g_website = dirname($g_currentUrl);;
// if anomoz server
if (strpos($g_website, 'projects.anomoz.com') !== false) {
    ini_set('session.cookie_lifetime', 60 * 60 * 24 * 100);
    ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 100);
    ini_set('session.save_path', '/tmp');
}

// Report simple running errors
error_reporting(E_ERROR);
ini_set('display_errors', '1');

session_start();
include_once("database.php");

function runQuery($query){
    global $con;
    $result=$con->query($query);
    if(!$result){
        echo $query."<br>";
        echo $con->error;
        exit();
    }
}

function clear($string){
    global $con;
    return mysqli_real_escape_string($con, $string);
}

function random($length = 10){
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getAll($con,$sql){
    runQuery($sql);
    $result = $con->query($sql);
    $list = array();
    while ($row = mysqli_fetch_assoc($result)){
        $list[] = $row;
    }
    return $list;
}

function getRow($con,$sql){
	runQuery($sql);
	if ($result = $con->query($sql)) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        return false;
    }
}

function sendEmailNotification_mailjet($subject, $message, $email, $containsAttachment=0, $attachments="none"){
    
    
    if($attachments=="none")
        $attachmentArray = [];
    else{
        $content_type = $attachments['ContentType'];
        $file_name = $attachments['Filename'];
        $base_content = $attachments['Base64Content'];
    
        $attachmentArray = [[
                'ContentType' => $content_type,
                'Filename' => $file_name,
                'Base64Content' => $base_content,
                ]
        ];
    }
    
    global $g_projectTitle;
    $ch = curl_init();
    
    $from = "dev.email.sender2@anomoz.com";;
    
   
    if(true){
        $vars = json_encode(array (
  'Messages' => 
  array (
    0 => 
    array (
      'From' => 
      array (
        'Email' => 'hello@anomoz.com',
        'Name' => "Tushant Marketing",
      ),
      'To' => 
      array (
        0 => 
        array (
          'Email' => $email,
          'Name' => 'Receiver',
        ),
      ),
      'Subject' => $subject,
      'TextPart' => $message,
      'HTMLPart' => $message,
      'CustomID' => 'AppGettingStartedTest',


      'Attachments' => $attachmentArray,
    ),
  ),
), true);
    
    }
    
    
    curl_setopt($ch, CURLOPT_URL,"https://api.mailjet.com/v3.1/send");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $headers = [
        'X-Apple-Tz: 0',
        'X-Apple-Store-Front: 143444,12',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding: gzip, deflate',
        'Accept-Language: en-US,en;q=0.5',
        'Cache-Control: no-cache',
        'Content-Type: application/json; charset=utf-8',
        'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
        'X-MicrosoftAjax: Delta=true',
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_USERPWD, "0a297227ed9bd3e7fe0cc8a2b455c1d6:94d2e1d6327833ec4f1129b8c669b7bc");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    
    $server_output = curl_exec ($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close ($ch);
    
    if($httpcode != 200){
        echo $server_output;
        exit();
    }
}



$g_stripeCred = array(
    "private_test_key" => "sk_test_51Gz0OOHQjkfG1DwOmJD0AsqrZDQ6vG6oMb28V0WEjlTsuZQSFS5kqb5rr60BIeOgeqobp7XAK7IsOh4gVsrEyKl700IoFt2lJZ",
    "public_test_key"  => "pk_test_51Gz0OOHQjkfG1DwO9latQvA69lF4SGM6jl1DiHgWI5gkzHvI4XqlMDHDw3kQxHPZEJIZlGxxOBufbdfAPAOjVM1500HcxE0VZ2",
    "productCode" => "prod_HY6uiVaFL6t7rg"
);

?>