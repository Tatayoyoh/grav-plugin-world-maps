# World Maps Plugin

**This README.md file should be modified to describe the features, installation, configuration, and general usage of this plugin.**

The **World Maps** Plugin is for [Grav CMS](http://github.com/getgrav/grav). Provide an editable world maps

## Installation

Installing the World Maps plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install world-map

This will install the World Maps plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/world-map`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `world-map`. You can find these files on [GitHub](https://github.com/widebob/grav-plugin-world-map) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/world-map
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

### Admin Plugin

If you use the admin plugin, you can install directly through the admin plugin by browsing the `Plugins` tab and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/world-map/world-map.yaml` to `user/config/plugins/world-map.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

Note that if you use the admin plugin, a file with your configuration, and named world-map.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the admin.

## Usage

**Describe how to use the plugin.**

!!! Don't forget to include you assets with `{{ assets.js() }}` in your base Twig template.

Map options
TODO : put all options here
```
'id'
'class'
'height'
'width'
'shape'
'color'
'background-color'
'hover-color'
'border-color'
// completer les options
```
Options are available in ShortCode tag and in your Markdown header variables

### Markdown header example :
```
title: 'World Map'
cache_enable: false
map:
    title: 'my world map'
    shape: world
    id: custom_id
    class: custom_class
    height: 
    width: 100%
    color: '#A9A9A9'
    border_color: '#FFF'
    background_color: '#FFF'
    hover_color: null
    selected_color: null
    zoom_enabled: false
    multi_select_region: false
    regions:
        -
            ref: ar
            color: '#db3434'
            link: /home
        -
            ref: us
            color: '#4f49c9'
            link: /thankyou
    legends:
        -
            text: TEST
            color: '#db3434'
        -
            text: TEST2
            color: '#4f49c9'```

### ShortCode example :
```

### World map exploration

[map shape="world" id="myworldmap"]
    [region ref="us" color="#666" link="thankyou"][/region]
    [region ref="in" color="#666" link="thankyou"][/region]
    [region ref="fr" color="#123456" link="thankyou"][/region]
    [region ref="au" color="#666" link="thankyou"][/region]
    [legend text="VISITED" color="#666"][/legend]
    [legend text="CURRENT" color="#123456"][/legend]
[/map]

### Europe map exploration

[map shape="europe" id="myeuropedmap"]
    [region ref="ro" color="#666" link="thankyou"][/region]
    [region ref="fr" color="#123456" link="thankyou"][/region]
    [region ref="fi" color="#666" link="thankyou"][/region]
    [legend text="VISITED" color="#666"][/legend]
    [legend text="CURRENT" color="#123456"][/legend]
[/map]
```

### BLUEPRINT USAGE EXEMPLE :

```
title: WorldMap
# Uncomment to extend from default
#'@extends': default

form:
    fields:
        tabs:
            type: tabs
            active: 1

            fields:

              # Inside existing tab
              content:
                  type: tab
                  title: Content

                  fields:
                    map_settings:
                      type: section
                      title: MAP SETTINGS
                      import@:
                        type: partials/map
                        context: blueprints://
                  
              # Inside a new tab
              map:
                content:
                  type: tab
                  title: Map
                  ordering@: content # Set this tab after Content tab
                  import@:
                    type: partials/map
                    context: blueprints://
```




## Credits

**Did you incorporate third-party code? Want to thank somebody?**

## To Do

- [ ] Future plans, if any

