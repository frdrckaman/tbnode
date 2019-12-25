<?php
require_once'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$countries=null;$checkError=false;
if($user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Input::get('add_staff')) {
            $validate = new validate();
            $validate = $validate->check($_POST, array(
                'firstname' => array(
                    'required' => true,
                    'min' => 3,
                ),
                'lastname' => array(
                    'required' => true,
                    'min' => 3,
                ),
                'country_id' => array(
                    'required' => true,
                ),
                'position' => array(
                    'required' => true,
                ),
                'username' => array(
                    'required' => true,
                    'unique' => 'staff'
                ),
                'phone_number' => array(
                    'unique' => 'staff'
                ),
                'email_address' => array(
                    'required' => true,
                    'unique' => 'staff'
                ),
            ));
            if ($validate->passed()) {
                $salt = $random->get_rand_alphanumeric(32);
                $password = $random->get_rand_alphanumeric(8);
                switch (Input::get('position')) {
                    case 'Principle Investigator':
                        $accessLevel = 1;
                        break;
                    case 'Coordinator':
                        $accessLevel = 2;
                        break;
                    case 'Data Manager':
                        $accessLevel = 3;
                        break;
                    case 'Country Coordinator':
                        $accessLevel = 4;
                        break;
                    case 'Country PI':
                        $accessLevel = 4;
                        break;
                    case 'Country Data Manager':
                        $accessLevel = 5;
                        break;
                    case 'Data Clark':
                        $accessLevel = 6;
                        break;
                }
                try {
                    $user->createRecord('staff', array(
                        'firstname' => Input::get('firstname'),
                        'lastname' => Input::get('lastname'),
                        'position' => Input::get('position'),
                        'username' => Input::get('username'),
                        'password' => Hash::make($password,$salt),
                        'salt' => $salt,
                        'reg_date' => date('Y-m-d'),
                        'access_level' => $accessLevel,
                        'phone_number' => Input::get('phone_number'),
                        'email_address' => Input::get('email_address'),
                        'c_id' => Input::get('country_id'),
                        's_id' => 0,
                        'status' => 1,
                        'pswd' => 0,
                        'last_login'=>'',
                        'picture'=>'',
                        'token' =>'',
                        'power'=>0,
                        'count'=>0,
                        'staff_id'=>$user->data()->id
                    ));
                    if($email->sendEmail(Input::get('email_address'),Input::get('lastname'),Input::get('username'),$password,'TB-NODE DMS ACCOUNT')){
                        $successMessage = 'Staff Registered Successful' ;
                    }

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        }
        elseif (Input::get('add_country')) {
            $validate = new validate();
            $validate = $validate->check($_POST, array(
                'country_name' => array(
                    'required' => true,
                ),
                'short_code' => array(
                    'required' => true,
                    'min' => 2,
                )
            ));
            if ($validate->passed()) {
                try {
                    $user->createRecord('country', array(
                        'name' => Input::get('country_name'),
                        'short_code' => Input::get('short_code'),
                        'status' => 1
                    ));
                    $successMessage = 'Country Registered Successful';

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        }
        elseif (Input::get('suggestion')) {
            $validate = new validate();
            $validate = $validate->check($_POST, array(
                'subject' => array(
                    'required' => true,
                ),
                'message' => array(
                    'required' => true,
                    'min' => 10,
                )
            ));
            if ($validate->passed()) {
                try {
                    $user->createRecord('suggestion', array(
                        'subject' => Input::get('subject'),
                        'message' => Input::get('message'),
                        's_date' => date('Y-m-d'),
                        'staff_id' => $user->data()->id
                    ));
                    $successMessage = 'Suggestion Received Successful';

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        }
        elseif (Input::get('pswd')) {
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
                try {
                    $user->update(array(
                        'pswd' => 1,
                        'password' => Hash::make(Input::get('new_password'), $salt),
                        'salt' => $salt
                    ));
                } catch (Exception $e) {
                }
                $successMessage = 'Password changed successfully';
            } else {
                $pageError = $validate->errors();
            }
        }
    }
    
}else{
    Redirect::to('index.php');
}
?>
<nav class="navbar brb" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-reorder"></span>
        </button>
        <a class="navbar-brand" href="index.php"><img src="img/userLg.png" class="img-thumbnail img-circle"/></a>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li class="active">
                <a href="index.php">
                    <span class="icon-home"></span> dashboard
                </a>
            </li>

                <li class="dropdown active">
                    <?php if($user->data()->access_level == 1){
                        $cdata=$override->get('country','status',1);
                    }elseif ($user->data()->access_level == 6){
                        $cdata=$override->getNews('country','status',1,'id',$user->data()->c_id);
                    }?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-globe"></span> Data</a>
                    <ul class="dropdown-menu">
                        <?php foreach($cdata as $country){?>
                            <li>
                                <a href="country.php?id=<?=$country['id']?>"><?=$country['name']?><i class="icon-angle-right pull-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="info.php?id=3&c=<?=$country['id']?>">PREVALENCE SURVEY</a></li>
                                    <li><a href="info.php?id=5&c=<?=$country['id']?>">CLUSTER PREVALENCE</a></li>
                                    <li><a href="info.php?id=6&c=<?=$country['id']?>">ROUTINE DATA</a></li>
                                </ul>
                            </li>
                        <?php }?>
                    </ul>
                </li>
            <?php if($user->data()->access_level == 1 ){?>
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-group"></span> STAFF</a>
                    <ul class="dropdown-menu">
                        <li><a href="#add_staff" data-toggle="modal" data-backdrop="static" data-keyboard="false">ADD STAFF</a></li>
                        <li><a href="info.php?id=1">MANAGE STAFF</a></li>
                    </ul>
                </li>
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-gear"></span> MANAGEMENT</a>
                    <ul class="dropdown-menu">
                        <li><a href="#add_country" data-toggle="modal" data-backdrop="static" data-keyboard="false">ADD COUNTRY</a></li>
                        <li><a href="info.php?id=2">MANAGE COUNTRIES</a></li>
                    </ul>
                </li>
            <?php }?>
            <li class="">
                <a href="profile.php">
                    <span class="icon-user"></span> Profile
                </a>
            </li>
        </ul>
        <form class="navbar-form navbar-right" role="search" method="get">
            <div class="form-group">
                <input type="text" name="exit_tb_crf_id" class="form-control" placeholder="search..."/>
            </div>
        </form>
    </div>
</nav>
<div class="modal" id="add_staff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">NEW STAFF</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="controls">
                        <div class="form-row">
                            <div class="col-md-2">First Name:</div>
                            <div class="col-md-10">
                                <input type="text" name="firstname" class="form-control" value="" required=""/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">Last Name:</div>
                            <div class="col-md-10">
                                <input type="text" name="lastname" class="form-control" value="" required=""/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">Country:</div>
                            <div class="col-md-10">
                                <select class="form-control" id="country" name="country_id" required="">
                                    <option value="">Select Country</option>
                                    <?php if($user->data()->access_level == 1 || $user->data()->access_level == 2 || $user->data()->access_level == 3){
                                        $countries=$override->get('country','status',1);
                                    }elseif($user->data()->access_level == 4){
                                        $countries=$override->getNews('country','id',$user->data()->c_id,'status',1);}
                                    foreach($countries as $country){?>
                                        <option value="<?=$country['id']?>"><?=$country['name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-2">Position:</div>
                            <div class="col-md-10">
                                <select class="form-control" name="position" required="">
                                    <!-- you need to properly manage positions -->
                                    <option value="">Select Position</option>
                                    <?php foreach($override->getData('position') as $position){if($user->data()->access_level == 1 && $user->data()->power == 1){?>
                                        <option value="<?=$position['name']?>"><?=$position['name']?></option>
                                    <?php }elseif($user->data()->access_level == 1 && $position['name'] != 'Principle Investigator' && $position['name'] != 'Coordinator' && $position['name'] !='Data Manager' && $position['name'] !='Country Coordinator' && $position['name'] !='Country Data Manager'){?>
                                        <option value="<?=$position['name']?>"><?=$position['name']?></option>
                                    <?php }}?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">Username:</div>
                            <div class="col-md-10">
                                <input type="text" name="username" class="form-control" value="" required=""/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">Phone:</div>
                            <div class="col-md-10">
                                <input type="text" name="phone_number" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">Email:</div>
                            <div class="col-md-10">
                                <input type="text" name="email_address" class="form-control" value="" required=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right col-md-3">
                        <input type="submit" name="add_staff" value="ADD" class="btn btn-success btn-clean">
                    </div>
                    <div class="pull-right col-md-2">
                        <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="add_country" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">ADD COUNTRY</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="controls">
                        <div class="form-row">
                            <div class="col-md-2">Name:</div>
                            <div class="col-md-10">
                                <input type="text" name="country_name" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">Short Code:</div>
                            <div class="col-md-10">
                                <input type="text" name="short_code" class="form-control" value="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right col-md-3">
                        <input type="submit" name="add_country" value="ADD" class="btn btn-success btn-clean">
                    </div>
                    <div class="pull-right col-md-2">
                        <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="suggestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">SUGGESTIONS</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="controls">
                        <div class="form-row">
                            <div class="col-md-12">
                                <input type="text" name="subject" class="form-control" value="" placeholder="Enter Subject" required=""/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <textarea class="form-control" name="message" placeholder="Your Suggestions" ROWS="8" required=""></textarea>
                            </div>
                        </div>
                        <label class="col-md-12"></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right col-md-3">
                        <input type="submit" name="suggestion" value="Submit" class="btn btn-success btn-clean">
                    </div>
                    <div class="pull-right col-md-2">
                        <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="change_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #cc8c18;font-weight: bolder;">YOU HAVE LOGIN FOR THE FIRST TIME, YOUR REQUIRED TO CHANGE YOUR PASSWORD</h4>
                </div>
                <div class="modal-body clearfix">
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
                    <?php }?>
                    <div class="controls">
                        <div class="form-row">
                            <div class="col-md-12">
                                <input type="password" name="new_password" class="form-control" value="" placeholder="Enter New Password" required=""/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <input type="password" name="re_password" class="form-control" value="" placeholder="Re-type Password" required=""/>
                            </div>
                        </div>
                        <label class="col-md-12"></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right col-md-3">
                        <input type="submit" name="pswd" value="Submit" class="btn btn-success btn-clean">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#country').change(function(){
            var site = $(this).val();
            $('#s').hide();
            $('#waitS').show();
            $.ajax({
                url:"process.php?content=site",
                method:"GET",
                data:{site:site},
                dataType:"text",
                success:function(data){
                    $('#site').html(data);
                    $('#s').show();
                    $('#waitS').hide();
                }
            });
        });
        $('#crf').change(function(){
            var page = $(this).val();
            $('#p').hide();
            $('#waitP').show();
            $.ajax({
                url:"process.php?content=pages",
                method:"GET",
                data:{page:page},
                dataType:"text",
                success:function(data){
                    $('#pg').html(data);
                    $('#p').show();
                    $('#waitP').hide();
                }
            });
        });
        $('#crfB').change(function(){
            var page = $(this).val();
            $('#b').hide();
            $('#waitB').show();
            $.ajax({
                url:"process.php?content=pages",
                method:"GET",
                data:{page:page},
                dataType:"text",
                success:function(data){
                    $('#pgN').html(data);
                    $('#b').show();
                    $('#waitB').hide();
                }
            });
        });
    });
</script>