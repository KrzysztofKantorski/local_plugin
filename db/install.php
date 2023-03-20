<?php
require_once($CFG->dirroot . '/lib/xmldb/xmldb_table.php');
function xmldb_local_plugin_install() {
    global $DB;
    $sql = "CREATE TABLE {local_plugin} (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            username VARCHAR(255) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            employee_number VARCHAR(255) NOT NULL,
            organizational_unit VARCHAR(255) NOT NULL,
            position VARCHAR(255) NOT NULL,
            position_id INT(10),
            organizational_unit_id INT(10),
            PRIMARY KEY (id)
    ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $DB->execute($sql);
    $sql1 = "CREATE TABLE {local_position} (
        id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        username VARCHAR(255) NOT NULL,
        firstname VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $DB->execute($sql1);
    $sql2 = "CREATE TABLE {local_organizational_unit} (
        id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        username VARCHAR(255) NOT NULL,
         firstname VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
        ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $DB->execute($sql2);
    
}

?>