<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class WorldMapPlugin
 * @package Grav\Plugin
 */
class WorldMapsPlugin extends Plugin
{

    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            $this->enable([
                'onGetPageTemplates' => ['onGetPageTemplates', 0]
                // 'onGetPageBlueprints' => ['onGetPageBlueprints', 0]
            ]);
        }   

        // Enable the main event we are interested in
        $this->enable([
            'onShortcodeHandlers' => ['onShortcodeHandlers', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0]        
        ]);

    }

    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }
    
    public function onShortcodeHandlers(Event $e)
    {
        $this->grav['shortcode']->registerAllShortcodes(__DIR__.'/shortcodes');
    }
    
    public function onGetPageTemplates($event)
    {
        $res = $this->grav['locator'];
        $event->types->scanBlueprints($res->findResource('plugin://' . $this->name . '/blueprints'));
        $event->types->scanTemplates($res->findResource('plugin://' . $this->name . '/templates'));
    }
}


