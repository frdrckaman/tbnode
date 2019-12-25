<?php
require_once'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$rand = new Random();
$pageError = null;$successMessage = null;$errorM = false;$errorMessage = null;
$pageError2 = null;$successMessage2 = null;$errorM = false;$errorMessage2 = null;
$staffs=null;$data=null;
$links=array('site.php','info.php?id=14','info.php?id=13','info.php?id=9','info.php?id=18');
foreach ($links as $link){
    if(basename($_SERVER['REQUEST_URI']) == $link){
        Redirect::to('404.php');
    }
}

if($user->isLoggedIn()) {
    if ($user->data()->access_level == 1) {
        if (Input::exists('post')) {
            if (Input::get('delete_staff')) {
                try {
                    $user->updateRecord('staff', array(
                        'status' => 0,
                    ),Input::get('id'));
                    $successMessage = 'Staff Deleted Successful';

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
            elseif(Input::get('edit_staff')){
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
                    'site_id' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'username' => array(
                        'required' => true,
                    ),
                    'phone_number' => array(
                        'required' => true,
                    ),
                ));
                if ($validate->passed()) {
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
                        case 'Country Data Manager':
                            $accessLevel = 5;
                            break;
                        case 'Statistician':
                            $accessLevel = 6;
                            break;
                        case 'Data Clark':
                            $accessLevel = 7;
                            break;
                    }
                    try {
                        $user->updateRecord('staff', array(
                            'firstname' => Input::get('firstname'),
                            'lastname' => Input::get('lastname'),
                            'position' => Input::get('position'),
                            'username' => Input::get('username'),
                            'access_level' => $accessLevel,
                            'phone_number' => Input::get('phone_number'),
                            'email_address' => Input::get('email_address'),
                            'c_id' => Input::get('country_id'),
                            's_id' => Input::get('site_id'),
                            'status' => 1
                        ), Input::get('id'));
                        $successMessage = 'Staff Info Updated Successful';

                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                }else {
                    $pageError = $validate->errors();
                }
            }
            elseif(Input::get('delete_country')){
                try {
                    $user->updateRecord('country', array(
                        'status' => 0,
                    ),Input::get('id'));
                    $successMessage = 'Country Deleted Successful';

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
            elseif(Input::get('edit_country')){
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
                        $user->updateRecord('country', array(
                            'name' => Input::get('country_name'),
                            'short_code' => Input::get('short_code'),
                        ),Input::get('id'));
                        $successMessage = 'Country Updated Successful';

                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    $pageError = $validate->errors();
                }
            }
            elseif(Input::get('reset_password')){
               // $salt = Hash::salt(32);
                //$password = '123456';
                $token = $rand->get_rand_alphanumeric(8);
                try{
                    $user->updateRecord('staff',array(
                        'token'=>$token
                    ),Input::get('id'));
                    $link='https://tbnode.exit-tb.org/reset.php?token='.$token;//reset url
                    if($email->resetPassword(Input::get('email'),Input::get('lastname'),'RESET PASSWORD',$link)){
                        $successMessage = 'Email with Password Reset Link sent Successful';
                    }
                }
                catch (PDOException $e){
                    $e->getMessage();
                } catch (Exception $e) {
                }
                /*$salt = Hash::salt(32);
                $password = '123456';
                try{
                    $user->updateRecord('staff',array(
                        'password' => Hash::make($password, $salt),
                        'salt' => $salt,
                        'pswd'=>0
                    ),Input::get('id'));
                    $successMessage = 'Password Reset to Default Successful';
                }
                catch (PDOException $e){
                    $e->getMessage();
                } catch (Exception $e) {
                }*/
            }
            elseif (Input::get('download_prev')){
                $data=$override->getData('prevalence_survey');
                $user->exportData($data,'prevalence_survey');
            }
            elseif (Input::get('download_cluster')){
                $data=$override->getData('clients_demographic_info');
                $user->exportData($data,'cluster_prevalence');
            }
            elseif (Input::get('download_routine')){
                $data=$override->getData('routine_data');
                $user->exportData($data,'routine_data');
            }
            elseif (Input::get('download_f1')){
                $data=$override->get('prevalence_survey','c_id',$_GET['c']);
                $user->exportData($data,'routine_data');
            }
            elseif (Input::get('download_f2')){
                $data=$override->get('clients_demographic_info','c_id',$_GET['c']);
                $user->exportData($data,'routine_data');
            }
            elseif (Input::get('download_f3')){
                $data=$override->get('routine_data','c_id',$_GET['c']);
                $user->exportData($data,'routine_data');
            }
            elseif (Input::get('download_all')){
                $data=$override->getData('routine_data');
                $user->exportData($data,'routine_data');
            }
        }
  }
}else{
    Redirect::to('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title> TB-NODE </title>

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
    <script type='text/javascript' src='js/plugins/datatables/jquery.dataTables.min.js'></script>

    <!--<script type='text/javascript' src='js/jquery.dataTables.js'></script>
    <script type='text/javascript' src='js/dataTables.bootstrap.min.js'></script>-->

    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script type='text/javascript' src='js/plugins/uniform/jquery.uniform.min.js'></script>

    <script type='text/javascript' src='js/plugins/noty/jquery.noty.js'></script>
    <script type='text/javascript' src='js/plugins/noty/layouts/topCenter.js'></script>
    <script type='text/javascript' src='js/plugins/noty/layouts/topLeft.js'></script>
    <script type='text/javascript' src='js/plugins/noty/layouts/topRight.js'></script>
    <script type='text/javascript' src='js/plugins/noty/themes/default.js'></script>

    <script type='text/javascript' src='js/morris.min.js'></script>
    <script type='text/javascript' src='js/raphael.min.js'></script>

    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
</head>
<body class="bg-img-num1">

<div class="container">
<div class="row">
    <div class="col-md-12">
        <?php include'topBar.php'?>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <?php include 'sideBar.php'?>
        <div class="block block-drop-shadow">
            <div class="head bg-dot20">
                <h2>QUERIES</h2>
                <div class="side pull-right">
                    <ul class="buttons">
                        <li><a href="#"><span class="icon-cogs"></span></a></li>
                    </ul>
                </div>
                <div class="head-subtitle">Queries generated from uploaded Data</div>
                <div class="head-panel">
                    <div class="hp-info hp-simple pull-left hp-inline">
                        <span class="hp-main">Missing Values <span class="icon-angle-right"></span> 0%</span>
                        <div class="hp-sm">
                            <div class="progress progress-small">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="890" aria-valuemin="0" aria-valuemax="1000" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="hp-info hp-simple pull-left hp-inline">
                        <span class="hp-main">Missing Data <span class="icon-angle-right"></span> 0%</span>
                        <div class="hp-sm">
                            <div class="progress progress-small">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="hp-info hp-simple pull-left hp-inline">
                        <span class="hp-main">Abnormal Range <span class="icon-angle-right"></span> 0%</span>
                        <div class="hp-sm">
                            <div class="progress progress-small">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-offset-0 col-md-10">
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
                <b>Error!</b> <?php foreach($pageError2 as $error){echo $error.' , ';}?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        </div>
    <?php }elseif($successMessage){?>
        <div class="block">
            <div class="alert alert-success">
                <b>Success!</b> <?=$successMessage?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        </div>
    <?php }?>
        <?php if($_GET['id'] == 1){?>
            <div class="block">
                <div class="header">
                    <h2>STAFF</h2>
                </div>
                <div class="content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th width="20%">NAME</th>
                            <th width="10%">USERNAME</th>
                            <th width="10%">POSITION</th>
                            <th width="10%">COUNTRY</th>
                            <th width="10%">PHONE</th>
                            <th width="10%">EMAIL</th>
                            <th width="10%">STATUS</th>
                            <th width="20%">MANAGE</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $y=0;$x=1;if($user->data()->access_level == 1 || $user->data()->access_level == 2 || $user->data()->access_level == 3){$staffs=$override->get('staff','status',1);}
                        elseif($user->data()->access_level == 4){$staffs=$override->getNews('staff','status',1,'c_id',$user->data()->c_id);}
                        foreach($staffs as $staff){if($user->data()->access_level != 1 || $user->data()->id != $staff['id']){
                            if($user->data()->access_level == 1){$power=1;}else{$power=0;}
                            $country=$override->get('country','id',$staff['c_id']);?>
                            <tr>
                                <td><?=$x?></td>
                                <td><?=$staff['firstname'].' '.$staff['lastname']?></td>
                                <td><?=$staff['username']?></td>
                                <td><?=$staff['position']?></td>
                                <td><?=$country[0]['name']?></td>
                                <td><?=$staff['phone_number']?></td>
                                <td><?=$staff['email_address']?></td>
                                <td><div class="btn-group btn-group-xs"> <?php if($staff['token'] || $staff['count']>= 4){?><button class="btn btn-warning">INACTIVE</button> <?php }else{?><button class="btn btn-success">ACTIVE</button><?php }?></div></td></td>
                                <td>
                                    <?php if($staff['access_level'] != 2 || $power == 1){?>
                                        <a href="#edit_staff<?=$y?>" data-toggle="modal" class="widget-icon" title="Edit Staff Information"><span class="icon-pencil"></span></a>
                                        <a href="#reset_password<?=$y?>" data-toggle="modal" class="widget-icon" title="Reset Password to Default"><span class="icon-refresh"></span></a>
                                        <a href="#delete_staff<?=$y?>" data-toggle="modal" class="widget-icon" title="Delete Staff"><span class="icon-trash"></span></a>
                                    <?php }?>
                                </td>
                            </tr>
                            <div class="modal" id="edit_staff<?=$y?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">EDIT STAFF</h4>
                                            </div>
                                            <div class="modal-body clearfix">
                                                <div class="controls">
                                                    <div class="form-row">
                                                        <div class="col-md-2">First Name:</div>
                                                        <div class="col-md-10">
                                                            <input type="text" name="firstname" class="form-control" value="<?=$staff['firstname']?>" required=""/>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-2">Last Name:</div>
                                                        <div class="col-md-10">
                                                            <input type="text" name="lastname" class="form-control" value="<?=$staff['lastname']?>" required=""/>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-2">Country:</div>
                                                        <div class="col-md-10">
                                                            <select class="form-control" id="c" name="country_id" required="">
                                                                <option value="<?=$country[0]['id']?>"><?=$country[0]['name']?></option>
                                                                <?php if($user->data()->access_level == 1 || $user->data()->access_level == 2){
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
                                                                <option value="<?=$staff['position']?>"><?=$staff['position']?></option>
                                                                <?php foreach($override->getData('position') as $position){if($user->data()->access_level == 1 && $user->data()->power == 1){?>
                                                                    <option value="<?=$position['name']?>"><?=$position['name']?></option>
                                                                <?php }elseif($user->data()->access_level == 1 && $position['name'] != 'Principle Investigator'){?>
                                                                    <option value="<?=$position['name']?>"><?=$position['name']?></option>
                                                                <?php }elseif($user->data()->access_level == 2 && $position['name'] != 'Coordinator' && $position['name'] != 'Principle Investigator'){?>
                                                                    <option value="<?=$position['name']?>"><?=$position['name']?></option>
                                                                <?php }}?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-2">Username:</div>
                                                        <div class="col-md-10">
                                                            <input type="text" name="username" class="form-control" value="<?=$staff['username']?>" required=""/>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-2">Phone:</div>
                                                        <div class="col-md-10">
                                                            <input type="text" name="phone_number" class="form-control" value="<?=$staff['phone_number']?>" required=""/>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-2">Email:</div>
                                                        <div class="col-md-10">
                                                            <input type="text" name="email_address" class="form-control" value="<?=$staff['email_address']?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="pull-right col-md-3">
                                                    <input type="hidden" name="id" value="<?=$staff['id']?>">
                                                    <input type="submit" name="edit_staff" value="Submit" class="btn btn-success btn-clean">
                                                </div>
                                                <div class="pull-right col-md-2">
                                                    <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal modal-info" id="reset_password<?=$y?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">YOU SURE YOU WANT TO RESET PASSWORD FOR THIS STAFF ?</h4>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-md-2 pull-right">
                                                    <input type="hidden" name="lastname" value="<?=$staff['lastname']?>">
                                                    <input type="hidden" name="email" value="<?=$staff['email_address']?>">
                                                    <input type="hidden" name="id" value="<?=$staff['id']?>">
                                                    <input type="submit" name="reset_password" value="RESET" class="btn btn-default btn-clean">
                                                </div>
                                                <div class="col-md-2 pull-right">
                                                    <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal modal-danger" id="delete_staff<?=$y?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">YOU SURE YOU WANT TO DELETE THIS STAFF ?</h4>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-md-2 pull-right">
                                                    <input type="hidden" name="id" value="<?=$staff['id']?>">
                                                    <input type="submit" name="delete_staff" value="DELETE" class="btn btn-default btn-clean">
                                                </div>
                                                <div class="col-md-2 pull-right">
                                                    <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php $x++;}$y++;}?>
                        </tbody>
                    </table>

                </div>
            </div>
        <?php }
        elseif($_GET['id'] == 2){?>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="block">
                        <div class="header">
                            <h2>COUNTRIES</h2>
                        </div>
                        <div class="content">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>SHORT CODE</th>
                                    <th>MANAGE</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $x=1;foreach($override->get('country','status',1) as $country){?>
                                        <tr>
                                            <td><?=$x?></td>
                                            <td><?=$country['name']?></td>
                                            <td><?=$country['short_code']?></td>
                                            <td>
                                                <a href="#edit_country<?=$x?>" data-toggle="modal" class="widget-icon" title="Edit Site Information"><span class="icon-pencil"></span></a>
                                                <a href="#delete_country<?=$x?>" data-toggle="modal" class="widget-icon" title="Delete Site"><span class="icon-trash"></span></a>
                                            </td>
                                        </tr>
                                        <div class="modal" id="edit_country<?=$x?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">EDIT COUNTRY</h4>
                                                        </div>
                                                        <div class="modal-body clearfix">
                                                            <div class="controls">
                                                                <div class="form-row">
                                                                    <div class="col-md-2">Name:</div>
                                                                    <div class="col-md-10">
                                                                        <input type="text" name="country_name" class="form-control" value="<?=$country['name']?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="col-md-2">Short Code:</div>
                                                                    <div class="col-md-10">
                                                                        <input type="text" name="short_code" class="form-control" value="<?=$country['short_code']?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="pull-right col-md-3">
                                                                <input type="hidden" name="id" value="<?=$country['id']?>">
                                                                <input type="submit" name="edit_country" value="Submit" class="btn btn-success btn-clean">
                                                            </div>
                                                            <div class="pull-right col-md-2">
                                                                <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal modal-danger" id="delete_country<?=$x?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">YOU SURE YOU WANT TO DELETE THIS COUNTRY</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="col-md-2 pull-right">
                                                                <input type="hidden" name="id" value="<?=$country['id']?>">
                                                                <input type="submit" name="delete_country" value="DELETE" class="btn btn-default btn-clean">
                                                            </div>
                                                            <div class="col-md-2 pull-right">
                                                                <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php $x++;}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        elseif ($_GET['id'] == 3){?>
            <div class="row">
                <div class="col-md-12">
                <div class="block">
                    <div class="header">
                        <h2>PREVALENCE SURVEY FOR <?=$override->get('country','id',$_GET['c'])[0]['name']?></h2>
                        <div class="pull-right">
                            <form method="post">
                                <input type="submit" name="download_f1" class="btn btn-primary btn-clean pull-right" value="Download Data" />
                            </form>
                        </div>
                    </div>
                    <div class="content">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>RECORD ID</th>
                                <th>YEAR</th>
                                <th>DATA</th>
                                <th>MANAGE</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $x=1;  if($user->data()->access_level == 1){$cn_id = $_GET['c'];}else{$cn_id = $user->data()->c_id;}
                                foreach($override->getNews('prevalence_survey','status',1,'c_id',$cn_id) as $data){?>
                                <tr>
                                    <td><?=$x?></td>
                                    <td><?=$data['record_id']?></td>
                                    <td><?=$data['case_year']?></td>
                                    <td><?=$data['smear_15_24'].' , '.$data['smear_25_34'].' , '.$data['smear_35_44'].' , '.$data['smear_45_54'].' , '.$data['smear_55_64'].' , '.$data['smear_65_above'].' , '.$data['smear_15_24'].'.....'?></td>
                                    <td>
                                        <div class="btn-group btn-group-xs"><a href="info.php?id=4&d=<?=$data['id']?>" class="btn btn-info btn-clean"><span class="icon-eye-open"></span> View more details</a></div>
                                     </td>
                                </tr>
                                <?php $x++;}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        <?php }
        elseif ($_GET['id'] == 4){?>
            <div class="row">
                <?php $getData=$override->getNews('prevalence_survey','status',1,'id',$_GET['d']);$x=1;
                    foreach($getData as $data){?>
                        <div class="col-md-12">
                            <div class="header">
                                <h2>Smear Positive Pulmonary Tuberculosis</h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                    <div class="block">
                        <div class="content">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>AGE GROUP</th>
                                    <th>Count/100,000</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>15-24</td>
                                        <td><?=$data['smear_15_24']?></td>
                                    </tr>
                                    <tr>
                                        <td>25-34</td>
                                        <td><?=$data['smear_25_34']?></td>
                                    </tr>
                                    <tr>
                                        <td>35-44</td>
                                        <td><?=$data['smear_35_44']?></td>
                                    </tr>
                                    <tr>
                                        <td>45-54</td>
                                        <td><?=$data['smear_45_54']?></td>
                                    </tr>
                                    <tr>
                                        <td>55-64</td>
                                        <td><?=$data['smear_55_64']?></td>
                                    </tr>
                                    <tr>
                                        <td>65 and above</td>
                                        <td><?=$data['smear_65_above']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                        <div class="col-md-3">
                            <div class="block">
                                <div class="content">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>AGE GROUP</th>
                                            <th>Count/100,000</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Low</td>
                                            <td><?=$data['smear_low']?></td>
                                        </tr>
                                        <tr>
                                            <td>Middle</td>
                                            <td><?=$data['smear_middle']?></td>
                                        </tr>
                                        <tr>
                                            <td>High</td>
                                            <td><?=$data['smear_high']?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="block">
                                <div class="content">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>AGE GROUP</th>
                                            <th>Count/100,000</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Male</td>
                                            <td><?=$data['smear_male']?></td>
                                        </tr>
                                        <tr>
                                            <td>Female</td>
                                            <td><?=$data['smear_female']?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="header">
                                <h2>Bacteriologically confirmed pulmonary tuberculosis</h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="block">

                        <div class="content">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>AGE GROUP</th>
                                    <th>Count/100,000</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>15-24</td>
                                    <td><?=$data['bact_15_24']?></td>
                                </tr>
                                <tr>
                                    <td>25-34</td>
                                    <td><?=$data['bact_25_34']?></td>
                                </tr>
                                <tr>
                                    <td>35-44</td>
                                    <td><?=$data['bact_35_44']?></td>
                                </tr>
                                <tr>
                                    <td>45-54</td>
                                    <td><?=$data['bact_45_54']?></td>
                                </tr>
                                <tr>
                                    <td>55-64</td>
                                    <td><?=$data['bact_55_64']?></td>
                                </tr>
                                <tr>
                                    <td>65 and above</td>
                                    <td><?=$data['bact_65_above']?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        </div>
                        <div class="col-md-3">
                            <div class="block">
                                <div class="content">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>AGE GROUP</th>
                                            <th>Count/100,000</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Low</td>
                                            <td><?=$data['bact_low']?></td>
                                        </tr>
                                        <tr>
                                            <td>Middle</td>
                                            <td><?=$data['bact_middle']?></td>
                                        </tr>
                                        <tr>
                                            <td>High</td>
                                            <td><?=$data['bact_high']?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="block">
                                <div class="content">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>AGE GROUP</th>
                                            <th>Count/100,000</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Male</td>
                                            <td><?=$data['bact_male']?></td>
                                        </tr>
                                        <tr>
                                            <td>Female</td>
                                            <td><?=$data['bact_female']?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
            </div>
        <?php $x++;}
        }
        elseif ($_GET['id'] == 5){?>
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <div class="header">
                            <h2>CLUSTER PREVALENCE FOR <?=$override->get('country','id',$_GET['c'])[0]['name']?></h2>
                            <div class="pull-right">
                                <form method="post">
                                    <input type="submit" name="download_f2" class="btn btn-primary btn-clean pull-right" value="Download Data" />
                                </form>
                            </div>
                        </div>
                        <div class="content">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                                <thead>
                                <tr>
                                    <th>RECORD ID</th>
                                    <th>YEAR</th>
                                    <th>CLUSTER NAME</th>
                                    <th>LATITUDE / LONGITUDE</th>
                                    <th>BC pulmonary TB p/100,000</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $x=1; if($user->data()->access_level == 1){$cn_id = $_GET['c'];}else{$cn_id = $user->data()->c_id;}
                                        foreach($override->getNews('clients_demographic_info','status',1,'c_id',$cn_id) as $data){?>
                                    <tr>
                                        <td><?=$data['record_id']?></td>
                                        <td><?=$data['case_year']?></td>
                                        <td><?=$data['cluster_name']?></td>
                                        <td><?=$data['latitude'].' / '.$data['longitude']?></td>
                                        <td><?=$data['case_detected']?></td>
                                    </tr>
                                    <?php $x++;}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        elseif ($_GET['id'] == 6){?>
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <div class="header">
                            <h2>ROUTINE DATA</h2>
                            <div class="pull-right">
                                <form method="post">
                                    <input type="submit" name="download_f3" class="btn btn-primary btn-clean pull-right" value="Download Data" />
                                </form>
                            </div>
                        </div>
                        <div class="content">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>RECORD ID</th>
                                    <th>YEAR</th>
                                    <th>DATA</th>
                                    <th>MANAGE</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $x=1;if($user->data()->access_level == 1){$cn_id = $_GET['c'];}else{$cn_id = $user->data()->c_id;}
                                        foreach($override->getNews('routine_data','status',1,'c_id',$cn_id) as $data){?>
                                    <tr>
                                        <td><?=$x?></td>
                                        <td><?=$data['record_id']?></td>
                                        <td><?=$data['case_year']?></td>
                                        <td><strong>New Case:</strong> <?=$data['bact_conf_tb'].' , '.$data['pul_clinc_diag_tb'].' , '.$data['extra_pul_diag_tb'].' .... '?><strong>Previously treated:</strong> <?=$data['relapse'].' , '.$data['treatment_after_failure'].' , '.$data['return_after_lost_follow_up'].' , '.$data['other_previously_treated'].'.....'?></td>
                                        <td>
                                            <div class="btn-group btn-group-xs"><a href="info.php?id=7&d=<?=$data['id']?>" class="btn btn-info btn-clean"><span class="icon-eye-open"></span> View more details</a></div>
                                        </td>
                                    </tr>
                                    <?php $x++;}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        elseif ($_GET['id'] == 7){?>
        <div class="row">
            <?php $getData=$override->getNews('routine_data','status',1,'id',$_GET['d']);$x=1;
            foreach($getData as $data){?>
                <div class="col-md-6">
                    <div class="block">
                    <div class="header">
                        <h2>NEW</h2>
                    </div>
                    <div class="content">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>CASE TYPE</th>
                                <th>VALUE</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Bacteriological confirmed TB cases</td>
                                <td><?=$data['bact_conf_tb']?></td>
                            </tr>
                            <tr>
                                <td>Pulmonary Clinically diagnosed TB cases</td>
                                <td><?=$data['pul_clinc_diag_tb']?></td>
                            </tr>
                            <tr>
                                <td>Extra-pulmonary Clinically diagnosed</td>
                                <td><?=$data['extra_pul_diag_tb']?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                    <div class="block">
                        <div class="header">
                            <h2>PREVIOUSLY TREATED</h2>
                        </div>
                        <div class="content">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>CASE TYPE</th>
                                    <th>VALUE</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Relapse</td>
                                    <td><?=$data['relapse']?></td>
                                </tr>
                                <tr>
                                    <td>Treatment after failure</td>
                                    <td><?=$data['treatment_after_failure']?></td>
                                </tr>
                                <tr>
                                    <td>Return after lost to follow up</td>
                                    <td><?=$data['return_after_lost_follow_up']?></td>
                                </tr>
                                <tr>
                                    <td>Other previously treated</td>
                                    <td><?=$data['other_previously_treated']?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-1 col-md-10 ">
                    <div class="block">
                        <div class="header">
                            <h2>HIV INFORMATION</h2>
                        </div>
                        <div class="content">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>Number Tested</td>
                                    <td><?=$data['hiv_no_tested']?></td>
                                </tr>
                                <tr>
                                    <td>HIV Positive Cases</td>
                                    <td><?=$data['hiv_positive_case']?></td>
                                </tr>
                                <tr>
                                    <td>Registered For HIV Care</td>
                                    <td><?=$data['hiv_register_for_care']?></td>
                                </tr>
                                <tr>
                                    <td>Started ARV</td>
                                    <td><?=$data['hiv_start_art']?></td>
                                </tr>
                                <tr>
                                    <td>Started CPT</td>
                                    <td><?=$data['hiv_started_cpt']?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-1 col-md-10">
                    <div class="block">
                        <div class="header">
                            <h2>TB treatment outcome of new and relapse TB cases</h2>
                        </div>
                        <div class="content">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Bacteriologically confirmed</th>
                                    <th>Clinically diagnosed Pulmonary</th>
                                    <th>Clinically diagnosed Extra Pulmonary</th>
                                    <th>Relapse</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Cured</td>
                                    <td><?=$data['nw_cured_bact_conf']?></td>
                                    <td></td>
                                    <td></td>
                                    <td><?=$data['nw_cured_relapse']?></td>
                                </tr>
                                <tr>
                                    <td>Treatment completed</td>
                                    <td><?=$data['nw_tc_bact_conf']?></td>
                                    <td><?=$data['nw_tc_cli_diag']?></td>
                                    <td><?=$data['nw_tc_cli_diag_extra']?></td>
                                    <td><?=$data['nw_tc_relapse']?></td>
                                </tr>
                                <tr>
                                    <td>Treatment Success</td>
                                    <td><?=$data['nw_ts_bact_conf']?></td>
                                    <td><?=$data['nw_ts_cli_diag']?></td>
                                    <td><?=$data['nw_ts_cli_diag_extra']?></td>
                                    <td><?=$data['nw_ts_relapse']?></td>
                                </tr>
                                <tr>
                                    <td>Failure</td>
                                    <td><?=$data['nw_fl_bact_conf']?></td>
                                    <td></td>
                                    <td></td>
                                    <td><?=$data['nw_fl_relapse']?></td>
                                </tr>
                                <tr>
                                    <td>Died</td>
                                    <td><?=$data['nw_died_bact_conf']?></td>
                                    <td><?=$data['nw_died_cli_diag']?></td>
                                    <td><?=$data['nw_died_cli_diag_extra']?></td>
                                    <td><?=$data['nw_died_relapse']?></td>
                                </tr>
                                <tr>
                                    <td>Lost to follow up</td>
                                    <td><?=$data['nw_lf_bact_conf']?></td>
                                    <td><?=$data['nw_lf_cli_diag']?></td>
                                    <td><?=$data['nw_lf_cli_diag_extra']?></td>
                                    <td><?=$data['nw_lf_relapse']?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-1 col-md-10">
                    <div class="block">
                        <div class="header">
                            <h2>Treatment outcome of previously treated (except relapse) cases</h2>
                        </div>
                        <div class="content">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Treatment after failure</th>
                                    <th>Treatment after loss to follow-up</th>
                                    <th>Other previously treated</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Cured</td>
                                    <td><?=$data['prev_cure_treat_failure']?></td>
                                    <td><?=$data['prev_cure_treat_lst_flw']?></td>
                                    <td><?=$data['prev_cure_prev_treat']?></td>
                                </tr>
                                <tr>
                                    <td>Treatment completed</td>
                                    <td><?=$data['prev_tc_treat_failure']?></td>
                                    <td><?=$data['prev_tc_treat_lst_flw']?></td>
                                    <td><?=$data['prev_tc_prev_treat']?></td>
                                </tr>
                                <tr>
                                    <td>Treatment Success</td>
                                    <td><?=$data['prev_ts_treat_failure']?></td>
                                    <td><?=$data['prev_ts_treat_lst_flw']?></td>
                                    <td><?=$data['prev_ts_prev_treat']?></td>
                                </tr>
                                <tr>
                                    <td>Failure</td>
                                    <td><?=$data['prev_fl_treat_failure']?></td>
                                    <td><?=$data['prev_fl_treat_lst_flw']?></td>
                                    <td><?=$data['prev_fl_prev_treat']?></td>
                                </tr>
                                <tr>
                                    <td>Died</td>
                                    <td><?=$data['prev_died_treat_failure']?></td>
                                    <td><?=$data['prev_died_treat_lst_flw']?></td>
                                    <td><?=$data['prev_died_prev_treat']?></td>
                                </tr>
                                <tr>
                                    <td>Lost to follow up</td>
                                    <td><?=$data['prev_lf_treat_failure']?></td>
                                    <td><?=$data['prev_lf_treat_lst_flw']?></td>
                                    <td><?=$data['prev_lf_prev_treat']?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        <?php $x++;}}
        elseif ($_GET['id'] == 8){?>
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <div class="header">
                            <h2>TB-NODE DATA</h2>
                            <div class="pull-right">
                                <form method="post">
                                    <input type="submit" name="" class="btn btn-primary btn-clean pull-right" value="Download All Data" />
                                </form>
                            </div>
                        </div>
                        <div class="content">
                            <table class="table table-bordered">
                                <tbody>
                                    <?php if($user->data()->access_level == 1){?>
                                        <tr>
                                            <td>PREVALENCE SURVEY</td>
                                            <td><?=$override->getNo('prevalence_survey')?></td>
                                            <td>
                                                <form method="post">
                                                    <div class="btn-group btn-group-xs"><input type="submit" name="download_prev" value="Download Excel" class="btn btn-info btn-clean"></div>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CLUSTER PREVALENCE</td>
                                            <td><?=$override->getNo('clients_demographic_info')?></td>
                                            <td>
                                                <form method="post">
                                                    <div class="btn-group btn-group-xs"><input type="submit" name="download_cluster" value="Download Excel" class="btn btn-info btn-clean"></div>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ROUTINE DATA</td>
                                            <td><?=$override->getNo('routine_data')?></td>
                                            <td>
                                                <form method="post">
                                                    <div class="btn-group btn-group-xs"><input type="submit" name="download_routine" value="Download Excel" class="btn btn-info btn-clean"></div>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</div>

</div>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5d72573e77aa790be332c429/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
</body>
<script>
    <?php if($user->data()->pswd == 0){?>
    $(window).on('load',function(){
        $("#change_password").modal({
            backdrop: 'static',
            keyboard: false
        },'show');
    });
    <?php }?>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<script>
    $(document).ready(function(){
        $('#c').change(function(){
            var site = $(this).val();
            $('#s_i').hide();
            $('#w_i').show();
            $.ajax({
                url:"process.php?content=site",
                method:"GET",
                data:{site:site},
                dataType:"text",
                success:function(data){
                    //$('#site_i').html(data);
                    //$('#s_i').show();
                    //$('#w_i').hide();
                }
            });
        });
    });
</script>
<script>

</script>
</html>