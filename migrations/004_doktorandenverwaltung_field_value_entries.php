<?php

class DoktorandenverwaltungFieldValueEntries extends Migration
{
    public function description()
    {
        return 'Add some entries to field_values-table for Doktorandenverwaltung';
    }

    public function up()
    {
        $db = DBManager::get();

        $query = "INSERT INTO `doktorandenverwaltung_field_values` (`id`, `field_id`, `his_id`, `lid`, `uniquename`, `defaulttext`, `astat_bund`) 
            VALUES 
            (NULL, 'ef005', '1', NULL, '1', 'männlich', NULL), 
            (NULL, 'ef005', '2', NULL, '2', 'weiblich', NULL),
            (NULL, 'ef008', '000', NULL, 000, 'Deutschland', NULL),
            (NULL, 'ef012', '1', NULL, '1', 'Erstregistrierung', NULL),
            (NULL, 'ef012', '2', NULL, '2', 'Neuregistrierung', NULL),
            (NULL, 'ef015', '1', NULL, '1', 'Ja', NULL),
            (NULL, 'ef015', '0', NULL, '0', 'Nein', NULL),
            (NULL, 'ef016', '1', NULL, '1', 'Ja', NULL),
            (NULL, 'ef016', '0', NULL, '0', 'Nein', NULL),
            (NULL, 'ef017', '1', NULL, '1', 'Ja', NULL),
            (NULL, 'ef017', '0', NULL, '0', 'Nein', NULL),
            (NULL, 'ef018', '1', NULL, '1', 'Monografie', NULL),
            (NULL, 'ef018', '2', NULL, '2', 'publikationsbasierte/kumulative Dissertation', NULL),
            (NULL, 'ef021', '1', NULL, '1', 'Sommersemester', NULL),
            (NULL, 'ef021', '2', NULL, '2', 'Wintersemester', NULL),
            (NULL, 'ef023', '0', NULL, '0', 'wurde noch nicht abgelegt', NULL),
            (NULL, 'ef023', '1', NULL, '1', 'wurde abgelegt und bestanden', NULL)
            ";
        
        $db->exec($query);
        
        
        SimpleORMap::expireTableScheme();
    }

    public function down()
    {
    }
}
