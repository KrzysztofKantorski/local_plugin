<?php
require_once($CFG->dirroot . '/lib/xmldb/xmldb_table.php');
function xmldb_local_plugin_install() {
    global $DB;

    $sql2 = "ALTER TABLE {user} ADD position_id INT(10) NULL DEFAULT NULL COLLATE utf8mb4_general_ci AFTER lastname";
    $DB->execute($sql2);

    $sql5="ALTER TABLE {user} ADD organizational_unit_id INT(10) NULL DEFAULT NULL COLLATE utf8mb4_general_ci AFTER position_id";
    $DB->execute($sql5);
    $sql6 ="ALTER TABLE {user} ADD employee_number VARCHAR(255) NULL DEFAULT NULL COLLATE utf8mb4_general_ci AFTER organizational_unit_id";
    $DB->execute($sql6);


    $sql = "CREATE TABLE {position} (
        id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        PRIMARY KEY (id)
    ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $DB->execute($sql);

    $sql4 = "CREATE TABLE {organizational_unit} (
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id)
    ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $DB->execute($sql4);

    $sql1 = "ALTER TABLE {position} ADD position INT(10) NULL DEFAULT NULL COLLATE utf8mb4_general_ci AFTER id";
    $DB->execute($sql1);

    $sql3="ALTER TABLE {organizational_unit} ADD organizational_unit INT(10) NULL DEFAULT NULL COLLATE utf8mb4_general_ci AFTER id";
    $DB->execute($sql3);
    
}

?>