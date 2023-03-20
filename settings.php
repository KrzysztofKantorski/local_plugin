<?php
/*  DOCUMENTATION
    .............

    $hassiteconfig which can be used as a quick way to check for the moodle/site:config permission. This variable is set by
	the top-level admin tree population scripts. 
	
	$ADMIN->add('root', new admin_category();
	Add admin settings for the plugin with a root admin category as Slack variable.
	
	$ADMIN->add('slack', new admin_externalpage();
	Add new external pages for your Slack plugin.
*/

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {

    $ADMIN->add('root', new admin_category('plugin', get_string('pluginname', 'local_plugin')));
	
	$ADMIN->add('plugin', new admin_externalpage('userdata', get_string('userdata', 'local_plugin'),
                 new moodle_url('/local/plugin/userdata.php')));
}