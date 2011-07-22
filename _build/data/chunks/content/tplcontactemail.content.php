<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
return '
<p>This is a response sent by [[+fname]] [[+lname]] using the feedback form on the website. The details of the message follow below:</p>
<table>
<tr valign="top"><td><b>First Name:</b></td><td>[[+fname]]</td></tr>
<tr valign="top"><td><b>Last Name:</b></td><td>[[+lname]]</td></tr>
<tr valign="top"><td><b>Email:</b></td><td>[[+email]]</td></tr>
<tr valign="top"><td><b>Address1:</b></td><td>[[+address1]]</td></tr>
<tr valign="top"><td><b>Address2:</b></td><td>[[+address2]]</td></tr>
<tr valign="top"><td><b>City:</b></td><td>[[+city]]</td></tr>
<tr valign="top"><td><b>State:</b></td><td>[[+state]]</td></tr>
<tr valign="top"><td><b>Zip:</b></td><td>[[+zip]]</td></tr>
<tr valign="top"><td colspan="2"><b>Comments:</b><br>[[+comments]]</td></tr>
</table>
<p>You can use this link to reply: <a href="mailto:[[+email]]?subject=RE:[[+subject]]">[[+email]]</a></p>
';
?>
