# World Maps Plugin

The **World Maps** Plugin is for [Grav CMS](http://github.com/getgrav/grav). This plugin provides customizable and vectorial world maps.

Every regions of the map is clickable and editable by color and link reference.

![](assets/map-screenshot.png)

---

## Installation

Installing the World Maps plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install world-maps

This will install the World Maps plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/world-maps`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `world-maps`. You can find these files on [GitHub](https://github.com/widebob/grav-plugin-world-maps) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/world-maps
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

### Admin Plugin (Preferred)

If you use the admin plugin, you can install directly through the admin plugin by browsing the `Plugins` tab and clicking on the `Add` button.

![](assets/install.gif)

---

## Plugin Configuration

Before configuring this plugin, you should copy the `user/plugins/world-maps/world-maps.yaml` to `user/config/plugins/world-maps.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
js_group: ''
js_priority: 80
default_id: 'world-maps-plugin'
default_class: ''
default_height: '500px'
default_width: '100%'
default_shape: 'world'
default_color: '#A9A9A9'
default_background-color: '#FFFFFF'
default_border-color: '#FFFFFF'
default_hover-color: null
default_selected-color: null
default_multiselect-region: false
default_enable-zoom: false
```

**Note :** if you use the admin plugin, the world-maps.yaml file will be automatically saved in the `user/config/plugins/` folder once the configuration is saved in the admin interface.

---

## /!\ PROJECT CONFIGURATION /!\


Check your Theme's base Twig template to get the `assets group` used with it, and specify this group in the World Maps plugin configuration with the _JS Assets group_ field. **Otherwhise the World Maps plugin will not works properly.** 

Here an example of `base.html.twig` for Grav main theme :
![](assets/base.html.twig.png)

You can specify this parameter in `user/config/plugins/world-maps.yaml` configuration file with the `js_group` value.

```yaml
enabled: true
js_group: 'bottom'
js_priority: 80
```

You can also specify it in the Grav Admin interface
![](assets/plugin-config.png)


If you don't want to specify a group for your assets, you can change your theme block and leave assets without any group :
```twig
{% block bottom %}
    {{ assets.js() }}
{% endblock %}
``` 

----

## Usages

### Grav Admin interface

Page example
![](assets/page-example.gif)

Page modular example
![](assets/modular-example.gif)

### Page header example :
```yaml
---
title: 'World Map'
cache_enable: false
map:
    title: 'my world map'       # Displayed map title
    shape: world                # Name of vectorial map to use 
    id: custom_id               # HTML map element id
    class: custom_class         # HTML map element class
    height: 300px               # HTML map element height
    width: 100%                 # HTML map element width
    color: '  #A9A9A9'          # color used by default for map's regions
    border_color: '#FFF'        # map's regions border color
    background_color: '#FFF'    # map's background color
    hover_color: null           # map's regions hover color
    selected_color: null        # map's regions selected color
    zoom_enabled: false         # Enable or not zoom buttons
    multi_select_region: false  # Enable or not multi region selection
    regions:
        -
            ref: ar             # Region/Country code name
            color: '#db3434'    # Given region color
            link: /home         # Link to open on region click
        -
            ref: us
            color: '#4f49c9'
            link: /thankyou
    legends:
        -
            text: TEST          # Legend's text/label
            color: '#db3434'    # Color used for text/label
        -
            text: TEST2
            color: '#4f49c9'
---
```

### ShortCode example :
#### World map

```markdown
[map shape="world" id="myworldmap"]
    [region ref="us" color="#666" link="thankyou"][/region]
    [region ref="in" color="#666" link="thankyou"][/region]
    [region ref="fr" color="#123456" link="thankyou"][/region]
    [region ref="au" color="#666" link="thankyou"][/region]
    [legend text="VISITED" color="#666"][/legend]
    [legend text="CURRENT" color="#123456"][/legend]
[/map]
```

#### Europe map

```markdown
[map shape="europe" id="myeuropedmap"]
    [region ref="ro" color="#666" link="thankyou"][/region]
    [region ref="fr" color="#123456" link="thankyou"][/region]
    [region ref="fi" color="#666" link="thankyou"][/region]
    [legend text="VISITED" color="#666"][/legend]
    [legend text="CURRENT" color="#123456"][/legend]
[/map]
```

## Blueprint import :

You can integrate the World Maps plugin blueprint as a partial element in any of your own blueprints. Just use those 3 lines in your blueprint template :

```yaml
import@:
  type: partials/map
  context: blueprints:// 
```

### Import example
```yaml

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
                  ordering@: content # Set the Map tab after Content tab
                  import@:
                    type: partials/map
                    context: blueprints://
```

### Admin render

![](assets/admin-interface.png)


## Credits

Thanks to [Peter Schmalfeldt](https://github.com/manifestinteractive) and [10 Best Design](https://github.com/10bestdesign) for [JQVMap]( https://github.com/10bestdesign/jqvmap) development and maintenance.

## To Do

- Add missing JQVMap parameters in config and blueprint
- Add default values in parial blueprint `map.yaml` from config file `world-maps.yaml`
- Check incoming parameter values in `map.html.twig` and set default values if missing to prevent errors

