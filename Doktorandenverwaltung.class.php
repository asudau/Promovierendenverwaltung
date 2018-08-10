<?php
require_once 'lib/bootstrap.php';
require 'models/DoktorandenEntry.class.php';

define('DOKTORANDEN_ADMIN_ROLE', 'Doktorandenverwaltung');
/**
 * Doktorandenverwaltung.class.php
 *
 * ...
 *
 * @author  Annelene Sudau <asudau@uos.de>
 * @version 0.1a
 */


class Doktorandenverwaltung extends StudipPlugin implements AdministrationPlugin, SystemPlugin 
{

    public function __construct()
    {
        parent::__construct();
        global $perm;

        if(RolePersistence::isAssignedRole($GLOBALS['user']->user_id,
                                                            DOKTORANDEN_ADMIN_ROLE)){
            $navigation = new AutoNavigation($this->getDisplayName());
            $navigation->setImage(Icon::create('edit', 'navigation'));
            $navigation->setURL(PluginEngine::getURL($this, array(), 'index'));
            
            $item = new Navigation(_('Übersicht'), PluginEngine::getURL($this, array(), 'index'));
            $navigation->addSubNavigation('index', $item);
          
            Navigation::addItem('/doktorandenverwaltung', $navigation);  
        }
        
    }

    public function initialize ()
    {
        PageLayout::addStylesheet($this->getPluginURL().'/assets/style.css');
        PageLayout::addScript($this->getPluginURL().'/assets/jquery.tablesorter.js');
        
    }


    public function getNotificationObjects($course_id, $since, $user_id)
    {
        return array();
    }

    public function getIconNavigation($course_id, $last_visit, $user_id)
    {
        // ...
    }

    public function getInfoTemplate($course_id)
    {
        // ...
    }

    public function perform($unconsumed_path)
    {
        $this->setupAutoload();
        $dispatcher = new Trails_Dispatcher(
            $this->getPluginPath(),
            rtrim(PluginEngine::getLink($this, array(), null), '/'),
            'show'
        );
        $dispatcher->plugin = $this;
        $dispatcher->dispatch($unconsumed_path);
        
    }

    private function setupAutoload()
    {
        if (class_exists('StudipAutoloader')) {
            StudipAutoloader::addAutoloadPath(__DIR__ . '/models');
        } else {
            spl_autoload_register(function ($class) {
                include_once __DIR__ . $class . '.php';
            });
        }
    }
    
    /**
     * Plugin name to show in navigation.
     */
    public function getDisplayName() {
        return 'Doktorandenverwaltung';
    }
    
     

    
}
