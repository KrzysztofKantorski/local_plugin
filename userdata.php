<?php
/*  DOCUMENTATION
    .............

    require('../../config.php');
	It loads all the Moodle core library by initialising the database connection, session, current course, theme and language.
	
	require_once($CFG->libdir.'/adminlib.php');
	states the functions and classes used during installation, upgrades and for admin settings.
	
	$path = optional_param('path', '', PARAM_PATH);
    $pageparams = array();
    if ($path) {
        $pageparams['path'] = $path;
    }
	In Moodle you can call or pass the parameters. As moodle_url doesn't provide you a way of generating the array, so you'll
	have to construct the params yourself. By defining your custom page to the function admin external page.
	
	Core global variables in Moodle are identified using uppercase variables (ie $CFG, $SESSION, $USER, $COURSE, $SITE, $PAGE,
	$DB and $THEME).
	$CFG: $CFG stands for configuration. This global variable contains configuration values of the Moodle setup, such as the
	root directory, data directory, database details, and other config values.
	
	$SESSION: Moodle's wrapper round PHP's $_SESSION.
	
    $USER: Holds the user table record for the current user. This will be the 'guest' user record for people who are not
	logged in.
	
	$SITE: Frontpage course record. This is the course record with id=1.
	
	$COURSE: This global variable holds the current course details. An alias for $PAGE->course.
	
	$PAGE: This is a central store of information about the current page we are generating in response to the user's request.
	ex: $PAGE->set_url('/mod/mymodulename/view.php', array('id' => $cm->id));
        $PAGE->set_title('My modules page title');
        $PAGE->set_heading('My modules page heading');

    $OUTPUT: $OUTPUT is an instance of core_renderer or one of its subclasses. It is used to generate HTML for output.
	ex: echo $OUTPUT->header();
	    echo $OUTPUT->heading($pagetitle);
		
	$CONTEXT: A context is combined with role permissions to define a User's capabilities on any page in Moodle.

    $DB: This holds the database connection details. It is used for all access to the database.

    $PAGE->set_url('/local/slack/userdata.php');
	Every moodle page needs page url through a call to $PAGE->set_url. You are trying to define the page url for setting the 
	custom page.
	
	require_login();
	It verifies that user is logged in before accessing any moodle page.
	
	$PAGE->set_pagelayout('admin'); Set a default pagelayout. 
	(or) 
    $PAGE->set_pagelayout('standard');
	When setting the page layout you should use the layout that is the closest match to the page you are creating. 
    Layouts are used by themes to determine what is shown on the page. There are different layouts that can be, and are used
    throughout Moodle core that you can use within your code. The list of common layouts you are best to look at
	theme/base/config.php or refer to the list below.
	
	It's important to know that the theme determines what layouts are available and how each looks. If you select a layout
	that the theme doesn't support then it will revert to the default layout while using that theme. Themes are also able to 
	specify additional layouts, however its important to spot them and know that while they may work with one theme they are
	unlikely to work as you expect with other themes.
	
	$context = context_system::instance();
	$PAGE->set_context($context);
	Setting the context of the page should call set_context() once with the context that is most appropriate to the page you 
	are creating. If it is a plugin then the context to use would be the context you are using for your capability checks.

    admin_externalpage_setup();
    This function call ensures the user is logged in, and makes sure that they have the proper role permission to access the 
	page.It also configures all $PAGE properties needed for navigation.
	
	$header = $SITE->fullname;
	defines the title of your custom page.
	
	$PAGE->set_title(get_string('pluginname', 'local_slack'));
	defines the title of your plugin at the browser tab.
	
	$PAGE->set_heading($header);
	to display your plugin fullname.

    echo $OUTPUT->header();
	this line prints the header of the page and adds one heading to the page at the top of the content region. Page headings 
	are very important in Moodle and should be applied consistently.
	
	echo $OUTPUT->footer();
	this line prints the footer of the page.
*/

require('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once("$CFG->libdir/formslib.php");
require_once($CFG->dirroot.'/mod/page/locallib.php');
require_once($CFG->dirroot.'/local/plugin/db/install.php');

$path = optional_param('path', '', PARAM_PATH); // $nameofarray = optional_param_array('nameofarray', null, PARAM_INT);
$pageparams = array();

if ($path) {
    $pageparams['path'] = $path;
}

global $CFG, $USER, $DB, $OUTPUT, $PAGE;

$PAGE->set_url('/local/plugin/userdata.php');
require_login();
$context = context_system::instance();
admin_externalpage_setup('userdata', '', $pageparams);

$header = $SITE->fullname;
$PAGE->set_title(get_string('pluginname', 'local_plugin'));
$PAGE->set_heading($header);



class userdata_form extends moodleform {

    /**
     *
     * The definition() function defines the form elements.
     *
     */
    public function definition() {

        global $DB, $CFG, $PAGE, $USER, $context, $instance;
			
		$mform = $this->_form;
		
        /* HEADER
		   mformheader:Userdata Form
		 */		
        $mform->addElement('header', 'mformheader', get_string('mformheader', 'local_plugin'));
        $mform->addElement('filepicker', 'userfile', get_string('file'), null,
            [
                'maxbytes' => '5MB',
                'accepted_types' => array('.csv','.txt'),
            ]
            );
		// Action buttons.
        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', get_string('userdata-submit', 'local_plugin'));
        $buttonarray[] = $mform->createElement('cancel');
        $mform->addGroup($buttonarray, 'buttonar', '', '', false);
    }
   
}
echo $OUTPUT->header();
$mform = new userdata_form();

if ($mform->is_cancelled()) {
    echo "<script>
    alert('form cancelled');
    </script>";
} else if($text = $mform->get_data()) {
    $name = $mform->get_new_filename('userfile');
    $filetype = pathinfo($name, PATHINFO_EXTENSION);
    $allowedTypes = array('csv', 'txt'); // Add txt as an allowed file type
    if (in_array($filetype, $allowedTypes)) {
        $file = fopen($name, 'r');
        // Loop through the data and output it to the screen
        echo "<table style='margin:auto;'>";
        while (($dane= fgetcsv($file)) !== FALSE) {

            // Output each row as a list item
            echo '<li>' . implode(', ', $dane) . '</li>';
        }
    }

        fclose($file);
       $name = $mform->get_new_filename('userfile');
       $file = fopen($name, 'r');
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $record = new stdClass();
            $record->username = $data[0];
            $record->email = $data[1];
            $record->firstname = $data[2];
            $record->lastname = $data[3];
            $record->employee_number = $data[4];
            $record->organizational_unit = $data[5];
            $record->position = $data[6];
            $DB->insert_record('local_plugin', $record);
        }
        fclose($file);
        
    }
        
    echo "</table>";
   






$mform->display();
echo "<a style='margin-left:1000px' href='create_user.php'>Create user</a>";
$name = 'users.csv';
        $file = fopen($name, 'r');
        // Loop through the data and output it to the screen
        echo "<table style='margin:auto;'>";
        
        while (($data= fgetcsv($file)) !== FALSE) {
    
                // Output each row as a list item
                echo"<tr>";
                echo "<td>" . implode(', ', $data) . "</td>";
                echo '</tr>';
        }  
    echo "</table>";
echo $OUTPUT->footer();

?>


