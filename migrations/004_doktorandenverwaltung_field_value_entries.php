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

        $query = "INSERT INTO `doktorandenverwaltung_field_values` (`field_id`, `his_id`, `lid`, `uniquename`, `defaulttext`, `astat_bund`) 
            VALUES 
            ('ef005', '1', NULL, '1', 'männlich', NULL), 
            ('ef005', '2', NULL, '2', 'weiblich', NULL),
            ('ef012', '1', NULL, '1', 'Erstregistrierung', NULL),
            ('ef012', '2', NULL, '2', 'Neuregistrierung', NULL),
            ('ef015', '1', NULL, '1', 'Ja', NULL),
            ('ef015', '0', NULL, '0', 'Nein', NULL),
            ('ef018', '128', NULL, '1', 'Monografie', NULL),
            ('ef018', '129', NULL, '2', 'publikationsbasierte/kumulative Dissertation', NULL),
            ('ef018', '99', NULL, '0', 'undefiniert (von Migration)', NULL),
            ('ef021', '1', NULL, 'SoSe', 'Sommersemester', NULL),
            ('ef021', '2', NULL, 'WiSe', 'Wintersemester', NULL),
            ('ef023', '0', NULL, NULL, 'wurde noch nicht abgelegt', '0'),
            ('ef023', '1', NULL, NULL, 'wurde abgelegt und bestanden', '1'),
            ('ef023', '18', NULL, '18', 'Nicht angeboten / Keine Angabe', NULL)
            ";
        
        $db->exec($query);
        
    }

    public function down()
    {
    }
}
