# Buto-Plugin-BootstrapNavbar_v1
Bootstrap 4 navbar.



```
type: widget
data:
  plugin: 'bootstrap/navbar_v1'
  method: navbar
  data:
    brand_href: /
    brand:
      -
        type: img
        attribute:
          src: /theme/_folder_/_folder_/logo.png
          style:
            width: 24px
            margin-top: -5px
      -
        type: span
        attribute:
          class: d-sm-none
        innerHTML: 'Brand-name'
    navbar:
      id: _my_navbar_id_
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
      item:
        -
          text: Link 1
          attribute:
            class: webmaster-text
          disabled: true
          href: '/test'
        -
          type: text
          text: Statistic
          style: 'font-weight:bold'
        -
          type: text
          text:
            -
              type: span
              attribute:
                class: badge badge-primary
              innerHTML: test
        -
          type: dropdown
          active: true
          text: Link 2
          item:
            -
              text: Link 2.1
              href: /test2
            -
              type: divider
            -
              type: text
              text: Statistic
              style: 'font-style:italic'
            -
              text: Link 2.2
              onclick: "alert()"
        -
          text: Link 3
          attribute:
            class: parantes
            style: 'color:red'
          settings:
            role:
              item:
                - webmaster
          onclick: "alert()"
        -
          text: Item method
          type: dropdown
          settings:
            enabled: true
          item_method:
            plugin: _my_/_plugin_
            method: _nav_items_
      item_right:
        -
          text: Go right
          href: '/go_right'
```

