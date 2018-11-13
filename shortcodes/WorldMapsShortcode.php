<?php
namespace Grav\Plugin\Shortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class WorldMapsShortcode extends Shortcode {

    public function init() {
        $this->shortcode->getHandlers()->add('map', function(ShortcodeInterface $sc_vmap) {
            // shortcode text parameters            
            $params = $sc_vmap->getParameters();

            // plugin configuration
            $config = $this->config->get('plugins.world-maps');
            
            // vmap html tag parameters
            $id = $params['id'] ??  $config['default-id'];
            $class = $params['class'] ??  $config['default-class'];
            $height = $params['height'] ?? $config['default-height'];
            $width = $params['width'] ?? $config['default-width'];
            $shape = $params['shape'] ?? $config['default-shape'];
            $color = $params['color'] ?? $config['color']; 
            $backgroundColor = $params['background-color'] ?? $config['background-color'];
            $hoverColor = $params['hover-color'] ?? $config['hover-color'];
            $borderColor = $params['border-color'] ?? $config['border-color']; 
            $selectedColor = $params['selected-color'] ?? $config['selected-color']; 
            $enableZoom = $params['enable-zoom'] ?? $config['enable-zoom']; 
            $multiSelectRegion = $params['multiselect-region'] ?? $config['multiselect-region']; 

            $map = array(
                'id' => $id,
                'class' => $class,
                'height' => $height,
                'width' => $width,
                'shape' => $shape,
                'color' => $color,
                'background_color' => $backgroundColor,
                'hover_color' => $hoverColor,
                'border_color' => $borderColor,
                'selected_color' => $selectedColor,
                'enable_zoom' => $enableZoom,
                'multi_select_region' => $multiSelectRegion
            );

            $hash = $this->shortcode->getId($sc_vmap); 
            $children = $this->shortcode->getStates($hash);
            $legends = array();
            $regions = array();
            foreach ($children as $child){
                switch ($child->getName()) {
                    case 'legend':  // Create legends array
                        $legends[] = $child->getParameters();
                    break;
                    case 'region':  // Create regions array
                        $regions[] = $this->getRegionParams($child);
                    break;
                }
            }
            
            $map['legends'] = $legends;
            $map['regions'] = $regions;
            $map['children'] = $children;

            return $this->twig->processTemplate('partials/map.html.twig', [ 'map' => $map ]);
        });

        $this->shortcode->getHandlers()->add('region', function(ShortcodeInterface $sc_region) {
            $hash = $this->shortcode->getId($sc_region->getParent());
            $this->shortcode->setStates($hash, $sc_region);
            return;
        });

        $this->shortcode->getHandlers()->add('legend', function(ShortcodeInterface $sc_legend) {
            $hash = $this->shortcode->getId($sc_legend->getParent());
            $this->shortcode->setStates($hash, $sc_legend);
            return;
        });
    }


    private function getRegionParams(ShortcodeInterface $sc_region){
        // shortcode text parameters            
        $params = $sc_region->getParameters();
        // plugin configuration
        $config = $this->config->get('plugins.world-maps');
        
        // shortcode parameters overload plugin configuration
        $color = $params['color'] ?? $config['color']; 
        $hoverColor = $params['hover-color'] ?? $config['hover-color'];
        $ref = $params['ref'] ?? ""; 
        $link = $params['link'] ?? "#"; 
        
        // generate custom JS assets
        return [
            'color' => $color,
            'hover_color' => $hoverColor,
            'link' => $link,
            'ref' => $ref
        ];   
    }
}