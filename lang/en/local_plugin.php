<?php

/*  DOCUMENTATION
    .............

    Create a 'lang' and inside 'en' folder (lang/en), where 'en' is the English language file for your block. If you are not
    an English speaker, you can replace 'en' with your appropriate language code. All language files for blocks go under the
    /lang subfolder of the block's installation folder.

    Strings are defined via the associative array $string provided by the string file. The array key is the string identifier,
    the value is the string text in the given language. Moodle supports over 100 languages (en (english), fr(french) etc.,).
    en (English) is the default language.

    It is mandatory that any manual text must be written in language strings for Moodle to identify the language defined in
    lang folder.

*/

$string['pluginname'] = 'Slack'; // Name of your plugin.

// settings.php
$string['userdata'] = 'Userdata';
$string['usermetadata'] = 'User-Metadata';
$string['userloggedin'] = 'User-Login';
// Unique.
$string['required'] = 'You must supply a value here!';
$string['maximumchars'] = 'Maximum of {$a} characters!';
$string['alphanumeric'] = 'Only numbers and letters are allowed.';
$string['userdata-submit'] = 'Submit userdata';

// userdata.php
$string['mformheader'] = 'Userdata Form';

$string['fullname'] = 'Fullname';
$string['fullname_help'] = 'Enter user fullname';

$string['password'] = 'Password';
$string['maximumchars'] = 'Maximum characters';
$string['password_help'] = 'Enter profile password';

$string['email'] = 'Email';
$string['emailformat'] = 'Incorrect email format';
$string['email_help'] = 'Enter email';

$string['age'] = 'Age';
$string['age_help'] = 'Enter user age';

$string['proftip'] = 'A profession would have a better understanding of your technical skills.';

$string['saveskills'] = 'Save your skills (default checked)';
$string['saveskills_help'] = 'Save your skills';

$string['saveclass'] = 'Do you wish to participate in skill workshop?';
$string['saveclass_help'] = 'Do you wish to participate in skill workshop?';

$string['profession'] = 'Profession';
$string['prof_select'] = 'Select your profession';
$string['prof_software'] = 'Software Professional';
$string['prof_education'] = 'Professor/Teacher/Instructor';
$string['prof_business'] = 'Business Owner/Business Partner';
$string['prof_student'] = 'Student';
$string['prof_agric'] = 'Farmer';
$string['profession_help'] = 'Select your nearest profession';
$string['error_profession'] = 'Select your profession';

$string['introexp'] = 'Share your experience';
$string['introexp_help'] = 'Share your experience';

$string['dob'] = 'Date of Birth';
$string['dob_help'] = 'Enter date of birth';
$string['error_dob'] = 'Enter date of birth';

$string['userstartdate'] = 'Start date';
$string['userstartdate_help'] = 'Enter start date of your availability';

$string['userenddate'] = 'End date';
$string['userenddate_help'] = 'Enter end date of your availability';

$string['userpic'] = 'User picture';
$string['userpic_help'] = 'Upload user profile picture';

$string['certificate'] = 'Certificate';
$string['certificate_help'] = 'Upload your profession certificate';

$string['multimedia'] = 'Multimedia';
$string['multimedia_help'] = 'Upload video or audio(optional)';

$string['description'] = 'Description';
$string['description_help'] = 'Introduce yourself';

$string['metadata'] = 'User-Metadata';
$string['metadatah'] = 'User-Metadata';
$string['metadatah_help'] = 'User-Metadata';
