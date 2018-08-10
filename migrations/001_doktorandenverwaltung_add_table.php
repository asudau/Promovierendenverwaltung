<?php

class DoktorandenverwaltungAddTable extends Migration
{
    public function description()
    {
        return 'Add DB table for Doktorandenverwaltung';
    }

    public function up()
    {
        $role = new Role();
        $role->setRolename('Doktorandenverwaltung');
        $role->setSystemtype(false);
        RolePersistence::saveRole($role);
        
        $db = DBManager::get();

        // add db-table
        $db->exec("CREATE TABLE IF NOT EXISTS `doktorandenverwaltung` (
            `id` int(11) NOT NULL,
            `berichtseinheitid` varchar(11) NOT NULL,
            `hisinone_person_id` varchar(11) NULL,
            `ef001` varchar(11) NOT NULL,
            `ef002` varchar(11) NULL ,
            `ef003` varchar(11) NOT NULL,
            `ef004` varchar(11) NULL,
            `ef005` varchar(11) NULL,
            `ef006u1` varchar(11) NULL,
            `ef006u2` varchar(11) NULL,
            `ef006u3` varchar(11) NULL,
            `nachname` varchar(100) NULL,
            `vorname` varchar(100) NULL,
            `ef007` varchar(11) NULL,
            `ef008` varchar(11) NULL,
            `ef009` varchar(11) NULL,
            `ef010` varchar(11) NULL,
            `ef011` varchar(11) NULL,
            `ef012` varchar(11) NULL,
            `ef013u1` varchar(11) NULL,
            `ef013u2` varchar(11) NULL,
            `ef014u1` varchar(11) NULL,
            `ef014u2` varchar(11) NULL,
            `matrikelnummer` varchar(11) NULL,
            `ef015` varchar(11) NULL,
            `ef016` varchar(11) NULL,
            `ef017` varchar(11) NULL,
            `ef018` varchar(11) NULL,
            `ef019` varchar(11) NULL,
            `ef020` varchar(11) NULL,
            `ef021` varchar(11) NULL,
            `ef022` varchar(11) NULL,
            `ef023` varchar(11) NULL,
            `ef024` varchar(11) NULL,
            `ef025` varchar(11) NULL,
            `ef026` varchar(11) NULL,
            `ef027` varchar(11) NULL,
            `ef028` varchar(11) NULL,
            `ef029` varchar(11) NULL,
            `ef030` varchar(11) NULL,
            `ef031` varchar(11) NULL,
            `ef032` varchar(11) NULL,
            `ef033u1` varchar(11) NULL,
            `ef033u2` varchar(11) NULL,
            `ef034` varchar(11) NULL,
            `ef035` varchar(11) NULL,
            `ef036` varchar(11) NULL,
            `ef037` varchar(11) NULL,
            `ef038` varchar(11) NULL,
            `chdate` int(11) NULL,
            PRIMARY KEY (id)
        ) ");

        SimpleORMap::expireTableScheme();
    }

    public function down()
    {
        $db = DBManager::get();

        $db->exec("DROP TABLE doktorandenverwaltung");

        SimpleORMap::expireTableScheme();
    }
}
