<?php
/**
  type: widget
  data:
    plugin: 'bootstrap/navbar_v1'
    method: navbar
    data:
      _: 'https://getbootstrap.com/docs/4.0/components/navbar/'
      brand: Navbar
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
        item:
          -
            text: Link 1
            disabled: true
            href: '/test'
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
                text: Link 2.2
                onclick: "alert()"
          -
            text: Link 3
            onclick: "alert()"
 */
class PluginBootstrapNavbar_v1{
  public function widget_navbar($data){
    wfPlugin::includeonce('wf/array');
    wfPlugin::includeonce('wf/yml');
    $data = new PluginWfArray($data);
    $element = new PluginWfYml(__DIR__.'/element/navbar.yml');
    if($data->get('data/brand')){
      $brand = new PluginWfArray($data->get('data/brand'));
    }else{
      $brand = new PluginWfYml(__DIR__.'/element/brand.yml');
    }
    if($data->get('data/navbar/item')){
      $items = array();
      foreach ($data->get('data/navbar/item') as $key => $value) {
        $i = new PluginWfArray($value);
        if(!$i->get('type')){$i->set('type', 'link');}
        if($i->get('type')=='link'){
          $link = new PluginWfYml(__DIR__.'/element/link.yml');
          $link->set('innerHTML', $i->get('text'));
          if($i->get('disabled')){
            $link->set('attribute/class', $link->get('attribute/class').' disabled');
          }
          if($i->get('href')){
            $link->set('attribute/href', $i->get('href'));
          }
          if($i->get('onclick')){
            $link->set('attribute/onclick', $i->get('onclick'));
          }
          $class = 'nav-item';
          if($i->get('active')){
            $class .= ' active';
          }
          $items[] = wfDocument::createHtmlElement('li', array($link->get()), array('class' => $class));
        }elseif($i->get('type')=='dropdown'){
          $link = new PluginWfYml(__DIR__.'/element/link_dropdown.yml');
          $link->set('innerHTML', $i->get('text'));
          $class = 'nav-item dropdown';
          if($i->get('active')){
            $class .= ' active';
          }
          $dropdown_menu = new PluginWfYml(__DIR__.'/element/dropdown_menu.yml');
          $dropdown_items = array();
          foreach ($i->get('item') as $key2 => $value2) {
            $j = new PluginWfArray($value2);
            if(!$j->get('type')){$j->set('type', 'link');}
            if($j->get('type')=='link'){
              $dropdown_link = new PluginWfYml(__DIR__.'/element/dropdown_link.yml');
              $dropdown_link->set('innerHTML', $j->get('text'));
              if($j->get('disabled')){
                $dropdown_link->set('attribute/class', $dropdown_link->get('attribute/class').' disabled');
              }
              if($j->get('href')){
                $dropdown_link->set('attribute/href', $j->get('href'));
              }
              if($j->get('onclick')){
                $dropdown_link->set('attribute/onclick', $j->get('onclick'));
              }
              $dropdown_items[] = $dropdown_link->get();
            }elseif($j->get('type')=='divider'){
              $dropdown_divider = new PluginWfYml(__DIR__.'/element/dropdown_divider.yml');
              $dropdown_items[] = $dropdown_divider->get();
            }
          }
          $dropdown_menu->set('innerHTML', $dropdown_items);
          $items[] = wfDocument::createHtmlElement('li', array($link->get(), $dropdown_menu->get()), array('class' => $class));
        }
      }
      $item = new PluginWfArray($items);
    }else{
      $item = new PluginWfYml(__DIR__.'/element/item.yml');
    }
    $element->setByTag(array('brand' => $brand->get(), 'item' => $item->get(), 'element_before' => $data->get('data/navbar/element_before'), 'element_after' => $data->get('data/navbar/element_after')));
    wfDocument::renderElement(array($element->get()));
  }
}
