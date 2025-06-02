# Buto-Plugin-BootstrapNavbar_v1

<ul>
<li>Bootstrap 5 navbar.</li>
</ul>

<a name="key_0"></a>

## Widgets



<a name="key_0_0"></a>

### widget_navbar

<pre><code>type: widget
data:
  plugin: 'bootstrap/navbar_v1'
  method: navbar
  data:</code></pre>
<p>Brand.</p>
<pre><code>    brand_href: /
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
        innerHTML: 'Brand-name'</code></pre>
<p>Fixed-top.</p>
<pre><code>    fixed-top: true</code></pre>
<p>Background. Change background (optional). Default is dark/dark.</p>
<pre><code>    navbar_theme: dark
    bg: dark</code></pre>
<pre><code>    navbar_theme: light
    bg: primary (or secondary)</code></pre>
<pre><code>    navbar_theme: light
    bg: none
    style:
      background-color: '#e3f2fd'</code></pre>
<p>Navbar.</p>
<pre><code>    navbar:</code></pre>
<p>Id.</p>
<pre><code>      id: _my_navbar_id_</code></pre>
<p>Item.</p>
<pre><code>      item:</code></pre>
<p>Link.</p>
<pre><code>        -
          text: Link 1
          href: '#link_1'</code></pre>
<p>Dropdown.</p>
<pre><code>        -
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
              onclick: "alert('Link 4')"</code></pre>
<p>Dropdown with content.</p>
<pre><code>        -
          text: Content
          type: dropdown
          content:
            -
              type: div
              attribute: 
                class: container-fluid
                style:
                  min-width: 300px
              innerHTML: 
                -
                  type: div
                  attribute: 
                    class: row
                  innerHTML: 
                    -
                      type: div
                      attribute: 
                        class: col-md-6
                      innerHTML:
                        -
                          type: a
                          attribute: 
                            class: btn btn-primary
                          innerHTML: Link 1
                        -
                          type: a
                          attribute: 
                            class: btn btn-primary
                          innerHTML: Link 2
                        -
                          type: a
                          attribute: 
                            class: btn btn-primary
                          innerHTML: Link 3
                    -
                      type: div
                      attribute: 
                        class: col-md-6
                      innerHTML:
                        -
                          type: div
                          innerHTML: Div 1
                        -
                          type: div
                          innerHTML: Div 2
                        -
                          type: div
                          innerHTML: Div 3
                    -
                      type: div
                      attribute: 
                        class: col-md-12 text-center
                      innerHTML: Dropdown content</code></pre>
<p>Item right.</p>
<pre><code>      item_right:
        -
          text: Link 5
          href: '#link_5'</code></pre>
<p>Item disabled.</p>
<pre><code>          disabled: true</code></pre>
<p>Item attribute.</p>
<pre><code>          attribute:
            class: webmaster-text</code></pre>
<p>Item style.</p>
<pre><code>          style: 'font-weight:bold'</code></pre>
<p>Item settings.</p>
<pre><code>          settings:
            role:
              item:
                - webmaster</code></pre>
<p>Item method.</p>
<pre><code>          item_method:
            plugin: _my_/_plugin_
            method: _nav_items_</code></pre>
<p>Item link method (example below).</p>
<pre><code>          link_method:
            plugin: memb_inc/vote
            method: nav_item_my_account</code></pre>
<p>Item icon.
Using from plugin icons/bootstrap_v1_8_1 or image src.</p>
<pre><code>          icon: house</code></pre>
<p>Item icon. Can also be a path to file. Also set img_style if needed.</p>
<pre><code>          icon: /path_to_file/icon.png
          img_style:
            height: 30px</code></pre>
<p>Add from file.</p>
<pre><code>        -
          type: dropdown
          text: Media
          item: yml:/theme/[theme]/layout/links.yml:media</code></pre>
<p>Element before and after.</p>
<pre><code>      element_before:
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
          innerHTML: (text after)</code></pre>

<a name="key_0_0_0"></a>

#### Item link method (example)

<pre><code>public function nav_item_my_account($data){
  $data = new PluginWfArray($data);
  $element = new PluginWfYml(__DIR__.'/element/nav_item_my_account.yml');
  $data-&gt;merge($element-&gt;get());
  return $data-&gt;get();
}</code></pre>

<a name="key_1"></a>

## Methods



<a name="key_1_0"></a>

### getNavbar



<a name="key_1_1"></a>

### attribute_set



<a name="key_1_2"></a>

### settings_set



<a name="key_1_3"></a>

### getLink



