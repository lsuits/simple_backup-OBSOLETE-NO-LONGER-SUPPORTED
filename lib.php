<?php

global $CFG,$PAGE,$COURSE;

require_once($CFG->dirroot.'/backup/util/interfaces/checksumable.class.php');
require_once($CFG->dirroot.'/backup/backup.class.php');
require_once($CFG->dirroot.'/backup/util/settings/base_setting.class.php');
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot . '/backup/controller/backup_controller.class.php');


/**
 * Nav code ripped from Moodle API docs
 * @TODO - update and correct
 */
$coursenode = $PAGE->navigation->find($COURSE->id, navigation_node::TYPE_COURSE);
$thingnode = $coursenode->add('simple bkp', new moodle_url('/local/simple_backup/simple_backup.php'));
$thingnode->make_active();

class simple_backup{
    public static function run(){
        global $USER,$COURSE,$CFG;
        
//-------------------------- settings' config --------------------------------//
        //enable disired boolean-valued settings
        $included_bool_stg_names = array('activities','blocks','filters',);
        //disable user- and other unwanted- settings
        $excluded_bool_stg_names = array('users','role_assignments');
        //other settings defined here as name=>value pairs
        $other                   = array('filename'=>'thisisonlyatestofafilename');
//-------------------------- end  config -------------------------------------//
        
        
        $bc = new backup_controller(backup::TYPE_1COURSE, $COURSE->id,
            backup::FORMAT_MOODLE, backup::INTERACTIVE_NO, backup::MODE_AUTOMATED, $USER->id);
        
        /**
         * backup_controller->plan->settings update utility function
         */
        $update_plan_stg = function($stg_name, $val) use($bc){
            $plan = $bc->get_plan();
            $stg_name = $plan->get_setting($stg_name);
            $stg_name->set_value($val);
        };
        
//-------------------------- update settings-- -------------------------------//
        array_map($update_plan_stg, $excluded_bool_stg_names, array(0));
        array_map($update_plan_stg, $included_bool_stg_names, array(1));
        array_map($update_plan_stg, array_keys($other), array_values($other));
//-------------------------- end update settings -----------------------------//        
        
        $outcome = $bc->execute_plan();

        $results = $bc->get_results();
        

/**
 * Beyond here be dragons...@TODO
 */
        
//-------------------------- file handler ------------------------------------//
//-------------------------- UI confirmation screen --------------------------//
    }
}
?>
