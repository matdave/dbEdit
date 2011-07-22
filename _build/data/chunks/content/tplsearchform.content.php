<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
return '
<form class="search-form" action="[[~[[+landing:default=`[[*id]]`]]]]" method="[[+method:default=`get`]]">
  <fieldset>
    <label for="[[+searchIndex]]">[[%sisea.search? &namespace=`sisea` &topic=`default`]]</label>
    <input type="text" name="[[+searchIndex]]" id="[[+searchIndex]]" value="[[+searchValue]]" />
    <input type="hidden" name="id" value="[[+landing:default=[[*id]]]]" /> 
    <input type="submit" value="[[%sisea.search? &namespace=`sisea` &topic=`default`]]" />
  </fieldset>
</form>
';
?>
