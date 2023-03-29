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

$PAGE->set_url('/local/plugin/create_user.php');
require_login();
$context = context_system::instance();
admin_externalpage_setup('userdata', '', $pageparams);

$header = $SITE->fullname;
$PAGE->set_title(get_string('pluginname', 'local_plugin'));
$PAGE->set_heading($header);



class create_user_form extends moodleform {

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

        $mform->addElement('text', 'username', get_string('username', 'local_plugin'), array('size' => 40, 'maxlength = "50"', 'pattern' => '[A-Za-z0-9-|:~`!@#$%^+&,)\-=}({:;>.|<@?/<!&$_ ]+'));
        $mform->setType('username', PARAM_TEXT);
        $mform->addRule('username', get_string('required', 'local_plugin'), 'required', null, 'client');
        $mform->addRule('username', get_string('maximumchars', 'local_plugin', 50), 'maxlength', 50, 'client');
       

        $mform->addElement('text', 'firstname', get_string('firstname', 'local_plugin'), array('size' => 40, 'maxlength = "50"', 'pattern' => '[A-Za-z0-9-|:~`!@#$%^+&,)\-=}({:;>.|<@?/<!&$_ ]+'));
        $mform->setType('firstname', PARAM_TEXT);
        $mform->addRule('firstname', get_string('required', 'local_plugin'), 'required', null, 'client');
        $mform->addRule('firstname', get_string('maximumchars', 'local_plugin', 50), 'maxlength', 50, 'client');
        

        $mform->addElement('text', 'lastname', get_string('lastname', 'local_plugin'), array('size' => 40, 'maxlength = "50"', 'pattern' => '[A-Za-z0-9-|:~`!@#$%^+&,)\-=}({:;>.|<@?/<!&$_ ]+'));
        $mform->setType('lastname', PARAM_TEXT);
        $mform->addRule('lastname', get_string('required', 'local_plugin'), 'required', null, 'client');
        $mform->addRule('lastname', get_string('maximumchars', 'local_plugin', 50), 'maxlength', 50, 'client');
      

        $mform->addElement('text', 'email', get_string('email', 'local_plugin'), array('size' => 40, 'maxlength = "35"'));
        $mform->setType('email', PARAM_RAW);
        $mform->addRule('email', get_string('required', 'local_plugin'), 'required', null, 'client');
        $mform->addRule('email', get_string('maximumchars', 'local_plugin', 35), 'maxlength', 35, 'client');
		$mform->addRule('email', get_string('emailformat', 'local_plugin'), 'email', null, 'client');
       
        $mform->addElement('text', 'employee_number', get_string('employee_number', 'local_plugin'), array('size' => 40, 'maxlength = "50"', 'pattern' => '[A-Za-z0-9-|:~`!@#$%^+&,)\-=}({:;>.|<@?/<!&$_ ]+'));
        $mform->setType('employee_number', PARAM_TEXT);
        $mform->addRule('employee_number', get_string('maximumchars', 'local_plugin', 50), 'maxlength', 50, 'client');
        
        $mform->addElement('text', 'organizational_unit', get_string('organizational_unit', 'local_plugin'), array('size' => 40, 'maxlength = "50"', 'pattern' => '[A-Za-z0-9-|:~`!@#$%^+&,)\-=}({:;>.|<@?/<!&$_ ]+'));
        $mform->setType('organizational_unit', PARAM_TEXT);
        $mform->addRule('organizational_unit', get_string('maximumchars', 'local_plugin', 50), 'maxlength', 50, 'client');
        

        $mform->addElement('text', 'position', get_string('position', 'local_plugin'), array('size' => 40, 'maxlength = "50"', 'pattern' => '[A-Za-z0-9-|:~`!@#$%^+&,)\-=}({:;>.|<@?/<!&$_ ]+'));
        $mform->setType('position', PARAM_TEXT);
        $mform->addRule('position', get_string('maximumchars', 'local_plugin', 50), 'maxlength', 50, 'client');
        
    
		// Action buttons.
        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', get_string('userdata-submit', 'local_plugin'));
        $buttonarray[] = $mform->createElement('cancel');
        $mform->addGroup($buttonarray, 'buttonar', '', '', false);
    }
   

   public function validation($text, $files) {

    global $DB, $CFG;
    $errors = parent::validation($text, $files);
    return $errors;
}
}

echo $OUTPUT->header();
$mform = new create_user_form();

if ($mform->is_cancelled()) {
    echo "<script>
    alert('form cancelled');
    </script>";
} else if($text = $mform->get_data()) {
   $employee_number = $text->employee_number;
   $organizational_unit = $text->organizational_unit;
   $position = $text->position;
   $username = $text->username;
   $existingdata = $DB->get_record('user', array('username' => $username));
if($existingdata == ''){
    if($employee_number == '' || $organizational_unit == '' || $position == ''){
      echo "<script>
      alert('unset data will be added as nool to database');
      </script>";
      $user = new stdClass();
      $user->username = $text->username;
      $user->password = 'g,mdhsfgkjdshgfusdf%%%%#3567384872634Q'; 
      $user->firstname = $text->firstname;
      $user->lastname = $text->lastname;
      $user->email = $text->email;
      $user->city = '';
      $user->country = '';
      $user->lang = 'en';
      $user->timezone = '99';
      $user->maildisplay = 1;
      $user->description = '';
      $user->descriptionformat = 1;
      $user->mailformat = 1;
      $user->maildigest = 0;
      $user->maildisplay = 1;
      $user->autosubscribe = 0;
      $user->trackforums = 0;
      $user->timemodified = time();
      $user_id = user_create_user($user);
      if ($user_id) {
          echo "<script>
          alert('Użytkownik dodany do bazy danych');
          </script>";
      } else {
          echo "Nie udało się dodać użytkownika do bazy danych";
      }
    }
    else{
        $user = new stdClass();
        $user->username = $text->username;
        $user->password = 'Macieus11@eee'; // replace with a strong password
        $user->firstname = $text->firstname;
        $user->lastname = $text->lastname;
        $user->email = $text->email;
        $user->organizational_unit_id = $text->organizational_unit;
        $user->position_id = $text->position;
        $user->employee_number = $text->employee_number;
        $user->city = '';
        $user->country = '';
        $user->lang = 'en';
        $user->timezone = '99';
        $user->maildisplay = 1;
        $user->description = '';
        $user->descriptionformat = 1;
        $user->mailformat = 1;
        $user->maildigest = 0;
        $user->maildisplay = 1;
        $user->autosubscribe = 0;
        $user->trackforums = 0;
        $user->timemodified = time();
        $user_id = user_create_user($user);
        if ($user_id) {
            echo "<script>
            alert('Użytkownik dodany do bazy danych');
            </script>";
        }
    }
    }
}




echo "<a href='userdata.php'>Go back to userdata page</a>";
$mform->display();

echo $OUTPUT->footer();
?>


