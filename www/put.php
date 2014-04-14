<?php
    
    header("Status: 200");
    
	//get variables
	
	// Configuration
	$dbhost = 'localhost';
	$dbname = 'test';

	// Connect to test database
	$m = new Mongo("mongodb://$dbhost");
	$db = $m->$dbname;

	// Get the users collection
	$c_users = $db->users;
	
	require("sendgrid-php.php");
	
    $to = $_POST["to"];
    $from = $_POST["from"];
    $body = $_POST["text"];
    $subject = $_POST["subject"];
    $num_attachments = $_POST["attachments"];
    
    
    if(strtolower($subject) == "set me up"){
        $bossarray=array("name"=>$from);
        $c_users->insert($bossarray);
        $x = $bossarray['_id'];
        $sendgrid = new SendGrid('[USERNAME]', '[PASSWORD]');
        
        
        $mail = new SendGrid\Email();
        $mail->addTo(json_decode($_POST['envelope'])->{'from'})->
       setFrom("support@e2d.bymail.in")->
       setSubject('Verification code')->
       setText('Hello, please paste this verification code somewhere in the body of any deploy emails: ' . $x . ' This is your 5 character access code:' . substr(md5($x),0,5) . ' Click on the "My Files" tab on (domainname) to access your website files.')->
       //setHtml('<h1>Welcome to Email2Deploy</h1><p>Please paste this verification code somewhere in the body of any deploy emails:</p><blockquote>' . $x . '</blockquote><p>This is your 5 character access code:</p><blockquote>' . substr(md5($x),0,5) . '</blockquote><p>Click on the "My Files" tab on (domainname) to access your website files.</p>');
        setHtml('<table style="border: none; width: 100%; font-family: Arial; vertical-align: middle; text-align: center; background: white;">
	<tbody>
	<tr style="background:#3C8E77; height: 150px;"><td>
		<h1 style="color: white; line-height: 1em;">Welcome to Email2Deploy</h1>
	</td></tr>
	<tr style="height: 4em;"><td>
		<p>Please paste this verification code somewhere in the body of any deploy emails:</p>
	</td></tr>
	<tr style="height: 3em;"><td>
		<code style="font-family: monospace; font-size: 120%; background: lightGray; border-radius: 4px; padding: 6px; border: 1px solid gray;">' . $x . '</code>
	</td></tr>
	<tr style="height: 3em;"><td>
		<p>This is your 5 character access code:</p>
	</td></tr>
	<tr style="height: 3em;"><td>
		<code style="font-family: monospace; font-size: 120%; background: lightGray; border-radius: 4px; padding: 6px; border: 1px solid gray;">' . substr(md5($x),0,5) . '</code>
	</td></tr>
	<tr style="height: 4em;"><td>
		<p>Enter your 5 character access code on epush.net to access your website</p>
	</td></tr>
		<tr style="height: 5em;"><td>
		<a href="epush.net" style="line-height: 5em; display: block; background: #F9D980; color: black; font-weight: bold;">Click here to open EPush</a>
	</td></tr>
	</tbody>
</table>');
        
        
        $sendgrid->send($mail);
        
        if (!file_exists ( "./uploads/" . substr(md5($x),0,5) . "/" )) {
                        mkdir ("./uploads/" . substr(md5($x),0,5) . "/", 0744);
			}
        
        
        
    }else{
        $coll = $c_users->findOne(array("name"=>$from));
        if($coll !== null){
            $x = (string)$coll["_id"];
            if(strpos($body,$x) !== null){
                
                $body = explode(" ",$body)[1];
                
                if(strtolower($subject) == "git"){
                    
                    $loc = preg_replace('/[\r\n]+/', ' ', trim($body)) . "/archive/master.zip";
                    
                    if(file_put_contents("./uploads/" . substr(md5($x),0,5) . "/master.zip",file_get_contents($loc))){
                        $r = rand(0, 1000);
                        $zip = new ZipArchive;
                        $res = $zip->open("./uploads/" . substr(md5($x),0,5) . "/master.zip");
                        if ($res === TRUE) {
                            $zip->extractTo("./uploads/" . substr(md5($x),0,5) . "/");
                            $zip->close();
                        }else{
                                file_put_contents("./uploads/" . substr(md5($x),0,5) . "/unabletounzip.txt","There was an error cloning your repo.  Please make sure it was a valid url: " . $loc);
                        }
                    }else{
                            file_put_contents("./uploads/" . substr(md5($x),0,5) . "/unabletounzip.txt","There was an error cloning your repo.  Please make sure it was a valid url: " . $loc);
                    }
                    
                }
                
                if($num_attachments){
                    $uploadName = "attachment1";
                    $x = substr(md5($x),0,5);
                    for($i=0;$i<$num_attachments;$i++){
			if (!file_exists ( "./uploads/" . $x . "/" )) {
                        mkdir ("./uploads/" . $x . "/", 0744);
			}
			move_uploaded_file($_FILES[$uploadName] ['tmp_name'],"./uploads/" . $x . "/{$_FILES[$uploadName] ['name']}");
			            if(substr($_FILES[$uploadName] ['name'],strlen($_FILES[$uploadName] ['name'])-4,4) == ".zip"){
			                $zip = new ZipArchive;
                            $res = $zip->open("./uploads/" . $x . "/" . $_FILES[$uploadName] ['name']);
                            if ($res === TRUE) {
                                if (!file_exists ( "./uploads/" . $x . "/" . substr($_FILES[$uploadName] ['name'],0,strlen($_FILES[$uploadName] ['name'])-4) )) {
                                    mkdir ("./uploads/" . $x . "/" . substr($_FILES[$uploadName] ['name'],0,strlen($_FILES[$uploadName] ['name'])-4), 0744);
                                }
                                $zip->extractTo("./uploads/" . $x . "/" . substr($_FILES[$uploadName] ['name'],0,strlen($_FILES[$uploadName] ['name'])-4));
                                $zip->close();
                            }else{
                                file_put_contents("./uploads/" . $x . "/unabletounzip.txt","There was an error unzipping your .zip  Please make sure it was valid and not corrupt.");
                            }
			            }
                        $uploadName++;
                    }
                }else{
                    file_put_contents("uploads/error3.txt","error with attachment");
                }
            }else{
                file_put_contents("uploads/error2.txt","error with indexof");
            }
        }else{
            file_put_contents("uploads/error1.txt","error with coll = " . $coll);
        }
        
    }

    
    
    //STORAGE
    /*
        $url = 'https://api.sendgrid.com/';
$user = 'pwstegman';
$pass = 'spider3621';

$json_string = array(

  'to' => array(
    $from
  ),
  'category' => 'test_category'
);


$params = array(
    'api_user'  => $user,
    'api_key'   => $pass,
    'x-smtpapi' => json_encode($json_string),
    'to'        => $from,
    'subject'   => 'Welcome from Email2Deploy ',
    'html'      => 'Hello, please paste this verification code somewhere in the body of any deploy emails: ' . $x,
    'text'      => 'Hello, please paste this verification code somewhere in the body of any deploy emails: ' . $x,
    'from'      => $to
  );


$request =  $url.'api/mail.send.json';

// Generate curl request
$session = curl_init($request);
// Tell curl to use HTTP POST
curl_setopt ($session, CURLOPT_POST, true);
// Tell curl that this is the body of the POST
curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
// Tell curl not to return headers, but do return the response
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// obtain response
$response = curl_exec($session);
curl_close($session);

// print everything out
print_r($response);
    
    */
    
    
?>
