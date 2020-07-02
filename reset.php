<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();$usr=null;
$random = new Random();
$pageError = null;$successMessage = null;$errorM = false;$errorMessage = null;
if($_GET['token']){
    $staff=$override->get('staff','token',$_GET['token']);
    if (Input::exists('post')) {
        if($staff){
            if (Token::check(Input::get('token'))) {
                $validate = new validate();
                $validate = $validate->check($_POST, array(
                    'new_password' => array(
                        'required' => true,
                        'min' => 6,
                    ),
                    're_password' => array(
                        'required' => true,
                        'matches' => 'new_password'
                    )
                ));
                if ($validate->passed()) {
                    $salt = $random->get_rand_alphanumeric(32);
                    $password = Hash::make(Input::get('new_password'), $salt);
                    try {
                        $override->update($password,$salt,1,$staff[0]['id']);
                    } catch (Exception $e) {
                    }
                    $successMessage = 'Password Reset successfully.  ';
                } else {
                    $pageError = $validate->errors();
                }
            }
        }else{
            $errorMessage='Invalid or Expired Token, Please Contact Your Supervisor for Token Reset';
        }
    }
}else{
    Redirect::to('404.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>NIMR</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/ico" href="favicon.ico">
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css">

    <script type='text/javascript' src='js/plugins/jquery/jquery.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery-ui.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery-migrate.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/globalize.js'></script>
    <script type='text/javascript' src='js/plugins/bootstrap/bootstrap.min.js'></script>

    <script type='text/javascript' src='js/plugins/uniform/jquery.uniform.min.js'></script>

    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
</head>
<body class="bg-img-num1">

<div class="container">

    <div class="col-md-offset-4 col-md-4">
        <div class="block block-transparent">
            <div class="head">
                <div class="user">
                    <div class="info user-change">
                        <h2></h2>
                    </div>
                </div>
            </div>
            <?php if($errorMessage){?>
                <div class="block">
                    <div class="alert alert-danger">
                        <b>Error!</b> <?=$errorMessage?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                </div>
            <?php }elseif($pageError){?>
                <div class="block col-md-12">
                    <div class="alert alert-danger">
                        <b>Error!</b> <?php foreach($pageError as $error){echo $error.' , ';}?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                </div>
            <?php }elseif($successMessage){?>
                <div class="block">
                    <div class="alert alert-success">
                        <b>Success!</b> <?=$successMessage?><a href="index.php" class="btn btn-info"><strong>CLICK HERE TO LOGIN</strong></a>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                </div>
            <?php }?>
            <div class="col-md-12">
                <div class="block block-drop-shadow">
                    <div class="head bg-dot20">
                        <h2>RESET PASSWORD</h2>
                        <div class="side pull-right">
                            <ul class="buttons">
                                <li><a href="#"><span class="icon-cogs"></span></a></li>
                            </ul>
                        </div>
                        <div class="head-subtitle"></div>
                        <div class="head-panel nm tac" style="line-height: 0px;">
                            <form method="post">
                                <div class="form-row">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <span class="icon-key"></span>
                                                </div>
                                                <input type="password" name="new_password" class="form-control" placeholder="Enter a new Password" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <span class="icon-key"></span>
                                                </div>
                                                <input type="password" name="re_password" class="form-control" placeholder="Re-type Password" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="token" value="<?=Token::generate();?>">
                                            <input type="submit" value="Reset" class="btn btn-default btn-block btn-clean">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</html>