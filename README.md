# Buto-Plugin-BootstrapNavbar_v1
Bootstrap 4 navbar.

## Example
### Basic
```
type: widget
data:
  plugin: 'bootstrap/navbar_v1'
  method: navbar
  data:
    navbar:
      id: _my_navbar_id_
      item:
        -
          text: Link 1
          href: '#link_1'
        -
          type: dropdown
          text: Dropdown
          item:
            -
              text: Link 2
              href: '#link_2'
            -
              type: divider
            -
              text: Link 3
              href: '#link_3'
            -
              type: text
              text: Text 1
              style: 'font-style:italic'
            -
              text: Link 4
              onclick: "alert('Link 4')"
      item_right:
        -
          text: Link 5
          href: '#link_5'
```

### Brand
```
data:
  data:
    brand_href: /
    brand:
      -
        type: img
        attribute:
          src: /plugin/theme/include/icon/icon.png
          style:
            width: 24px
            margin-top: -5px
      -
        type: span
        attribute:
          class: d-sm-none
        innerHTML: 'Brand-name'
```
### Background
Change background (optional). Default is dark/dark.
```
data:
  data:
```
```
    navbar_theme: dark
    bg: dark
```
```
    navbar_theme: light
    bg: primary (or secondary)
```
```
    navbar_theme: light
    bg: none
    style:
      background-color: '#e3f2fd'
```

### From file
Add from file.
```
        -
          type: dropdown
          text: Media
          item: yml:/theme/[theme]/layout/links.yml:media
```

### Element
Element before and after.
```
type: widget
data:
  plugin: 'bootstrap/navbar_v1'
  method: navbar
  data:
    navbar:
      element_before:
        -
          type: span
          attribute:
            class: navbar-text
          innerHTML: (text before)
      element_after:
        -
          type: span
          attribute:
            class: navbar-text
          innerHTML: (text after)
```
### Item
#### Disabled
```
item:
  -
    disabled: true
```
#### Attribute
```
item:
  -
    attribute:
      class: webmaster-text
```
#### Style
```
item:
  -
    style: 'font-weight:bold'
```
#### Settings
```
item:
  -
    settings:
      role:
        item:
          - webmaster
```
#### Method
Item method.
```
item:
  -
    item_method:
      plugin: _my_/_plugin_
      method: _nav_items_
```
#### Link method
```
item:
  -
    link_method:
      plugin: memb_inc/vote
      method: nav_item_my_account
```
#### Icon
Icon from plugin icons/bootstrap_v1_8_1 or image src.
```
item:
  -
```
Using icons/bootstrap_v1_8_1.
```
    icon: house
```
Can also be a path to file.
```
    icon: /path_to_file/icon.png
```
If file on could set style.
If not set default is 17px height.
```
    img_style:
      height: 30px
```
