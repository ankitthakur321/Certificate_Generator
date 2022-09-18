<?php

session_start();
include('includes/db.php');

use Phppot\DataSource;
require_once 'includes/DataSource.php';

if(isset($_POST['LoginBtn']))
{
	$usrnm = $_POST['usr'];
	$pass = $_POST['pass'];
	$query = "SELECT * FROM admin_details WHERE `username` = '$usrnm' AND `password` = '$pass'";
	$query_run= mysqli_query($conn, $query);
	if(mysqli_num_rows($query_run) > 0)
    {
		$_SESSION['login'] = "Successful";
		$_SESSION['usrnm'] = $usrnm;
		header('Location: dashboard.php');
	}
	else
	{
        $_SESSION['status'] = "Invalid Credentials";
		header('Location: index.php');
	}
}
else if(isset($_POST['AddWebinarBtn']))
{
	$name = $_POST['Name'];
	$orgnr_name = $_POST['OrganizerName'];
	$dated = $_POST['Dated'];
    $newDate = date('d-m-Y',strtotime($dated));
    $event_type = $_POST['EventType'];

	$query = "INSERT INTO event_details(`w_id`, `name`, `organizer_name`, `dated`, `event_type`) VALUES(null, '$name', '$orgnr_name', '$newDate','$event_type')";
	$query_run= mysqli_query($conn, $query);
	if($query_run)
	{
		$_SESSION['success'] = "Event Added Successfully";
		header('Location: pages/events/add_event.php');

	}
	else
	{
		$_SESSION['status'] = "Event Not Added Successfully";
		header('Location: pages/events/add_event.php');
	}

}
else if(isset($_POST['GenerateCertificateBtn']))
{
	$wname = $_POST['web_name'];
    $query = "SELECT * FROM feedback WHERE mail_sent = 0 AND event_name = '$wname' ORDER BY f_id DESC LIMIT 10";                   // Creating MySQL Query
    $query_run = mysqli_query($conn, $query);                                // Running MySQL Query
    if(mysqli_num_rows($query_run) > 0)
    {

        require('includes/fpdf.php');                                                 // Including fpdf.php file to create the PDF
        $query1 = "SELECT * FROM event_details WHERE name = '$wname'";                   // Creating MySQL Query
   		$query_run1 = mysqli_query($conn, $query1);
		$row1 = mysqli_fetch_assoc($query_run1);
        require 'includes/PHPMailerAutoload.php';                                     // Including PHPMailerAutoload.php file to send mail to the participants
        $pdf = new FPDF('L','pt','Legal');

        while($row=mysqli_fetch_assoc($query_run))                           //Fetching Data from Database
        {

            $f_id = $row['f_id'];
            if($f_id <= 9){
                $fid = '0'.$row['f_id'];
            }
            else{
                $fid = $row['f_id'];
            }
            $wbnr = $row['event_name'];
            $name = $row['name'];
            $organisation = $row['organisation'];
            $dte1 = $row1['dated'];
            $dte2 = ' and XX-XX-2021';
            $dte = $dte1.$dte2;
            $eml = $row['email_id'];
            $event_type = $row1['event_type'];
            
            $font = __DIR__."/includes/fonts/timesbi.ttf";
            $font2 = __DIR__."/includes/fonts/cambriab.ttf";
            $image = imagecreatefromjpeg("Certificate.jpg");
            $color = imagecolorallocate($image, 19,21,22);
            imagettftext($image,12,0,873,57,$color,$font2,$fid);           //Placing The right Coordinates for Id of Cerificate

            if(strlen($name)<=5){                                           //Placing The right Coordinates for name and designation of participants
                imagettftext($image,15,0,460,290,$color,$font,$name);
            }
            else if(strlen($name)>5 && strlen($name)<=9){
                imagettftext($image,15,0,445,290,$color,$font,$name); 
            }
            else if(strlen($name)>9 && strlen($name)<=11){
                imagettftext($image,15,0,435,290,$color,$font,$name);
            }
            else if(strlen($name)>11 && strlen($name)<=15){
                imagettftext($image,15,0,410,290,$color,$font,$name);
            }
            else if(strlen($name)>15 && strlen($name)<=20){
                imagettftext($image,15,0,390,290,$color,$font,$name);
            }
            else if(strlen($name)>20 && strlen($name)<=30){
                imagettftext($image,15,0,360,290,$color,$font,$name);
            }

            if(strlen($organisation)>5 && strlen($organisation)<=10){                       //Placing The right Coordinates for name of webinar
                imagettftext($image,15,0,430,340,$color,$font,$organisation);
            }
            else if(strlen($organisation)>10 && strlen($organisation)<=20){
                imagettftext($image,15,0,380,340,$color,$font,$organisation);
            }
            else if(strlen($organisation)>20 && strlen($organisation)<=30){
                imagettftext($image,15,0,330,340,$color,$font,$organisation);
            }
            else if(strlen($organisation)>30 && strlen($organisation)<=40){
                imagettftext($image,15,0,300,340,$color,$font,$organisation);
            }
            else if(strlen($organisation)>=41){
                imagettftext($image,15,0,290,340,$color,$font,$organisation);
            }
            
            imagettftext($image,15,0,415,363,$color,$font,$event_type);       //Placing The right Coordinates for event type

            
                                 
            if(strlen($wbnr)>4 && strlen($wbnr)<=10){                       //Placing The right Coordinates for name of webinar
                imagettftext($image,14,0,450,408,$color,$font,$wbnr);
            }
            else if(strlen($wbnr)>10 && strlen($wbnr)<=20){
                imagettftext($image,14,0,380,408,$color,$font,$wbnr);
            }
            else if(strlen($wbnr)>20 && strlen($wbnr)<=30){
                imagettftext($image,14,0,330,408,$color,$font,$wbnr);
            }
            else if(strlen($wbnr)>30 && strlen($wbnr)<=40){
                imagettftext($image,14,0,300,408,$color,$font,$wbnr);
            }
            else if(strlen($wbnr)>41 && strlen($wbnr)<=50){
                imagettftext($image,14,0,290,408,$color,$font,$wbnr);
            }

            imagettftext($image,14,0,455,429,$color,$font,$dte1);            //Placing The right Coordinates for date of webinar
            $file_name = "Certificate_".$name."(".$dte1.")";
            $file_path = "Certificates/".$file_name.'.jpg';
            $file_path_pdf = "Certificates/".$file_name.'.pdf';
            imagejpeg($image,$file_path);
            imagedestroy($image);
            
            $pdf = new FPDF('L','pt','Legal');
            $pdf->AddPage();
            $pdf->Image($file_path,0,0,1009,610);
            $pdf->Output($file_path_pdf,"F");
            $pdf = null;

            

            $mail = new PHPMailer;

            //$mail->SMTPDebug = 3;                                          // Enabling debug output
            $mail->isSMTP();                                                 // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                                  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                          // Enable SMTP authentication
            $mail->Username = 'ism.certificate@ismpatna.ac.in';                    // SMTP username
            $mail->Password = 'rzggmhokddgklogd';                              // SMTP password
            $mail->SMTPSecure = 'tls';                                       // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                               // TCP port to connect to

            $mail->setFrom('ism.certificate@ismpatna.ac.in', 'ISM Patna');  // Add sending Mail Address
            $mail->addAddress($eml, $name);                                  // Add a recipient
            $mail->addReplyTo('ism.certificate@ismpatna.ac.in', 'ISM Patna');

            $mail->addAttachment($file_path_pdf);                            // Attaching a file
            $mail->isHTML(true);                                             // Set email format to HTML

            $mail->Subject = 'Certificate of Participation';                                    // Set Subject
            $mail->Body    = 'Hello <b>'.$name.'</b>,<br/>Thank You for joining the '.$event_type.' on '.$wbnr.'<br>Your Participation Certificate has been generated. Please find below attachment.<br /><br /> Thank You,<br/>ISM PATNA';    //Set Message                           

            if(!$mail->send()) {                                             // Sending Mail
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
            $mail = null;
            $query2 = "UPDATE `feedback` SET `mail_sent` = '1' WHERE `feedback`.`f_id` =".$row['f_id'];
            $query_run2 = mysqli_query($conn, $query2);
        } 
		$_SESSION['prtcpts'] = "Next";
        echo "<script>
				alert('Certificates has been generated for all the selected participants');
				window.location.href='pages/participants/view_webinar_list.php';
			  </script>";
    }
    else
    {
		$_SESSION['cmpltd'] = "Completed";
        echo "<script>
				alert('No Certificates Left to Generate');
				window.location.href='pages/participants/view_webinar_list.php';
			  </script>";
    }

}
else if (isset($_POST['importBtn'])) {

    
    $db = new DataSource();
    $con = $db->getConnection();
    
    $fileName = $_FILES["upload"]["tmp_name"];
    
    if ($_FILES["upload"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            $fId = "";
            if (isset($column[0])) {
                $fId = mysqli_real_escape_string($con, $column[0]);
            }
            $name = "";
            if (isset($column[1])) {
                $name = mysqli_real_escape_string($con, $column[1]);
            }
            $organisation = "";
            if (isset($column[2])) {
                $organisation = mysqli_real_escape_string($con, $column[2]);
            }
            $emailId = "";
            if (isset($column[3])) {
                $emailId = mysqli_real_escape_string($con, $column[3]);
            }
            $eventName = "";
            if (isset($column[4])) {
                $eventName = mysqli_real_escape_string($con, $column[4]);
            }
            $mailSent = "";
            if (isset($column[5])) {
                $mailSent = mysqli_real_escape_string($con, $column[5]);
            }            
            $sqlInsert = "INSERT into feedback (f_id,name,organisation,email_id,event_name,mail_sent)
                   values (?,?,?,?,?,?)";
            $paramType = "issssi";
            $paramArray = array(
                $fId,
                $name,
                $organisation,
                $emailId,
                $eventName,
                $mailSent
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
        }
        
            
            if (! empty($insertId)) {
                $_SESSION['success'] = "File Imported Successfully";
                header('Location: pages/participants/view_participants.php');
                
            } else {
                $_SESSION['status'] = "File Not Imported Successfully";
                header('Location: pages/participants/view_participants.php');
            }
    }
}
else if (isset($_POST['importQuizPrtcptBtn'])) {

    
    $db = new DataSource();
    $con = $db->getConnection();
    
    $fileName = $_FILES["upload"]["tmp_name"];
    
    if ($_FILES["upload"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            $pId = "";
            if (isset($column[0])) {
                $pId = mysqli_real_escape_string($con, $column[0]);
            }
            $name = "";
            if (isset($column[1])) {
                $name = mysqli_real_escape_string($con, $column[1]);
            }
            $course = "";
            if (isset($column[2])) {
                $course = mysqli_real_escape_string($con, $column[2]);
            }
            $semester = "";
            if (isset($column[3])) {
                $semester = mysqli_real_escape_string($con, $column[3]);
            }
            $section = "";
            if (isset($column[4])) {
                $section = mysqli_real_escape_string($con, $column[4]);
            }
            $emailId = "";
            if (isset($column[5])) {
                $emailId = mysqli_real_escape_string($con, $column[5]);
            }
            $quizName = "";
            if (isset($column[6])) {
                $quizName = mysqli_real_escape_string($con, $column[6]);
            }
            $mailSent = "";
            if (isset($column[7])) {
                $mailSent = mysqli_real_escape_string($con, $column[7]);
            }            
            $sqlInsert = "INSERT into feedback (p_id,name,course, semester, section, email_id, quiz_name, mail_sent)
                   values (?,?,?,?,?,?,?,?)";
            $paramType = "issssi";
            $paramArray = array(
                $fsId,
                $name,
                $course,
                $semester,
                $section,
                $emailId,
                $quizName,
                $mailSent
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
        }
        
            
            if (! empty($insertId)) {
                $_SESSION['success'] = "File Imported Successfully";
                header('Location: pages/quiz/view_quiz_participants.php');
                
            } else {
                $_SESSION['status'] = "File Not Imported Successfully";
                header('Location: pages/quiz/view_quiz_participants.php');
            }
    }
}
else if(isset($_POST['GenerateQuizCertificateBtn']))
{
	$qname = $_POST['quiz_name'];
    $query = "SELECT * FROM quiz WHERE mail_sent = 0 AND quiz_name = '$qname' ORDER BY p_id DESC LIMIT 10";                   // Creating MySQL Query
    $query_run = mysqli_query($conn, $query);                                // Running MySQL Query
    if(mysqli_num_rows($query_run) > 0)
    {

        require('includes/fpdf.php');                                                 // Including fpdf.php file to create the PDF
        $query1 = "SELECT * FROM event_details WHERE name = '$qname'";                   // Creating MySQL Query
   		$query_run1 = mysqli_query($conn, $query1);
		$row1 = mysqli_fetch_assoc($query_run1);
        require 'includes/PHPMailerAutoload.php';                                     // Including PHPMailerAutoload.php file to send mail to the participants
        $pdf = new FPDF('L','pt','Legal');

        while($row=mysqli_fetch_assoc($query_run))                           //Fetching Data from Database
        {

            $p_id = $row['p_id'];
            $quiznm = $row['quiz_name'];
            $name = $row['name'];
            $course = $row['course'];
            $semester = $row['semester'];
            $dte = $row1['dated'];
            $eml = $row['email_id'];
            $event_type = $row1['event_type'];
            
            $font = __DIR__."/includes/fonts/timesbi.ttf";
            $font2 = __DIR__."/includes/fonts/cambriab.ttf";
            $image = imagecreatefromjpeg("Certificate.jpg");
            $color = imagecolorallocate($image, 19,21,22);
            imagettftext($image,12,0,873,57,$color,$font2,$p_id);           //Placing The right Coordinates for Id of Cerificate

            if(strlen($name)<=5){                                           //Placing The right Coordinates for name and designation of participants
                imagettftext($image,15,0,460,290,$color,$font,$name);
            }
            else if(strlen($name)>5 && strlen($name)<=9){
                imagettftext($image,15,0,445,290,$color,$font,$name); 
            }
            else if(strlen($name)>9 && strlen($name)<=11){
                imagettftext($image,15,0,435,290,$color,$font,$name);
            }
            else if(strlen($name)>11 && strlen($name)<=15){
                imagettftext($image,15,0,410,290,$color,$font,$name);
            }
            else if(strlen($name)>15 && strlen($name)<=20){
                imagettftext($image,15,0,390,290,$color,$font,$name);
            }
            else if(strlen($name)>20 && strlen($name)<=30){
                imagettftext($image,15,0,360,290,$color,$font,$name);
            }

            if(strlen($course)>5 && strlen($course)<=10){                       //Placing The right Coordinates for name of webinar
                imagettftext($image,15,0,430,340,$color,$font,$course);
            }
            else if(strlen($course)>10 && strlen($course)<=20){
                imagettftext($image,15,0,380,340,$color,$font,$course);
            }
            else if(strlen($course)>20 && strlen($course)<=30){
                imagettftext($image,15,0,330,340,$color,$font,$course);
            }
            else if(strlen($course)>30 && strlen($course)<=40){
                imagettftext($image,15,0,300,340,$color,$font,$course);
            }
            else if(strlen($course)>=41){
                imagettftext($image,15,0,290,340,$color,$font,$course);
            }
            
            imagettftext($image,15,0,405,364,$color,$font,$event_type);       //Placing The right Coordinates for event type

            
                                 
            if(strlen($quiznm)>4 && strlen($quiznm)<=10){                       //Placing The right Coordinates for name of webinar
                imagettftext($image,15,0,450,410,$color,$font,$quiznm);
            }
            else if(strlen($quiznm)>10 && strlen($quiznm)<=20){
                imagettftext($image,15,0,380,410,$color,$font,$quiznm);
            }
            else if(strlen($quiznm)>20 && strlen($quiznm)<=30){
                imagettftext($image,15,0,330,410,$color,$font,$quiznm);
            }
            else if(strlen($quiznm)>30 && strlen($quiznm)<=40){
                imagettftext($image,15,0,300,410,$color,$font,$quiznm);
            }
            else if(strlen($quiznm)>41 && strlen($quiznm)<=50){
                imagettftext($image,15,0,260,410,$color,$font,$quiznm);
            }

            imagettftext($image,15,0,470,438,$color,$font,$dte);            //Placing The right Coordinates for date of webinar
            $file_name = "Certificate_".$name."(".$dte.")";
            $file_path = "Certificates/".$file_name.'.jpg';
            $file_path_pdf = "Certificates/".$file_name.'.pdf';
            imagejpeg($image,$file_path);
            imagedestroy($image);
            
            /*$pdf = new FPDF('L','pt','Legal');
            $pdf->AddPage();
            $pdf->Image($file_path,0,0,1009,610);
            $pdf->Output($file_path_pdf,"F");
            $pdf = null;

            

            $mail = new PHPMailer;

            //$mail->SMTPDebug = 3;                                          // Enabling debug output
            $mail->isSMTP();                                                 // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                                  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                          // Enable SMTP authentication
            $mail->Username = 'ism.certificate@ismpatna.ac.in';                    // SMTP username
            $mail->Password = 'rzggmhokddgklogd';                              // SMTP password
            $mail->SMTPSecure = 'tls';                                       // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                               // TCP port to connect to

            $mail->setFrom('ism.certificate@ismpatna.ac.in', 'ISM Patna');  // Add sending Mail Address
            $mail->addAddress($eml, $name);                                  // Add a recipient
            $mail->addReplyTo('ism.certificate@ismpatna.ac.in', 'ISM Patna');

            $mail->addAttachment($file_path_pdf);                            // Attaching a file
            $mail->isHTML(true);                                             // Set email format to HTML

            $mail->Subject = 'Certificate of Participation';                                    // Set Subject
            $mail->Body    = 'Hello <b>'.$name.'</b>,<br/>Thank You for joining the '.$event_type.' on '.$wbnr.'<br>Your Participation Certificate has been generated. Please find below attachment.<br /><br /> Thank You,<br/>ISM PATNA';    //Set Message                           

            if(!$mail->send()) {                                             // Sending Mail
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
            $mail = null;*/
            $query2 = "UPDATE `quiz` SET `mail_sent` = '1' WHERE `feedback`.`f_id` =".$row['f_id'];
            $query_run2 = mysqli_query($conn, $query2);
        } 
		$_SESSION['prtcpts'] = "Next";
        echo "<script>
				alert('Certificates has been generated for all the selected participants');
				window.location.href='pages/participants/view_webinar_list.php';
			  </script>";
    }
    else
    {
		$_SESSION['cmpltd'] = "Completed";
        echo "<script>
				alert('No Certificates Left to Generate');
				window.location.href='pages/participants/view_webinar_list.php';
			  </script>";
    }

}


?>











function addNewGallery()
    {
        $hId = $this->input->post('hId');
        
        //AddHotelModel Called
        $this->load->model('AddHotelModel');
        
        $hotelData = $this->AddHotelModel->getFullHotelData($hId);
        if(count($_FILES['propertyGallery']['name']) > 0){
            $response = $this->AddHotelModel->saveGallery($hId);
            if($response==true)
            {
                //Adding Activity in Activity Table
                $this->load->model('AdminActivityModel');
        	    $actvt['admin_id'] = $this->session->userdata('userid');;
                $actvt['activity_performed'] = "Added new images to the Gallery of Hotel ".$hotelData['0']['hotel_name']."(Address - ".$this->input->post('propertyAddress').").";
                $actvty=$this->AdminActivityModel->addActivity($actvt);
                
                $msg = array('message' => 'Gallery Added Successfully','class' => 'alert alert-success');
                $this->session->set_flashdata('status',$msg);
                return redirect('hotels/listView');
            }
        }
        else{
            return redirect('hotels/addGallery/'.$hId);
        }
    }