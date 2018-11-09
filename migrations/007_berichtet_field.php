<?php

class BerichtetField extends Migration
{
    public function description()
    {
        return 'Add field for berichtet and email';
    }

    public function up()
    {
        $db = DBManager::get();

        $query = "ALTER TABLE `doktorandenverwaltung` ADD `berichtet` INT(4) AFTER `complete_progress`";
        $db->exec($query);
        $query = "ALTER TABLE `doktorandenverwaltung` ADD `email` varchar(255) AFTER `complete_progress`";
        $db->exec($query);
        SimpleORMap::expireTableScheme();
        
        $query = "UPDATE `doktorandenverwaltung` "
                . "SET `berichtet` = '2017' "
                . "WHERE 1";
        $db->exec($query);
    }

    public function down()
    {
    }
}
