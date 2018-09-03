<?php

class DoktorandenverwaltungAddColumns extends Migration
{
    public function description()
    {
        return 'Add more columns';
    }

    public function up()
    {
        $db = DBManager::get();

        $query = "ALTER TABLE `doktorandenverwaltung` ADD `complete_progress` int(11) NULL AFTER `ef038` ;";
        $db->exec($query); 
        
        SimpleORMap::expireTableScheme();
    }

    public function down()
    {
    }
}
