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
            $id = $params['id'] ??  $config['default_id'];
            $class = $params['class'] ??  $config['default_class'];
            $height = $params['height'] ?? $config['default_height'];
            $width = $params['width'] ?? $config['default_width'];
            $shape = $params['shape'] ?? $config['default_shape'];
            $color = $params['color'] ?? $config['default_color']; 
            $backgroundColor = $params['background-color'] ?? $config['default_background-color'];
            $hoverColor = $params['hover-color'] ?? $config['default_hover-color'];
            $borderColor = $params['border-color'] ?? $config['default_border-color']; 
            $selectedColor = $params['selected-color'] ?? $config['default_selected-color']; 
            $enableZoom = $params['enable-zoom'] ?? $config['default_enable-zoom']; 
            $multiSelectRegion = $params['multiselect-region'] ?? $config['default_multiselect-region']; 

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
        $color = $params['color'] ?? $config['default_color']; 
        $hoverColor = $params['hover-color'] ?? $config['default_hover-color'];
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