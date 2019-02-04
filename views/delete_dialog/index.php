<?php 

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div style='width:500px;margin:auto;'>
 <h3> Ihr Account ist zur L�schung am <?= $expiration ?> vorgemerkt. </h3>
 <ul>
 <li> Um den L�schvorgang zu verhindern, klicken Sie 'Account nicht l�schen'. </li>
 <li> Um das System bis zum L�schvorgang weiter zu nutzen klicken Sie 'Hinweis ignorieren'. </li>
 <ul>
</div>
<div style='width:500px;margin:auto;'>
 <a class ='button' href ="<?=$controller->url_for('deleteDialog/save/1')?>" > Account nicht l�schen </a>             <!--    //account status = 0 && unset expiration date -->
 <a class ='button' href ="<?=$GLOBALS['ABSOLUTE_URI_STUDIP']?>" > Hinweis ignorieren </a>                 <!--   //account_status = 3  -->
</div>
