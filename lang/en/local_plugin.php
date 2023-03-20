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

$string['username'] = 'Username';
$string['firstname'] = 'Firstname';
$string['lastname'] = 'Lastname';
$string['employee_number'] = 'Employee_number';
$string['organizational_unit'] = 'Organizational_unit';
$string['position'] = 'Position';
$string['email'] = 'Email';
$string['emailformat'] = 'Incorrect email format';
$string['metadata'] = 'User-Metadata';
$string['metadatah'] = 'User-Metadata';
$string['metadatah_help'] = 'User-Metadata';
