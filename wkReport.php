<?php
require_once 'php/core/init.php';
$user = new User();
$email = new Email();
$override = new OverideData();

$tzP=0;$tzC=0;$tzR=0;$keP=0;$keC=0;$keR=0;$ugP=0;$ugC=0;$ugR=0;$etP=0;$etC=0;$etR=0;$suP=0;$suC=0;$suR=0;
$ttlP=0;$ttlC=0;$ttlR=0;$ttlTZ=0;$ttlKE=0;$ttlUG=0;$ttlET=0;$ttlSU=0;$ttl=0;$ttlAl=0;

$tzP = $override->getCount('prevalence_survey','c_id',1);
$keP = $override->getCount('prevalence_survey','c_id',2);
$ugP = $override->getCount('prevalence_survey','c_id',3);
$etP = $override->getCount('prevalence_survey','c_id',4);
$suP = $override->getCount('prevalence_survey','c_id',5);

$ttlP = $tzP + $keP + $ugP + $etP + $suP;

$tzC = $override->getCount('clients_demographic_info','c_id',1);
$keC = $override->getCount('clients_demographic_info','c_id',2);
$ugC = $override->getCount('clients_demographic_info','c_id',3);
$etC = $override->getCount('clients_demographic_info','c_id',4);
$suC = $override->getCount('clients_demographic_info','c_id',5);

$ttlC = $tzC + $keC + $ugC + $etC + $suC;

$tzR = $override->getCount('routine_data','c_id',1);
$keR = $override->getCount('routine_data','c_id',2);
$ugR = $override->getCount('routine_data','c_id',3);
$etR = $override->getCount('routine_data','c_id',4);
$suR = $override->getCount('routine_data','c_id',5);

$ttlR = $tzR + $keR + $ugR + $etR + $suR;

$ttlTZ = $tzP + $tzC + $tzR;
$ttlKE = $keP + $keC + $keR;
$ttlUG = $ugP + $ugC + $ugR;
$ttlET = $etP + $etC + $etR;
$ttlSU = $suP + $suC + $suR;

$ttl = $ttlP + $ttlC + $ttlR;

$ttlAl = $ttlTZ + $ttlKE + $ttlUG + $ttlET + $ttlSU;

$staffs = $override->get('staff','power',1);



use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();

$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                   <html xmlns="http://www.w3.org/1999/xhtml" >
                        <head>
    <!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="stylesheets/email.css" />
    <style type="text/css">
        * { 
	margin:0;
	padding:0;
}
* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

img { 
	max-width: 100%; 
}
.collapse {
	margin:0;
	padding:0;
}
body {
	-webkit-font-smoothing:antialiased; 
	-webkit-text-size-adjust:none; 
	width: 100%!important; 
	height: 100%;
}

