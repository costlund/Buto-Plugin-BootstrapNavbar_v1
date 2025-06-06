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
    /**
     * class
     */
    $navbar_theme = 'dark';
    $bg = 'dark';
    if($data->get('data/navbar_theme')){
      $navbar_theme = $data->get('data/navbar_theme');
    }
    if($data->get('data/bg')){
      $bg = $data->get('data/bg');
    }
    $class = "navbar navbar-expand-sm navbar-$navbar_theme bg-$bg";
    /**
     * fixed-top
     */
    if($data->get('data/fixed-top')){
      $class .= " fixed-top";
    }
    /**
     * style
     */
    $style = null;
    if($data->get('data/style')){
      $style = $data->get('data/style');
    }
    /**
     * 
     */
    $element = new PluginWfYml(__DIR__.'/element/navbar.yml');
    /**
     * script
     * Script to handle if Navbar is collapsed to add/remove class fixed-top for the purpose of mobile devices.
     * Script to handle if Navbar Dropdown is shown to add/remove class fixed-top.
     */
    $script = $element->get('innerHTML/1/innerHTML');
    $script = str_replace('[id]', $id, $script);
    $element->set('innerHTML/1/innerHTML', $script);
    /**
     * 
     */
    $element->setByTag(array('data-target' => '#'.$id, 'data-bs-target' => '#'.$id, 'id' => $id, 'brand_href' => $brand_href, 'brand_onclick' => $brand_onclick, 'brand' => $data->get('data/brand')));
    if($data->get('data/brand')){
      $brand = new PluginWfArray($data->get('data/brand'));
    }else{
      $brand = new PluginWfYml(__DIR__.'/element/brand.yml');
    }
    /**
     * item
     */
    if($data->get('data/navbar/item')){
      $item = new PluginWfArray($this->getNavbar($data->get('data/navbar/item')));
    }else{
      $item = new PluginWfYml(__DIR__.'/element/item.yml');
    }
    /**
     * item_right
     */
    if($data->get('data/navbar/item_right')){
      $item_right = new PluginWfArray($this->getNavbar($data->get('data/navbar/item_right'), true));
    }else{
      $item_right = new PluginWfArray();
    }
    $element->setByTag(array('brand' => $brand->get(), 'item' => $item->get(), 'element_before' => $data->get('data/navbar/element_before'), 'element_after' => $data->get('data/navbar/element_after'), 'class' => $class, 'style' => $style));
    $element->setByTag(array('item_right' => $item_right->get()));
    wfDocument::renderElement(array($element->get()));
  }
  private function getNavbar($data, $right = false){
    $items = array();
    foreach ($data as $key => $value) {
      $i = new PluginWfArray($value);
      /**
       * Set type as link if empty.
       */
      if(!$i->get('type')){$i->set('type', 'link');}
      /**
       * 
       */
      if($i->get('type')=='link'){
        /**
         * Link
         */
        $link = $this->getLink($i, 'nav-link');
        $link = $this->attribute_set($link, $i->get('attribute'));
        $link = $this->settings_set($link, $i->get('settings'));
        $items[] = wfDocument::createHtmlElement('li', array($link->get()));
      }elseif($i->get('type')=='dropdown'){
        /**
         * Item method.
         */
        if($i->get('item_method')){
          wfPlugin::includeonce($i->get('item_method/plugin'));
          $obj = wfSettings::getPluginObj($i->get('item_method/plugin'));
          $method = $i->get('item_method/method');
          $i->array = $obj->$method($i->get());
        }
        /**
         * Dropdown
         */
        $link = new PluginWfYml(__DIR__.'/element/link_dropdown.yml');
        $link->set('settings', $i->get('settings'));
        $link->setByTag($i->get(), 'rs', true);
        $class = 'nav-item dropdown';
        if($i->get('active')){
          $class .= ' active';
        }
        if(!$right){
          $dropdown_menu = new PluginWfYml(__DIR__.'/element/dropdown_menu.yml');
        }else{
          $dropdown_menu = new PluginWfYml(__DIR__.'/element/dropdown_menu_right.yml');
        }
        $dropdown_items = array();
        /**
         * 
         */
        $i->set('item', wfSettings::getSettingsFromYmlString($i->get('item')));
        /**
         * 
         */
        if(!$i->get('item') && !$i->get('content')){
          $i->set('item/0/text', '(Param item is empty)');
          $i->set('item/0/onclick', 'alert(this.innerHTML)');
        }
        if($i->get('item')){
          /**
           * item
           */
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
              $text = $this->attribute_set($text, $j->get('attribute'));
              $text->set('settings', $j->get('settings'));
              $dropdown_items[] = $text->get();
            }
          }
          $dropdown_menu->set('innerHTML', $dropdown_items);
        }elseif($i->get('content')){
          /**
           * content
           */
          $dropdown_menu->set('innerHTML', $i->get('content'));
        }
        $items[] = wfDocument::createHtmlElement('li', array($link->get(), $dropdown_menu->get()), array('class' => $class));
      }elseif($i->get('type')=='text'){
        /**
         * Text
         */
        $text = new PluginWfYml(__DIR__.'/element/text.yml');
        $text->setByTag($i->get(), 'rs', true);
        $text = $this->attribute_set($text, $i->get('attribute'));
        $text = $this->settings_set($text, $i->get('settings'));
        $items[] = $text->get();
      }
    }
    return $items;
  }
  private function attribute_set($element, $attribute){
    if($attribute){
      foreach ($attribute as $key => $value) {
        $item = new PluginWfArray($value);
        if($element->get("attribute/$key")){
          $element->set("attribute/$key", $element->get("attribute/$key").' '.$value);
        }else{
          $element->set("attribute/$key", $value);
        }
      }
    }
    return $element;
  }
  private function settings_set($element, $settings){
    if($settings){
      $element->set('settings', $settings);
    }
    return $element;
  }
  private function getLink($data, $class = 'dropdown-item'){
    /**
     * link_method
     */
    if($data->get('link_method')){
      wfPlugin::includeonce($data->get('link_method/plugin'));
      $obj = wfSettings::getPluginObj($data->get('link_method/plugin'));
      $method = $data->get('link_method/method');
      $data->array = $obj->$method($data->get());
    }
    /**
     *
     */
    if($data->get('attribute/class')){
      $class .= ' '.$data->get('attribute/class');
    }
    /**
     * Yml
     */
    $link = new PluginWfYml(__DIR__.'/element/link.yml');
    /**
     * icon/ img src
     */
    if(substr((string)$data->get('icon'), 0, 1)=='/'){
      $data->set('src', $data->get('icon'));
      $data->set('icon', null);
      if(!$data->get('img_style')){
        $data->set('img_style', array('height' => '17px'));
      }
    }
    /**
     * attribute/class
     */
    $link->set('attribute/class', $class);
    if($data->get('disabled')){
      $link->set('attribute/class', $link->get('attribute/class').' disabled');
    }
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
    $link->setByTag($data->get(), 'rs', true);
    /**
     * 
     */
    return $link;
  }
}
