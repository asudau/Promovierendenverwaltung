<?php

/**
 * Doktorandenverwaltung.class.php
 *
 * ...
 *
 * @author  Annelene Sudau <asudau@uos.de>
 * @version 0.1a
 */


class Doktorandenverwaltung extends StudipPlugin implements SystemPlugin 
{

    const DOKTORANDENVERWALTUNG_ROLE = 'Doktorandenverwaltung';
    const DOKTORANDENVERWALTUNG_ADMIN_ROLE = 'Doktorandenverwaltung_Admin';
    
    public function __construct()
    {
        parent::__construct();
        global $perm;

        if(RolePersistence::isAssignedRole($GLOBALS['user']->user_id,
                                                            self::DOKTORANDENVERWALTUNG_ROLE)){
            $navigation = new Navigation('Promovierendenverwaltung');
            $navigation->setImage(Icon::create('edit', 'navigation'));
            $navigation->setURL(PluginEngine::getURL($this, array(), 'index'));
            
            $item = new Navigation(_('Übersicht'), PluginEngine::getURL($this, array(), 'index'));
            $navigation->addSubNavigation('index', $item);
            
            $item = new Navigation(_('FAQ'), PluginEngine::getURL($this, array(), 'index/faq'));
            $navigation->addSubNavigation('faq', $item);
            
            Navigation::addItem('tools/doktorandenverwaltung', $navigation);  
        }    
    }

    public function initialize ()
    {
        
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
}