a { color: #2BA6CB;}

.btn {
	text-decoration:none;
	color: #FFF;
	background-color: #666;
	padding:10px 16px;
	font-weight:bold;
	margin-right:10px;
	text-align:center;
	cursor:pointer;
	display: inline-block;
}

p.callout {
	padding:15px;
	background-color:#ECF8FF;
	margin-bottom: 15px;
}
.callout a {
	font-weight:bold;
	color: #2BA6CB;
}

table.social {
	background-color: #ebebeb;
	
}
.social .soc-btn {
	padding: 3px 7px;
	font-size:12px;
	margin-bottom:10px;
	text-decoration:none;
	color: #FFF;font-weight:bold;
	display:block;
	text-align:center;
}
a.fb { background-color: #3B5998!important; }
a.tw { background-color: #1daced!important; }
a.gp { background-color: #DB4A39!important; }
a.ms { background-color: #000!important; }

.sidebar .soc-btn { 
	display:block;
	width:100%;
}

table.head-wrap { width: 80%;}

.header.container table td.logo { padding: 15px; }
.header.container table td.label { padding: 15px; padding-left:0px;}

table.body-wrap { width: 100%;}

table.footer-wrap { width: 100%;	clear:both!important;
}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
	font-size:10px;
	font-weight: bold;
	
}

h1,h2,h3,h4,h5,h6 {
font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
}
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

h1 { font-weight:200; font-size: 44px;}
h2 { font-weight:200; font-size: 37px;}
h3 { font-weight:500; font-size: 27px;}
h4 { font-weight:500; font-size: 23px;}
h5 { font-weight:900; font-size: 17px;}
h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

.collapse { margin:0!important;}

p, ul { 
	margin-bottom: 10px; 
	font-weight: normal; 
	font-size:14px; 
	line-height:1.6;
}
p.lead { font-size:17px; }
p.last { margin-bottom:0px;}

ul li {
	margin-left:5px;
	list-style-position: inside;
}

ul.sidebar {
	background:#ebebeb;
	display:block;
	list-style-type: none;
}
ul.sidebar li { display: block; margin:0;}
ul.sidebar li a {
	text-decoration:none;
	color: #666;
	padding:10px 16px;

	margin-right:10px;

	cursor:pointer;
	border-bottom: 1px solid #777777;
	border-top: 1px solid #FFFFFF;
	display:block;
	margin:0;
}
ul.sidebar li a.last { border-bottom-width:0px;}
ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}

.container {
	display:block!important;
	max-width:600px!important;
	margin:0 auto!important;
	clear:both!important;
}

.content {
	padding:15px;
	max-width:600px;
	margin:0 auto;
	display:block; 
}

.content table { width: 100%; }

.column {
	width: 300px;
	float:left;
}
.column tr td { padding: 15px; }
.column-wrap { 
	padding:0!important; 
	margin:0 auto; 
	max-width:600px!important;
}
.column table { width:100%;}
.social .column {
	width: 280px;
	min-width: 279px;
	float:left;
}

.clear { display: block; clear: both; }

@media only screen and (max-width: 600px) {
	
	a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

	div[class="column"] { width: auto!important; float:none!important;}
	
	table.social div[class="column"] {
		width:auto!important;
	}

}
    </style>
</head>
                        <body bgcolor="#FFFFFF" style="background-color: #cccccc">
                            <!-- BODY -->
                            <table class="body-wrap">
                                 <tr>
                                      <td></td>
                                      <td class="container" bgcolor="#FFFFFF">
                                         <table class="social" width="100%">
                                         <tr>
                                         <td>
                        <!-- column 1 -->
                        <table align="" style="padding: 20px">
                            <tr>
                                <td align="right"><h3 class="collapse" style="font-weight: bolder">TB-NODE DATA REPORT</h3></td>
                            </tr>
                        </table>
                        <!-- /column 1 -->

                        <span class="clear"></span>

                    </td>
                                           </tr>
                                          </table>
                                         <div class="content">
                                             <table>
                                              <tr>
                                                <td>
                            
                           
                       <table>
                                        <tr>
                                            <td>
                                                
                                               
                                                <table border="1" style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th>CRF</th>
                                                            <th>Tanzania</th>
                                                            <th>Kenya</th>
                                                            <th>Uganda</th>
                                                            <th>Ethiopia</th>
                                                            <th>Sudan</th>
                                                            <th>TOTAL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>PREVALENCE SURVEY</td>
                                                            <td>'.$tzP.'</td>
                                                            <td>'.$keP.'</td>
                                                            <td>'.$ugP.'</td>
                                                            <td>'.$etP.'</td>
                                                            <td>'.$suP.'</td>
                                                            <th>'.$ttlP.'</th>
                                                        </tr>
                                                        <tr>
                                                            <td>CLUSTER PREVALENCE</td>
                                                            <td>'.$tzC.'</td>
                                                            <td>'.$keC.'</td>
                                                            <td>'.$ugC.'</td>
                                                            <td>'.$etC.'</td>
                                                            <td>'.$suC.'</td>
                                                            <th>'.$ttlC.'</th>
                                                        </tr> 
                                                        <tr>
                                                            <td>ROUTINE DATA</td>
                                                            <td>'.$tzR.'</td>
                                                            <td>'.$keR.'</td>
                                                            <td>'.$ugR.'</td>
                                                            <td>'.$etR.'</td>
                                                            <td>'.$suR.'</td>
                                                            <th>'.$ttlR.'</th>
                                                        </tr>    
                                                
                                                       
                                                        <tr>
                                                            <th>TOTAL</th>
                                                            <th>'.$ttlTZ.'</th>
                                                            <th>'.$ttlKE.'</th>
                                                            <th>'.$ttlUG.'</th>
                                                            <th>'.$ttlET.'</th>
                                                            <th>'.$ttlSU.'</th>
                                                            <th>'.$ttlAl.'</th>
                                                        </tr>   
                                                    </tbody>
                                                </table>
                        
                            <br><hr><br>
                            <!-- Callout Panel -->
                            <p class="callout">
                                 For more Information, Please Login to your account <a href="http://tbnode.exit-tb.org/">&nbsp;Login Now &raquo;</a>
                            </p><!-- /Callout Panel -->

                            <!-- contact Info -->
                            <table class="social" width="100%">
                                <tr>
                                    <td>
                                     
                                     

                                        <!-- column 2 -->
                                        <table align="right" class="column">
                                            <tr>
                                                <td>
                                                    <p style="font-weight: bolder">Send us an Email : <strong><a href="info@exit-tb.org">info@exit-tb.org</a></strong></p>
                                                </td>
                                            </tr>
                                        </table><!-- /column 2 -->
                                    </td>
                                </tr>
                            </table><!-- /contact Info -->

                            <!---- footer--->
                            <table class="footer-wrap" >
                                <tr>
                                    <td></td>
                                    <td class="container">

                                        <!-- content -->
                                        <div class="content">
                                            <table>
                                                <tr>
                                                    <td align="center">
                                                        <p>
                                                            <a href="#">Terms</a> |
                                                            <a href="#">Privacy</a> |
                                                            <a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div><!-- /content -->

                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                            <!-- end of footer -->
                        </td>
                                              </tr>
                                            </table>
                                         </div><!-- /content -->
                                      </td>

                                </tr>
                            </table><!-- /BODY -->

                        </body>
                    </html>';

//print_r($body);
//print_r($staffs);
$emails = array('frdrckaman@gmail.com','gsmfinanga@yahoo.com','senkorombazi@gmail.com');

//foreach ($staffs as $staff){
    $mail->Host = "smtp.zoho.com";
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = "info@exit-tb.org";
    $mail->Password = "Server@admin1";
    $mail->SMTPSecure = "tls"; //TLS
    $mail->Port = 587; //587
    $mail->addAddress($staff['email_address']);
    $mail->setFrom('info@exit-tb.org','TB-NODE Database');
    $mail->addReplyTo('info@exit-tb.org');
    $mail->addCC('admin@exit-tb.org');
    $mail->addBCC('admin@exit-tb.org');
    $mail->Subject = 'TB-NODE DATA REPORT';
    $mail->isHTML(true);
    $mail->Body = $body;

    if ($mail->send()){
        return true;
    }
    else{
        return 'not sent';
    }
//}