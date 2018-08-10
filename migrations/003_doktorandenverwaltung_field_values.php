<?php

class DoktorandenverwaltungFieldValues extends Migration
{
    public function description()
    {
        return 'Add field_values table for Doktorandenverwaltung';
    }

    public function up()
    {
        $db = DBManager::get();

        // add db-table
        $db->exec("CREATE TABLE IF NOT EXISTS `doktorandenverwaltung_field_values` (
            `id` int(11) NOT NULL,
            `field_id` varchar(32) NOT NULL,
            `his_id` varchar(32) NOT NULL,
            `lid` varchar(32) NULL,
            `uniquename` varchar(32) NULL,
            `defaulttext` varchar(150) NOT NULL,
            `astat_bund` varchar(32) NULL,
            PRIMARY KEY (id)
        ) ");

//        $query = "INSERT INTO `doktorandenverwaltung_fieldsVvalues` (`id`, `title`, `default`, `overview_position`, `group`, `group_position`, `fill`, `values`, `export`) 
//           VALUES 
//           ('berichtseinheitid', 'BerichtseinheitID', '5300000', NULL, '', NULL, 'auto', NULL, '1'),
//            ";
//        
//        $db->exec($query);
        
        
        SimpleORMap::expireTableScheme();
    }

    public function down()
    {
        $db = DBManager::get();

        $db->exec("DROP TABLE doktorandenverwaltung_field_values");

        SimpleORMap::expireTableScheme();
    }
}
