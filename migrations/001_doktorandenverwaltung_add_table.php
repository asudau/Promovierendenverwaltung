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
            `id` int(11) NOT NULL auto_increment,
            `his_id` varchar(5) NULL,
            `hisinone_person_id` varchar(11) NULL,
            `geschlecht` varchar(11) NULL,
            `geburtsdatum_tag` varchar(11) NULL,
            `geburtsdatum_monat` varchar(11) NULL,
            `geburtsdatum_jahr` varchar(11) NULL,
            `nachname` varchar(100) NULL,
            `vorname` varchar(100) NULL,
            `staatsangehoerigkeit` varchar(11) NULL,
            `weitere_staatsangehoerigkeit` varchar(11) NULL,
            `art_promotion` varchar(11) NULL,
            `promotionsfach` varchar(11) NULL,
            `art_reg_prom` varchar(11) NULL,
            `promotionsbeginn_monat` varchar(11) NULL,
            `promotionsbeginn_jahr` varchar(11) NULL,
            `promotionsende_monat` varchar(11) NULL,
            `promotionsende_jahr` varchar(11) NULL,
            `matrikelnummer` varchar(11) NULL,
            `immatrikulation` varchar(11) NULL,
            `struk_promotionsprogramm` varchar(11) NULL,
            `employment` varchar(11) NULL,
            `art_dissertation` varchar(11) NULL,
            `hochschule_erst` varchar(11) NULL,
            `staat_hochschule_erst` varchar(11) NULL,
            `semester` varchar(11) NULL,
            `jahr` varchar(11) NULL,
            `status_abschlusspruefung` varchar(11) NULL,
            `hochschule_abschlusspruefung` varchar(11) NULL,
            `staat_abschlusspruefung` varchar(11) NULL,
            `studienform_abschluss` varchar(11) NULL,
            `abschlusspruefung_abschluss` varchar(11) NULL,
            `studienfach_abschluss` varchar(11) NULL,
            `monat_pruefung` varchar(11) NULL,
            `jahr_pruefung` varchar(11) NULL,
            `note` varchar(11) NULL,
            `hzb_jahr` varchar(11) NULL,
            `hzb_art` varchar(11) NULL,
            `hzb_kreis` varchar(11) NULL,
            `hzb_staat` varchar(11) NULL,
            `ef034` varchar(11) NULL,
            `ef035` varchar(11) NULL,
            `ef036` varchar(11) NULL,
            `ef037` varchar(11) NULL,
            `ef038` varchar(11) NULL,
            `complete_progress` int(11) NULL,
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
