<?php
/**
* Snippet Name: DynamicDescription
* Snippet URI: http://www.devtrench.com/modx-dynamic-description-snippet/
* Description: Creates a dynamic description of the first $n words in
*              $content.  This started as a way to create a dynamic
*              meta description, but could be used anywhere where a
*              simple description is needed. Can be used multiple times
*              on a single page.
* Version: 1.0
* Author: James Ehly
* Author URI: http://www.devtrench.com/
*             http://www.ehlydesign.com/
*/

/**
* Copyright (C) 2007 James Ehly
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
*/

/**
* Installation:
*
* Just copy this code into a new Snippet and name it DynamicDescription
* Nothin' to it :)
*
*/

/**
* Usage:
*
* <META NAME="description" CONTENT="[[DynamicDescription]]">
*
* The above example is a typical way to use this snippet. This creates
* a dynamic description of the first 25 words of the document content.
* The meta tag and snippet call should be placed in the <head> portion
* of your template.
*
* [[DynamicDescription? &descriptionTV=`MetaDescription`]]
*
* The above example creates a dynamic description of the MetaDescription
* template variable. If MetaDescription is empty it will default to the
* document content.  This is useful for the meta description tag, where
* most documents can draw from the document content for a dynamic
* description. You can use the template variable for pages comprised of
* snippets and chunks only (like a blog page that only calls the ditto
* snippet)
*
* [[DynamicDescription? &descriptionTV=`MetaDescription` &id=`39` &maxWordCount=`30`]]
*
* The above example creates a dynamic description of the MetaDescription
* template variable for the document with an id of 39. If that is
* empty then it will default to the content of that document. This also
* changes the maxWordCount to 30.
*
*/

/* Parameters */

/**
* &maxWordCount
* integer (25)
* Sets the maximum word count of the description, default is 25 words
*/
if(!isset($maxWordCount) || !is_numeric($maxWordCount))
{
    $maxWordCount = 25;
}

/**
* &id
* integer ($modx->documentObject['id'])
* the id of the page you want a description for, defaults to the
* current page.
*/
if(!isset($id) || !is_numeric($id))
{
    $id = $modx->resource->get('id');
}

/**
* &descriptionTV
* string ('')
* The name of a template variable you've set up for the description.
* If you have a separate template variable set up for a description
* you write in, set that with this parameter.  If the parameter ends
* up being empty, it will default back to the content. If it is not
* empty then it will display the value of the TV and stop processing.
* In other words, it will print it just as you typed it.
*/

if(!class_exists(GearsSEO))
{
     include($modx->getOption('core_path').'/components/gears/snippets/gearsseo/gearsseo.class.php');
}

$description = new GearsSEO($modx);
return $description->GetDescription($descriptionTV, $maxWordCount, $id);
unset($description);
?>
