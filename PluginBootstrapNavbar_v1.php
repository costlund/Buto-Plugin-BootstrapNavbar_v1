<?php
class PluginBootstrapNavbar_v1{
  public function widget_navbar($data){
    wfPlugin::includeonce('wf/array');
    wfPlugin::includeonce('wf/yml');
    $data = new PluginWfArray($data);
    $id = null;
    $brand_href = '#';
    $brand_onclick = null;
    if($data->get('data/navbar/id')){
      $id = $data->get('data/navbar/id');
    }else{
      $id = '_'.wfCrypt::getUid();
    }
    if($data->get('data/brand_href')){
      $brand_href = $data->get('data/brand_href');
    }
    if($data->get('data/brand_onclick')){
      $brand_onclick = $data->get('data/brand_onclick');
    }
    $element = new PluginWfYml(__DIR__.'/element/navbar.yml');
    $element->setByTag(array('data-target' => '#'.$id, 'id' => $id, 'brand_href' => $brand_href, 'brand_onclick' => $brand_onclick));
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
          $items[] = wfDocument::createHtmlElement('li', array($this->getLink($i, 'nav-link')->get()));
        }elseif($i->get('type')=='dropdown'){
          $link = new PluginWfYml(__DIR__.'/element/link_dropdown.yml');
          $link->set('settings', $i->get('settings'));
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
              $dropdown_items[] = $this->getLink($j)->get();
            }elseif($j->get('type')=='divider'){
              $dropdown_divider = new PluginWfYml(__DIR__.'/element/dropdown_divider.yml');
              $dropdown_divider->set('settings', $j->get('settings'));
              $dropdown_items[] = $dropdown_divider->get();
            }elseif($j->get('type')=='text'){
              $text = new PluginWfYml(__DIR__.'/element/dropdown_text.yml');
              $text->setByTag($j->get());
              $dropdown_items[] = $text->get();
            }
          }
          $dropdown_menu->set('innerHTML', $dropdown_items);
          $items[] = wfDocument::createHtmlElement('li', array($link->get(), $dropdown_menu->get()), array('class' => $class));
        }elseif($i->get('type')=='text'){
          $text = new PluginWfYml(__DIR__.'/element/text.yml');
          $text->setByTag($i->get());
          $items[] = $text->get();
        }
      }
      $item = new PluginWfArray($items);
    }else{
      $item = new PluginWfYml(__DIR__.'/element/item.yml');
    }
    $element->setByTag(array('brand' => $brand->get(), 'item' => $item->get(), 'element_before' => $data->get('data/navbar/element_before'), 'element_after' => $data->get('data/navbar/element_after')));
    wfDocument::renderElement(array($element->get()));
  }
  private function getLink($data, $class = 'dropdown-item'){
    /**
     * Yml
     */
    $link = new PluginWfYml(__DIR__.'/element/link.yml');
    /**
     * attribute/class
     */
    $link->set('attribute/class', $class);
    if($data->get('disabled')){
      $link->set('attribute/class', $link->get('attribute/class').' disabled');
    }
    /**
     * Settings
     */
    $link->set('settings', $data->get('settings'));
    /**
     * innerHTML
     */
    $link->set('innerHTML', $data->get('text'));
    /**
     * attribute/href
     */
    if($data->get('href')){
      $link->set('attribute/href', $data->get('href'));
    }
    /**
     * attribute/onclick
     */
    if($data->get('onclick')){
      $link->set('attribute/onclick', $data->get('onclick'));
    }
    /**
     * Target
     */
    if($data->get('target')){
      $link->set('attribute/target', $data->get('target'));
    }
    /**
     * 
     */
    return $link;
  }
}
