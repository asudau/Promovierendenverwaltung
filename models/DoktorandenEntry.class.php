<?php

/**
 * @author  <asudau@uos.de>
 *
 * @property int        $chdate
 */

class DoktorandenEntry extends \SimpleORMap
{
    private static $groups = array(
        'promotionsdaten' => 'Daten zur Promotion',
        'doktorandendaten'=> 'Doktorandendaten',
        'ersteinschreibung'=> 'Daten zur Ersteinschreibung & HZB',
        'abschlusspruefung'=> 'Daten zur Promotion berechtigenden Abschlusspr�fung');
    
    protected static function configure($config = array())
    {
        $config['db_table'] = 'doktorandenverwaltung';
        
        $config['additional_fields']['geburtstag']['get'] = function ($item) {
        if (!$item->ef006u1){
            return '';
        } else return date('d.m.Y', mktime(0, 0, 0, $item->ef006u2, $item->ef006u1, $item->ef006u3));
        };
        $config['additional_fields']['geburtstag']['set'] = function ($item, $field, $data) {
            $time = strtotime ($data);
            $item->ef006u1 = date("d", $time);
            $item->ef006u2 = date("m", $time);
            $item->ef006u3 = date("Y", $time);
        };
        $config['additional_fields']['geburtstag_time']['get'] = function ($item) {
            return mktime(0, 0, 0, $item->ef006u2, $item->ef006u1, $item->ef006u3);
        };
        $config['additional_fields']['berichtseinheitid']['get'] = function ($item) {
            return '05300000';
        };
        $config['additional_fields']['ef001']['get'] = function ($item) {
            return '03';
        };
        $config['additional_fields']['ef002']['get'] = function ($item) {
            if ($entry->mkdate > 0){
                return date('Y', $entry->mkdate);
            } else return false;
        };
        $config['additional_fields']['ef003']['get'] = function ($item) {
            return '0530';
        };
        $config['additional_fields']['ef010']['get'] = function ($item) {
            if($item['art_promotion']){
                $field = DoktorandenFields::find('art_promotion');
                return $field->getValueAstatByKey($item['art_promotion']);
            } else return NULL;
        };
        $config['additional_fields']['ef011']['get'] = function ($item) {
            if($item['promotionsfach']){
                $field = DoktorandenFields::find('promotionsfach');
                return $field->getValueAstatByKey($item['promotionsfach']);
            } else return NULL;
        };
        $config['additional_fields']['ef026']['get'] = function ($item) {
            if($item['studienform'] && $item['abschluss']){
                $field = DoktorandenFields::find('studienform');
                $studienform = $field->getValueAstatByKey($item['studienform']);
                $field = DoktorandenFields::find('abschluss');
                $abschluss = $field->getValueAstatByKey($item['abschluss']);
                return $studienform . $abschluss;
            } else return NULL;
        };
        $config['additional_fields']['ef027']['get'] = function ($item) {
            if($item['abschluss_studienfach']){
                $field = DoktorandenFields::find('abschluss_studienfach');
                $astat = $field->getValueAstatByKey($item['abschluss_studienfach']);
                return substr($astat,1);
            } else return NULL;
        };

        parent::configure($config);
    }
    
    public function getFields() {
        return $this->db_fields;
    }
    
    public function getAdditionalFields() {
        return $this->additional_fields;
    }
    
    public static function getGroupedFields() {
        $group_array = array();
        foreach(self::$groups as $group => $title){
            $group_array[$group]['entries'] = DoktorandenFields::findBySQL("`group` LIKE :group", array(':group' => $group));
            $group_array[$group]['title'] = $title;
        }
        //return DoktorandenEntry::$groupedFields;
        return $group_array;
    }
    
    public function completeProgress(){
        if ($this->complete_progress > 0){
            return $this->complete_progress;
        } else {
            $filled = 0;
            $req_fields = DoktorandenFields::getRequiredFields();
            foreach($req_fields as $field){
                $field_id = $field->id;
                if ($this->$field_id != NULL){
                    $filled ++;
                } 
            }
            $this->complete_progress = $filled;
            $this->store();
        }
        return $this->complete_progress;
    }

    public function req($field){
        if (DoktorandenFields::find($field)->fill == 'manual_req'){
            if ($this->$field == NULL){
                return true;
            }
        } return false;
    }
    
}
