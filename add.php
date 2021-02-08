<?php
require_once'php/core/init.php';
$user = new User();
$override = new OverideData();
$validate = new validate();
$pageError = null;$successMessage = null;$errorM = false;$errorMessage = null;$l_row=0;$rec_id='';

if($user->isLoggedIn()){
    $country=$override->get('country','id',$user->data()->c_id);
    if(Input::exists('post')){
        if($_GET['id'] == 1){
            if(Input::get('add_prev')){
                $validate = new validate();
                $validate = $validate->check($_POST, array(
                    'case_year' => array(
                        'required' => true,
                    ),
                    'smear_15_24' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'smear_25_34' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'smear_35_44' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'smear_45_54' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'smear_55_64' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'smear_65_above' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'smear_male' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'smear_female' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'smear_low' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'smear_middle' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'smear_high' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_15_24' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_25_34' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_35_44' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_45_54' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_55_64' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_65_above' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_male' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_female' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_low' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_middle' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'bact_high' => array(
                        'required' => true,
                        'max' => 5
                    ),
                ));
                if ($validate->passed()) {
                    $recLast = $override->lastRow('prevalence_survey','id');
                    if($recLast){$l_row=$recLast[0]['id']+1;$rec_id=$country[0]['short_code'].'-'.$l_row.'-'.date('m-d');}
                    try {
                        $user->createRecord('prevalence_survey', array(
                            'case_year' => Input::get('case_year'),
                            'record_id' => $rec_id,
                            'smear_15_24' => Input::get('smear_15_24'),
                            'smear_25_34' => Input::get('smear_25_34'),
                            'smear_35_44' => Input::get('smear_35_44'),
                            'smear_45_54' => Input::get('smear_45_54'),
                            'smear_55_64' => Input::get('smear_55_64'),
                            'smear_65_above' => Input::get('smear_65_above'),
                            'smear_male' => Input::get('smear_male'),
                            'smear_female' => Input::get('smear_female'),
                            'smear_low' => Input::get('smear_low'),
                            'smear_middle' => Input::get('smear_middle'),
                            'smear_high' => Input::get('smear_high'),
                            'bact_15_24' => Input::get('bact_15_24'),
                            'bact_25_34' => Input::get('bact_25_34'),
                            'bact_35_44' => Input::get('bact_35_44'),
                            'bact_45_54' => Input::get('bact_45_54'),
                            'bact_55_64' => Input::get('bact_55_64'),
                            'bact_65_above' => Input::get('bact_65_above'),
                            'bact_male' => Input::get('bact_male'),
                            'bact_female' => Input::get('bact_female'),
                            'bact_low' => Input::get('bact_low'),
                            'bact_middle' => Input::get('bact_middle'),
                            'bact_high' => Input::get('bact_high'),
                            'sb_date' => date('Y-m-d'),
                            'status' => 1,
                            'c_id' => $user->data()->c_id,
                            'staff_id' => $user->data()->id,
                        ));
                        if($rec_id == ''){
                            $l_r=$override->lastRow('prevalence_survey','id');
                            if($l_r){
                                $rec_id=$country[0]['short_code'].'-'.$l_r[0]['id'].'-'.date('m-d');
                                $user->updateRecord('prevalence_survey',array('record_id' => $rec_id),$l_r[0]['id']);
                            }
                        }
                        $successMessage = 'Data Saved Successful';

                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    $pageError = $validate->errors();
                }
            }
        }
        elseif ($_GET['id'] == 2){
            if(Input::get('add_demo')){
                $validate = new validate();
                $validate = $validate->check($_POST, array(
                    'case_year' => array(
                        'required' => true,
                    ),
                    'cluster_name' => array(
                        'required' => true,
                    ),
                    'latitude' => array(
                        'required' => true,
                    ),
                    'longitude' => array(
                        'required' => true,
                    ),
                    'case_detected' => array(
                        'required' => true,
                        'max' => 5
                    ),
                ));
                if ($validate->passed()) {
                    $recLast = $override->lastRow('clients_demographic_info','id');
                    if($recLast){$l_row=$recLast[0]['id']+1;$rec_id=$country[0]['short_code'].'-'.$l_row.'-'.date('m-d');}
                    try {
                        $user->createRecord('clients_demographic_info', array(
                            'case_year' => Input::get('case_year'),
                            'record_id' => $rec_id,
                            'cluster_name' => Input::get('cluster_name'),
                            'latitude' => Input::get('latitude'),
                            'longitude' => Input::get('longitude'),
                            'case_detected' => Input::get('case_detected'),
                            'sb_date' => date('Y-m-d'),
                            'status' => 1,
                            'c_id' => $user->data()->c_id,
                            'staff_id' => $user->data()->id,
                        ));
                        if($rec_id == ''){
                            $l_r=$override->lastRow('clients_demographic_info','id');
                            if($l_r){
                                $rec_id=$country[0]['short_code'].'-'.$l_r[0]['id'].'-'.date('m-d');
                                $user->updateRecord('clients_demographic_info',array('record_id' => $rec_id),$l_r[0]['id']);
                            }
                        }
                        $successMessage = 'Data Saved Successful ';

                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    $pageError = $validate->errors();
                }
            }
        }
        elseif ($_GET['id'] == 3){
            if(Input::get('routine_data')){
                $validate = new validate();
                $validate = $validate->check($_POST, array(
                    'case_year' => array(
                        'required' => true,
                    ),
                    /*'bact_conf_tb' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'pul_clinc_diag_tb' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'extra_pul_diag_tb' => array(
                        'required' => true,
                        'max' => 5
                    ),'relapse' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'treatment_after_failure' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'return_after_lost_follow_up' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'other_previously_treated' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'hiv_no_tested' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'hiv_positive_case' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'hiv_register_for_care' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'hiv_start_art' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'hiv_started_cpt' => array(
                        'required' => true,
                        'max' => 5
                    ),
                    'nw_cured_bact_conf' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_cured_relapse' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_tc_bact_conf' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_tc_cli_diag' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_tc_cli_diag_extra' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_tc_relapse' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_ts_bact_conf' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_ts_cli_diag' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_ts_cli_diag_extra' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_ts_relapse' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_fl_bact_conf' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_fl_relapse' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_died_bact_conf' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_died_cli_diag' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_died_cli_diag_extra' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_died_relapse' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_lf_bact_conf' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_lf_cli_diag' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_lf_cli_diag_extra' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'nw_lf_relapse' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_cure_treat_failure' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_cure_treat_lst_flw' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_cure_prev_treat' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_tc_treat_failure' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_tc_treat_lst_flw' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_tc_prev_treat' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_ts_treat_failure' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_ts_treat_lst_flw' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_ts_prev_treat' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_fl_treat_failure' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_fl_treat_lst_flw' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_fl_prev_treat' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_died_treat_failure' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_died_treat_lst_flw' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_died_prev_treat' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_lf_treat_failure' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_lf_treat_lst_flw' => array(
                        'required' => true,
                        'max' => 6
                    ),
                    'prev_lf_prev_treat' => array(
                        'required' => true,
                        'max' => 6
                    ),*/
                ));
                if ($validate->passed()) {
                    $recLast = $override->lastRow('routine_data','id');
                    if($recLast){$l_row=$recLast[0]['id']+1;$rec_id=$country[0]['short_code'].'-'.$l_row.'-'.date('m-d');}
                    try {
                        $user->createRecord('routine_data', array(
                            'case_year' => Input::get('case_year'),
                            'record_id' => $rec_id,
                            'bact_conf_tb' => Input::get('bact_conf_tb'),
                            'pul_clinc_diag_tb' => Input::get('pul_clinc_diag_tb'),
                            'extra_pul_diag_tb' => Input::get('extra_pul_diag_tb'),
                            'relapse' => Input::get('relapse'),
                            'treatment_after_failure' => Input::get('treatment_after_failure'),
                            'return_after_lost_follow_up' => Input::get('return_after_lost_follow_up'),
                            'other_previously_treated' => Input::get('other_previously_treated'),
                            'hiv_no_tested' => Input::get('hiv_no_tested'),
                            'hiv_positive_case' => Input::get('hiv_positive_case'),
                            'hiv_register_for_care' => Input::get('hiv_register_for_care'),
                            'hiv_start_art' => Input::get('hiv_start_art'),
                            'hiv_started_cpt' => Input::get('hiv_started_cpt'),
                            'nw_cured_bact_conf' => Input::get('nw_cured_bact_conf'),
                            'nw_cured_relapse' => Input::get('nw_cured_relapse'),
                            'nw_tc_bact_conf' => Input::get('nw_tc_bact_conf'),
                            'nw_tc_cli_diag' => Input::get('nw_tc_cli_diag'),
                            'nw_tc_cli_diag_extra' => Input::get('nw_tc_cli_diag_extra'),
                            'nw_tc_relapse' => Input::get('nw_tc_relapse'),
                            'nw_ts_bact_conf' => Input::get('nw_ts_bact_conf'),
                            'nw_ts_cli_diag' => Input::get('nw_ts_cli_diag'),
                            'nw_ts_cli_diag_extra' => Input::get('nw_ts_cli_diag_extra'),
                            'nw_ts_relapse' => Input::get('nw_ts_relapse'),
                            'nw_fl_bact_conf' => Input::get('nw_fl_bact_conf'),
                            'nw_fl_relapse' => Input::get('nw_fl_relapse'),
                            'nw_died_bact_conf' => Input::get('nw_died_bact_conf'),
                            'nw_died_cli_diag' => Input::get('nw_died_cli_diag'),
                            'nw_died_cli_diag_extra' => Input::get('nw_died_cli_diag_extra'),
                            'nw_died_relapse' => Input::get('nw_died_relapse'),
                            'nw_lf_bact_conf' => Input::get('nw_lf_bact_conf'),
                            'nw_lf_cli_diag' => Input::get('nw_lf_cli_diag'),
                            'nw_lf_cli_diag_extra' => Input::get('nw_lf_cli_diag_extra'),
                            'nw_lf_relapse' => Input::get('nw_lf_relapse'),
                            'prev_cure_treat_failure' => Input::get('prev_cure_treat_failure'),
                            'prev_cure_treat_lst_flw' => Input::get('prev_cure_treat_lst_flw'),
                            'prev_cure_prev_treat' => Input::get('prev_cure_prev_treat'),
                            'prev_tc_treat_failure' => Input::get('prev_tc_treat_failure'),
                            'prev_tc_treat_lst_flw' => Input::get('prev_tc_treat_lst_flw'),
                            'prev_tc_prev_treat' => Input::get('prev_tc_prev_treat'),
                            'prev_ts_treat_failure' => Input::get('prev_ts_treat_failure'),
                            'prev_ts_treat_lst_flw' => Input::get('prev_ts_treat_lst_flw'),
                            'prev_ts_prev_treat' => Input::get('prev_ts_prev_treat'),
                            'prev_fl_treat_failure' => Input::get('prev_fl_treat_failure'),
                            'prev_fl_treat_lst_flw' => Input::get('prev_fl_treat_lst_flw'),
                            'prev_fl_prev_treat' => Input::get('prev_fl_prev_treat'),
                            'prev_died_treat_failure' => Input::get('prev_died_treat_failure'),
                            'prev_died_treat_lst_flw' => Input::get('prev_died_treat_lst_flw'),
                            'prev_died_prev_treat' => Input::get('prev_died_prev_treat'),
                            'prev_lf_treat_failure' => Input::get('prev_lf_treat_failure'),
                            'prev_lf_treat_lst_flw' => Input::get('prev_lf_treat_lst_flw'),
                            'prev_lf_prev_treat' => Input::get('prev_lf_prev_treat'),
                            'sb_date' => date('Y-m-d'),
                            'status' => 1,
                            'c_id' => $user->data()->c_id,
                            'staff_id' => $user->data()->id,

                        ));
                        if($rec_id == ''){
                            $l_r=$override->lastRow('routine_data','id');
                            if($l_r){
                                $rec_id=$country[0]['short_code'].'-'.$l_r[0]['id'].'-'.date('m-d');
                                $user->updateRecord('routine_data',array('record_id' => $rec_id),$l_r[0]['id']);
                            }
                        }
                        $successMessage = 'Data Saved Successful';

                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    $pageError = $validate->errors();
                }
            }
        }
        elseif ($_GET['id'] == 4){
            if(Input::get('mdr_data')){
                //$validate = new validate();
                $validate = $validate->check($_POST, array(
                    'total_mdr_year' => array(
                        'required' => true,
                    ),
                    'total_no_mdr_cases' => array(
                        'required' => true,
                    ),
                ));
                if ($validate->passed()) {
                    $recLast = $override->lastRow('mdr_tb_notification','id');
                    if($recLast){$l_row=$recLast[0]['id']+1;$rec_id=$country[0]['short_code'].'-'.$l_row.'-MDR-'.date('m-d');}
                    print_r(Input::get('trmnt_mdr_outcome_success'));
                    try {
                        $user->createRecord('mdr_tb_notification', array(
                            'record_id' => $rec_id,
                            'total_mdr_year' => Input::get('total_mdr_year'),

                            'total_no_mdr_cases' => Input::get('total_no_mdr_cases'),
                            'region_mdr_position_1st' => Input::get('region_mdr_position_1st'),
                            '1st_region_mdr' => Input::get('1st_region_mdr'),
                            '1st_region_no_mdr_cases' => Input::get('1st_region_no_mdr_cases'),

                            'region_mdr_position_2nd' => Input::get('region_mdr_position_2nd'),
                            '2nd_region_mdr' => Input::get('2nd_region_mdr'),
                            '2nd_region_no_mdr_cases' => Input::get('2nd_region_no_mdr_cases'),

                            'region_mdr_position_3rd' => Input::get('region_mdr_position_3rd'),
                            '3rd_region_mdr' => Input::get('3rd_region_mdr'),
                            '3rd_region_no_mdr_cases' => Input::get('3rd_region_no_mdr_cases'),

                            'male_mdr_sex' => Input::get('male_mdr_sex'),
                            'male_no_mdr_cases' => Input::get('male_no_mdr_cases'),

                            'female_mdr_sex' => Input::get('female_mdr_sex'),
                            'female_no_mdr_cases' => Input::get('female_no_mdr_cases'),

                            'trmnt_mdr_outcome_enrolled' => Input::get('trmnt_mdr_outcome_enrolled'),
                            'trmnt_no_mdr_cases_enrolled' => Input::get('trmnt_no_mdr_cases_enrolled'),

                            'trmnt_mdr_outcome_cured' => Input::get('trmnt_mdr_outcome_cured'),
                            'trmnt_no_mdr_cases_cured' => Input::get('trmnt_no_mdr_cases_cured'),

                            'trmnt_mdr_outcome_completed' => Input::get('trmnt_mdr_outcome_completed'),
                            'trmnt_no_mdr_cases_completed' => Input::get('trmnt_no_mdr_cases_completed'),

                            'trmnt_mdr_outcome_failed' => Input::get('trmnt_mdr_outcome_failed'),
                            'trmnt_no_mdr_cases_failed' => Input::get('trmnt_no_mdr_cases_failed'),
//
                            'trmnt_mdr_outcome_died' => Input::get('trmnt_mdr_outcome_died'),
                            'trmnt_no_mdr_cases_died' => Input::get('trmnt_no_mdr_cases_died'),
//
                            'trmnt_mdr_outcome_success' => Input::get('trmnt_mdr_outcome_success'),
                            'trmnt_no_mdr_cases_success' => Input::get('trmnt_no_mdr_cases_success'),

                            'status' => 1,
                            'rec_date' => date('Y-m-d'),
                            'c_id' => $user->data()->c_id,
                            'staff_id' => $user->data()->id,
                        ));
                        if($rec_id == ''){
                            $l_r=$override->lastRow('mdr_tb_notification','id');
                            if($l_r){
                                $rec_id=$country[0]['short_code'].'-'.$l_r[0]['id'].'-MDR-'.date('m-d');
                                $user->updateRecord('mdr_tb_notification',array('record_id' => $rec_id),$l_r[0]['id']);
                            }
                        }
                        $successMessage = 'Data Saved Successful ';

                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    $pageError = $validate->errors();
                }
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

            <?php require'sideBar.php'?>

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
                        <b>Error!</b> <?php foreach($pageError as $error){echo $error.' , ';}?>
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
            <div class="block">
                <div class="content">
                    <?php if($_GET['id'] == 1){?>
                        <div class="header">
                            <h2>PREVALENCE SURVEY INFORMATION</h2>
                        </div>
                        <p>&nbsp;</p>
                        <div class="block col-md-12">
                            <div class="alert alert-info">
                                <b>NOTE : </b> <strong >If information is not available, please enter 99999</strong>
                            </div>
                        </div>
                        <form method="post">
                            <div class="modal-body clearfix">
                                <div class="controls">
                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">SELECT YEAR:</div>
                                        <div class="col-md-4" id="v_code">
                                            <select class="form-control" id="year" name="case_year" required="">
                                                <option value=""> Year</option>
                                                <?php $x=2008;while ($x<=2019){?>
                                                    <option value="<?=$x?>"><?=$x?></option>
                                                    <?php $x++;}?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="block block-drop-shadow">
                                        <div class="head bg-dot20">
                                            <p>&nbsp;</p>
                                            <h3>SMEAR POSITIVE PULMONARY TUBERCULOSIS</h3>

                                            <div class="block block-drop-shadow">
                                                <div class="head bg-dot20">
                                                    <h6>AGE GROUP</h6>
                                                    <div class="form-row" id="s1">
                                                        <div class="col-md-1">15-24:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_15_24" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                        <div class="col-md-1">25-34:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_25_34" class="form-control" placeholder="Count/100,000" max="99999"  required/>
                                                        </div>
                                                        <div class="col-md-1">35-44:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_35_44" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                    </div>
                                                    <div class="form-row" id="s1">
                                                        <div class="col-md-1">45-54:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_45_54" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                        <div class="col-md-1">55-64:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_55_64" class="form-control" placeholder="Count/100,000" max="99999"  required/>
                                                        </div>
                                                        <div class="col-md-1">65 and above:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_65_above" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4>&nbsp;</h4>
                                            <div class="block block-drop-shadow">
                                                <div class="head bg-dot20">
                                                    <h6>GENDER</h6>
                                                    <div class="form-row" id="s1">
                                                        <div class="col-md-1">Male:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_male" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                        <div class="col-md-1">Female:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_female" class="form-control" placeholder="Count/100,000" max="99999"  required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4>&nbsp;</h4>
                                            <div class="block block-drop-shadow">
                                                <div class="head bg-dot20">
                                                    <h6>SOCIALECONOMIC POSITION</h6>
                                                    <div class="form-row" id="s1">
                                                        <div class="col-md-1">Low:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_low" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                        <div class="col-md-1">Middle:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_middle" class="form-control" placeholder="Count/100,000" max="99999"  required/>
                                                        </div>
                                                        <div class="col-md-1">High:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="smear_high" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="block block-drop-shadow">
                                        <div class="head bg-dot20">
                                            <p>&nbsp;</p>
                                            <h3>BACTERIOLOGICALLY CONFIRMED PULMONARY TUBERCULOSIS</h3>
                                            <div class="block block-drop-shadow">
                                                <div class="head bg-dot20">
                                                    <h6>AGE GROUP</h6>
                                                    <div class="form-row" id="s1">
                                                        <div class="col-md-1">15-24:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_15_24" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                        <div class="col-md-1">25-34:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_25_34" class="form-control" placeholder="Count/100,000" max="99999"  required/>
                                                        </div>
                                                        <div class="col-md-1">35-44:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_35_44" class="form-control" placeholder="Count/100,000" max="99999"  required/>
                                                        </div>
                                                    </div>
                                                    <div class="form-row" id="s1">
                                                        <div class="col-md-1">45-54:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_45_54" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                        <div class="col-md-1">55-64:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_55_64" class="form-control" placeholder="Count/100,000" max="99999"  required/>
                                                        </div>
                                                        <div class="col-md-1">65 and above:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_65_above" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4>&nbsp;</h4>
                                            <div class="block block-drop-shadow">
                                                <div class="head bg-dot20">
                                                    <h6>GENDER</h6>
                                                    <div class="form-row" id="s1">
                                                        <div class="col-md-1">Male:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_male" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                        <div class="col-md-1">Female:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_female" class="form-control" placeholder="Count/100,000" max="99999"  required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h4>&nbsp;</h4>
                                            <div class="block block-drop-shadow">
                                                <div class="head bg-dot20">
                                                    <h6>SEP</h6>
                                                    <div class="form-row" id="s1">
                                                        <div class="col-md-1">Low:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_low" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                        <div class="col-md-1">Middle:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_middle" class="form-control" placeholder="Count/100,000" max="99999"  required/>
                                                        </div>
                                                        <div class="col-md-1">High:</div>
                                                        <div class="col-md-3" id="v_code">
                                                            <input type="number" name="bact_high" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="pull-right col-md-3">
                                    <input type="submit" name="add_prev" value="SAVE" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    <?php }
                    elseif ($_GET['id'] == 2){?>
                        <div class="header">
                            <h2>CLUSTER PREVALENCE SURVEY INFORMATION</h2>
                        </div>
                        <p>&nbsp;</p>
                        <div class="block col-md-12">
                            <div class="alert alert-info">
                                <b>NOTE : </b> <strong >If information is not available, please enter 999999. With exception of latitude and Longitude</strong>
                            </div>
                        </div>
                        <form method="post">
                            <div class="modal-body clearfix">
                                <div class="controls">
                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">SELECT YEAR:</div>
                                        <div class="col-md-4" id="v_code">
                                            <select class="form-control" id="year" name="case_year" required="">
                                                <option value=""> Year</option>
                                                <?php $x=2008;while ($x<=2019){?>
                                                    <option value="<?=$x?>"><?=$x?></option>
                                                    <?php $x++;}?>
                                            </select>
                                        </div>
                                    </div>
                                    <h6>&nbsp;</h6>
                                    <h4>Cluster Demographic Information</h4><br>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Cluster Name:</div>
                                        <div class="col-md-9" id="v_code">
                                            <input type="text" name="cluster_name" class="form-control" placeholder=""  required/>
                                        </div>
                                    </div>

                                    <h4>&nbsp;</h4>
                                    <h4>GPS</h4><br>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Latitude:</div>
                                        <div class="col-md-4" id="v_code">
                                            <input type="text" name="latitude" class="form-control" placeholder="" />
                                        </div>
                                        <div class="col-md-1">Longitude:</div>
                                        <div class="col-md-4" id="v_code">
                                            <input type="text" name="longitude" class="form-control" placeholder=""  />
                                        </div>
                                    </div>
                                    <h4>&nbsp;</h4>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-12">Bacteriologically confirmed pulmonary tuberculosis prevalence:</div>
                                        <div class="col-md-10" id="v_code">
                                            <input type="number" name="case_detected" class="form-control" placeholder="Count/100,000" max="99999" required/>
                                        </div>
                                    </div>
                                    <h1>&nbsp;</h1>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="pull-right col-md-3">
                                    <input type="submit" name="add_demo" value="SAVE" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    <?php }
                    elseif ($_GET['id'] == 3){?>
                        <div class="header">
                            <h2>ROUTINE DATA</h2>
                        </div>
                        <p>&nbsp;</p>
                        <div class="block col-md-12">
                            <div class="alert alert-info">
                                <b>NOTE : </b> <strong >If information is not available, please enter 99999</strong>
                            </div>
                        </div>
                        <form method="post">
                            <div class="modal-body clearfix">
                                <div class="controls">
                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">SELECT YEAR:</div>
                                        <div class="col-md-4" id="v_code">
                                            <select class="form-control" id="year" name="case_year" required="">
                                                <option value=""> Year</option>
                                                <?php $x=2008;while ($x<=2019){?>
                                                    <option value="<?=$x?>"><?=$x?></option>
                                                    <?php $x++;}?>
                                            </select>
                                        </div>
                                    </div>
                                    <h6>&nbsp;</h6>
                                    <h4>New</h4><br>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-3">Bacteriological confirmed TB cases:</div>
                                        <div class="col-md-7" id="v_code">
                                            <input type="number" name="bact_conf_tb" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-3">Pulmonary Clinically diagnosed TB cases:</div>
                                        <div class="col-md-7" id="v_code">
                                            <input type="number" name="pul_clinc_diag_tb" class="form-control"   max="999999" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-3">Extra-pulmonary Clinically diagnosed:</div>
                                        <div class="col-md-7" id="v_code">
                                            <input type="number" name="extra_pul_diag_tb" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <h6>&nbsp;</h6>
                                    <h6>&nbsp;</h6>
                                    <h4>Previously treated</h4><br>

                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">Relapse:</div>
                                        <div class="col-md-8" id="v_code">
                                            <input type="number" name="relapse" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">Treatment after failure:</div>
                                        <div class="col-md-8" id="v_code">
                                            <input type="number" name="treatment_after_failure" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">Return after lost to follow up:</div>
                                        <div class="col-md-8" id="v_code">
                                            <input type="number" name="return_after_lost_follow_up" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">Other previously treated:</div>
                                        <div class="col-md-8" id="v_code">
                                            <input type="number" name="other_previously_treated" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <h6>&nbsp;</h6>
                                    <h6>&nbsp;</h6>
                                    <h4>HIV Information</h4><br>

                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">Number Tested:</div>
                                        <div class="col-md-8" id="v_code">
                                            <input type="number" name="hiv_no_tested" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">HIV Positive Cases:</div>
                                        <div class="col-md-8" id="v_code">
                                            <input type="number" name="hiv_positive_case" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">Registered For HIV Care:</div>
                                        <div class="col-md-8" id="v_code">
                                            <input type="number" name="hiv_register_for_care" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">Started ARV:</div>
                                        <div class="col-md-8" id="v_code">
                                            <input type="number" name="hiv_start_art" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-row" id="s1">
                                        <div class="col-md-2">Started CPT:</div>
                                        <div class="col-md-8" id="v_code">
                                            <input type="number" name="hiv_started_cpt" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
                                    <h4>&nbsp;</h4>
                                    <div class="block">
                                        <div class="header">
                                            <h2>TB treatment outcome of new and relapse TB cases &nbsp;&nbsp;<strong style="color: #1DC116">( NOTE : If information is not available, please enter 999999 )</strong></h2>
                                        </div>
                                        <div class="content">
                                            <table class="table table-bordered table-striped table-hover">
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
                                                    <td><input type="number" name="nw_cured_bact_conf" class="form-control" max="999999" required></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><input type="number" name="nw_cured_relapse" class="form-control" max="999999" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Treatment completed</td>
                                                    <td><input type="number" name="nw_tc_bact_conf" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_tc_cli_diag" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_tc_cli_diag_extra" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_tc_relapse" class="form-control" max="999999" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Treatment Success</td>
                                                    <td><input type="number" name="nw_ts_bact_conf" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_ts_cli_diag" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_ts_cli_diag_extra" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_ts_relapse" class="form-control" max="999999" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Failure</td>
                                                    <td><input type="number" name="nw_fl_bact_conf" class="form-control" max="999999" required></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><input type="number" name="nw_fl_relapse" class="form-control" max="999999" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Died</td>
                                                    <td><input type="number" name="nw_died_bact_conf" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_died_cli_diag" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_died_cli_diag_extra" class="form-control" required></td>
                                                    <td><input type="number" name="nw_died_relapse" class="form-control" max="999999" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Lost to follow up</td>
                                                    <td><input type="number" name="nw_lf_bact_conf" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_lf_cli_diag" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_lf_cli_diag_extra" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="nw_lf_relapse" class="form-control" max="999999" required></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <h4>&nbsp;</h4>
                                    <div class="block">
                                        <div class="header">
                                            <h2>Treatment outcome of previously treated (except relapse) cases &nbsp;&nbsp;<strong style="color: #1DC116">( NOTE : If information is not available, please enter 999999 )</strong></h2>
                                        </div>
                                        <div class="content">
                                            <table class="table table-bordered table-striped table-hover">
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
                                                    <td><input type="number" name="prev_cure_treat_failure" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_cure_treat_lst_flw" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_cure_prev_treat" class="form-control" max="999999" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Treatment completed</td>
                                                    <td><input type="number" name="prev_tc_treat_failure" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_tc_treat_lst_flw" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_tc_prev_treat" class="form-control" max="999999" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Treatment Success</td>
                                                    <td><input type="number" name="prev_ts_treat_failure" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_ts_treat_lst_flw" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_ts_prev_treat" class="form-control" max="999999" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Failure</td>
                                                    <td><input type="number" name="prev_fl_treat_failure" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_fl_treat_lst_flw" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_fl_prev_treat" class="form-control" max="999999" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Died</td>
                                                    <td><input type="number" name="prev_died_treat_failure" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_died_treat_lst_flw" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_died_prev_treat" class="form-control" max="999999" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Lost to follow up</td>
                                                    <td><input type="number" name="prev_lf_treat_failure" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_lf_treat_lst_flw" class="form-control" max="999999" required></td>
                                                    <td><input type="number" name="prev_lf_prev_treat" class="form-control" max="999999" required></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="pull-right col-md-3">
                                    <input type="submit" name="routine_data" value="SAVE" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    <?php }
                    elseif ($_GET['id'] == 4){ ?>
                        <div class="header">
                            <h2>MDRTB Notification</h2>
                        </div>
                        <p>&nbsp;</p>
                        <div class="block col-md-12">
                            <div class="alert alert-info">
                                <b>NOTE : </b> <strong >If information is not available, please enter 99999</strong>
                            </div>
                        </div>
                        <form method="post">
                            <div class="modal-body clearfix">
                                <h1>&nbsp;</h1>
                                <h6>MDR TB notified total for ten years 2009-2018 (presented in yearly data) </h6>
                                <h1>&nbsp;</h1>
                                <div class="controls">
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">SELECT YEAR:</div>
                                        <div class="col-md-4" id="v_code">
                                            <select class="form-control" id="year" name="total_mdr_year" required="">
                                                <option value=""> Year</option>
                                                <?php $x=2009;while ($x<=2018){?>
                                                    <option value="<?=$x?>"><?=$x?></option>
                                                    <?php $x++;}?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">Number of MDR cases:</div>
                                        <div class="col-md-4" id="v_code">
                                            <input type="number" name="total_no_mdr_cases" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>

                                    <h1>&nbsp;</h1>
                                    <h6><strong><i>MDR TB notified in three most affected regions for year <strong style="color: orangered;font-size: large" id="pyr"></strong> (presented in yearly data)</i></strong></h6>
                                    <h1>&nbsp;</h1>
<!--                                    1st-->
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Position:</div>
                                        <div class="col-md-2" id="v_code">
                                            <select class="form-control" id="" name="region_mdr_position_1st" required="">
                                                <option value="1st">1st</option>
                                            </select>
                                        </div>

<!--                                        <div class="col-md-1">Year:</div>-->
<!--                                        <div class="col-md-2" id="v_code">-->
<!--                                            <select class="form-control" id="year" name="region_mdr_year" required="">-->
<!--                                                <option value=""> Year</option>-->
<!--                                                --><?php //$x=2009;while ($x<=2018){?>
<!--                                                    <option value="--><?//=$x?><!--">--><?//=$x?><!--</option>-->
<!--                                                    --><?php //$x++;}?>
<!--                                            </select>-->
<!--                                        </div>-->
                                        <div class="col-md-1">Region:</div>
                                        <div class="col-md-2" id="v_code">
                                            <input type="text" name="1st_region_mdr" class="form-control"  required=""/>
                                        </div>
                                        <div class="col-md-1">Number of MDR cases:</div>
                                        <div class="col-md-2" id="v_code">
                                            <input type="number" name="1st_region_no_mdr_cases" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
<!--                                    2nd-->
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Position:</div>
                                        <div class="col-md-2" id="v_code">
                                            <select class="form-control" id="" name="region_mdr_position_2nd" required="">
                                                <option value="2nd">2nd</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1">Region:</div>
                                        <div class="col-md-2" id="v_code">
                                            <input type="text" name="2nd_region_mdr" class="form-control"  required=""/>
                                        </div>
                                        <div class="col-md-1">Number of MDR cases:</div>
                                        <div class="col-md-2" id="v_code">
                                            <input type="number" name="2nd_region_no_mdr_cases" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
<!--                                    3rd-->
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Position:</div>
                                        <div class="col-md-2" id="v_code">
                                            <select class="form-control" id="" name="region_mdr_position_3rd" required="">
                                                <option value="3rd">3rd</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">Region:</div>
                                        <div class="col-md-2" id="v_code">
                                            <input type="text" name="3rd_region_mdr" class="form-control"  required=""/>
                                        </div>
                                        <div class="col-md-1">Number of MDR cases:</div>
                                        <div class="col-md-2" id="v_code">
                                            <input type="number" name="3rd_region_no_mdr_cases" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>

                                    <h1>&nbsp;</h1>
                                    <h6><strong><i>MDR TB notified per gender for year <strong style="color: orangered;font-size: large" id="gyr"></strong> (presented in yearly data)</i></strong></h6>
                                    <h1>&nbsp;</h1>
<!--                                    male-->
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Gender:</div>
                                        <div class="col-md-3" id="v_code">
                                            <select class="form-control" id="year" name="male_mdr_sex" required="">
                                                <option value="Male">Male</option>
                                            </select>
                                        </div>

<!--                                        <div class="col-md-1">Year:</div>-->
<!--                                        <div class="col-md-2" id="v_code">-->
<!--                                            <select class="form-control" id="year" name="gender_mdr_year" required="">-->
<!--                                                <option value=""> Year</option>-->
<!--                                                --><?php //$x=2009;while ($x<=2018){?>
<!--                                                    <option value="--><?//=$x?><!--">--><?//=$x?><!--</option>-->
<!--                                                    --><?php //$x++;}?>
<!--                                            </select>-->
<!--                                        </div>-->
                                        <div class="col-md-2">Number of MDR cases:</div>
                                        <div class="col-md-3" id="v_code">
                                            <input type="number" name="male_no_mdr_cases" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>
<!--                                    female-->
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Gender:</div>
                                        <div class="col-md-3" id="v_code">
                                            <select class="form-control" id="year" name="female_mdr_sex" required="">
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">Number of MDR cases:</div>
                                        <div class="col-md-3" id="v_code">
                                            <input type="number" name="female_no_mdr_cases" class="form-control"  max="999999" required=""/>
                                        </div>
                                    </div>

                                    <h1>&nbsp;</h1>
                                    <h6><strong><i>Treatment outcome for MDR TB for year <strong id="tyr" style="color: orangered;font-size: large" ></strong> (presented in yearly data)</i></strong></h6>
                                    <h1>&nbsp;</h1>
<!--                                    enrolled-->
                                    <div class="form-row" id="s1">
<!--                                        <div class="col-md-1">Year:</div>-->
<!--                                        <div class="col-md-2" id="v_code">-->
<!--                                            <select class="form-control" id="year" name="trmnt_mdr_year" required="">-->
<!--                                                <option value=""> Year</option>-->
<!--                                                --><?php //$x=2009;while ($x<=2018){?>
<!--                                                    <option value="--><?//=$x?><!--">--><?//=$x?><!--</option>-->
<!--                                                    --><?php //$x++;}?>
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                    Enrolled-->
                                        <div class="col-md-1">Treatment outcome:</div>
                                        <div class="col-md-3" id="v_code">
                                            <select class="form-control" id="year" name="trmnt_mdr_outcome_enrolled" required="">
                                                <option value="Enrolled for treatment">Enrolled for treatment</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">Number of MDR cases:</div>
                                        <div class="col-md-3" id="v_code">
                                            <input type="number" name="trmnt_no_mdr_cases_enrolled" class="form-control"  max="999999" required=""/>
                                        </div>

                                    </div>
<!--                                    cured-->
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Treatment outcome:</div>
                                        <div class="col-md-3" id="v_code">
                                            <select class="form-control" id="year" name="trmnt_mdr_outcome_cured" required="">
                                                <option value="Cured">Cured</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">Number of MDR cases:</div>
                                        <div class="col-md-3" id="v_code">
                                            <input type="number" name="trmnt_no_mdr_cases_cured" class="form-control"  max="999999" required=""/>
                                        </div>

                                    </div>
<!--                                    complete-->
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Treatment outcome:</div>
                                        <div class="col-md-3" id="v_code">
                                            <select class="form-control" id="year" name="trmnt_mdr_outcome_completed" required="">
                                                <option value="Completed">Completed</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">Number of MDR cases:</div>
                                        <div class="col-md-3" id="v_code">
                                            <input type="number" name="trmnt_no_mdr_cases_completed" class="form-control"  max="999999" required=""/>
                                        </div>

                                    </div>
<!--                                    fail-->
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Treatment outcome:</div>
                                        <div class="col-md-3" id="v_code">
                                            <select class="form-control" id="year" name="trmnt_mdr_outcome_failed" required="">
                                                <option value="Failed">Failed</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">Number of MDR cases:</div>
                                        <div class="col-md-3" id="v_code">
                                            <input type="number" name="trmnt_no_mdr_cases_failed" class="form-control"  max="999999" required=""/>
                                        </div>

                                    </div>
<!--                                    die-->
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Treatment outcome:</div>
                                        <div class="col-md-3" id="v_code">
                                            <select class="form-control" id="year" name="trmnt_mdr_outcome_died" required="">
                                                <option value="Died">Died</option>
                                                <option value="Treatment success">Treatment success</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">Number of MDR cases:</div>
                                        <div class="col-md-3" id="v_code">
                                            <input type="number" name="trmnt_no_mdr_cases_died" class="form-control"  max="999999" required=""/>
                                        </div>

                                    </div>
<!--                                    success-->
                                    <div class="form-row" id="s1">
                                        <div class="col-md-1">Treatment outcome:</div>
                                        <div class="col-md-3" id="v_code">
                                            <select class="form-control" id="year" name="trmnt_mdr_outcome_success" required="">
                                                <option value="Treatment success">Treatment success</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">Number of MDR cases:</div>
                                        <div class="col-md-3" id="v_code">
                                            <input type="number" name="trmnt_no_mdr_cases_success" class="form-control"  max="999999" required=""/>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="pull-right col-md-3">
                                    <input type="submit" name="mdr_data" value="SAVE" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    <?php }?>
                </div>
            </div>
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
        $('#year').change(function(){
            var c_yr = $(this).val();
            $.ajax({
                success:function(data){
                    $('#pyr').html(c_yr);
                    $('#gyr').html(c_yr);
                    $('#tyr').html(c_yr);
                    //$('#w_i').hide();
                }
            });
        });
    });
</script>
<script>

</script>
</html>