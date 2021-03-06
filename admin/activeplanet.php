<?php

/**
 * activeplanet.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */
define('INSIDE', true);
define('INSTALL', false);
define('IN_ADMIN', true);

require('../common.' . substr(strrchr(__FILE__, '.'), 1));

if ($user['authlevel'] < 1)
{
  AdminMessage($lang['adm_err_denied']);
}

$parse = $lang;

$PageTPL = gettemplate('admin/activeplanet_body', true);
$AllActivPlanet = doquery("SELECT * FROM {{planets}} WHERE `last_update` >= '" . (time() - 15 * 60) . "' ORDER BY `id` ASC");
$Count = 0;

while ($ActivPlanet = mysql_fetch_assoc($AllActivPlanet))
{
  $parse['online_list'] .= "<tr>";
  $parse['online_list'] .= "<td class=b><center><b>" . $ActivPlanet['name'] . "</b></center></td>";
  $parse['online_list'] .= "<td class=b><center><b>[" . $ActivPlanet['galaxy'] . ":" . $ActivPlanet['system'] . ":" . $ActivPlanet['planet'] . "]</b></center></td>";
  $parse['online_list'] .= "<td class=m><center><b>" . pretty_number($ActivPlanet['points'] / 1000) . "</b></center></td>";
  $parse['online_list'] .= "<td class=b><center><b>" . pretty_time(time() - $ActivPlanet['last_update']) . "</b></center></td>";
  $parse['online_list'] .= "</tr>";
  $Count++;
}
$parse['online_list'] .= "<tr>";
$parse['online_list'] .= "<th class=\"b\" colspan=\"4\">" . $lang['adm_pl_they'] . " " . $Count . " " . $lang['adm_pl_apla'] . "</th>";
$parse['online_list'] .= "</tr>";

$page = parsetemplate($PageTPL, $parse);
display($page, $lang['adm_pl_title'], false, '', true);

?>
