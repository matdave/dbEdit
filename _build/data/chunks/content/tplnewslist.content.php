<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
return '
    <div class="news_item" id="ditto_item_[[+id]]">
    <h3 class="news_pageTitle">
    <a style="text-decoration:none" href="[[~[[+id]]]]">[[+pagetitle]]</a>
    </h3>
    <div class="news_date">[[+publishedon:strtotime:date=`%a %b %e, %Y`]]</div>
    [[+tvStoryImage]]
    <div class="news_introText">[[+content]]</div>
    </div> 
';
?>
