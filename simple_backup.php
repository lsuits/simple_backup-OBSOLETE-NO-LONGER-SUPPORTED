<?php
require_once(dirname(__FILE__) . '/../../config.php');
global $CFG,$COURSE, $PAGE;

require_login();
$c = $COURSE;
$PAGE->set_context(context_course::instance($c->id));
$PAGE->set_url('/local/simple_backup/simple_backup.php');
require_once($CFG->dirroot.'/local/simple_backup/lib.php');



$sb = new simple_backup();
$sb->run();

?>
