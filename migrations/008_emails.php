<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Emails extends Migration
{
    public function description()
    {
        return 'Add email table with his_person_id for Doktorandenverwaltung';
    }

    public function up()
    {
        $db = DBManager::get();

        // add db-table
        $db->exec("CREATE TABLE IF NOT EXISTS `doktorandenverwaltung_emails` (
            `HISINONE_PERSON_ID` int(5) NOT NULL auto_increment,
            `email` varchar(255) NOT NULL,
            PRIMARY KEY (HISINONE_PERSON_ID)
        ) ");
      
        SimpleORMap::expireTableScheme();
    }

    public function down()
    {
        $db = DBManager::get();

        $db->exec("DROP TABLE doktorandenverwaltung_emails");

        SimpleORMap::expireTableScheme();
    }
}