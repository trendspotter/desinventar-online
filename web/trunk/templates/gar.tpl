{-config_load file=`$lg`.conf section="di8_web"-}
{-if     $page == "news"-}			{-if $lg == "es"-} Noticias {-else-} News {-/if-}
{-elseif $page == "projects"-}	{-if $lg == "es"-} Proyectos {-else-} Projects {-/if-}
{-elseif $page == "documents"-}	{-if $lg == "es"-} Documentos {-else-} Documents {-/if-}
{-elseif $page == "credits"-}		{-if $lg == "es"-} Créditos {-else-} Credits {-/if-}
{-elseif $page == "contact"-}		{-if $lg == "es"-} Contacto {-else-} Contact {-/if-}
{-else-}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/desinventar.css" TYPE="text/css">
	<link rel="stylesheet" href="css/portal.css" TYPE="text/css">
	<script type="text/javascript" src="include/prototype.js"></script>
	<script type="text/javascript" src="include/diadmin.js.php"></script>
	<script type="text/javascript" src="include/menu.js"></script>
	<title>DesInventar - GAR-ISDR</title>
	<script type="text/javascript" language="javascript">
		window.onload = function() {
			updateList('pagecontent', 'index.php', 'p=MainPagewhatis');
		}
	</script>
</head>

<body>
<table width=839 border=0 cellpadding=0 cellspacing=0 align=center style="margin-top:4px">
<tr valign=top>
 <td style="background:url(images/bg1.gif) 0px -1px"><img src="images/e1.gif" width=16 height=74 border=0></td>
 <td>
	<table width=807 border=0 cellpadding=0 cellspacing=0>
	 <tr><td colspan="2"><img src="images/10.gif" width="807" height="15"></td></tr>
	 <tr valign="top">
		<td style="background:url(images/diorg.jpg);width:462px;height:92px">
			<div id="version">&nbsp;</div>
			<div id="slogan">{-#tdititle#-}</div>
		</td>
		<td><img src="images/11.jpg" width=345 height=92 border=0></td>
	 </tr>
	</table>
	<!-- menu hor -->
	<table width=807 border=0 cellpadding=0 cellspacing=0>
	 <tr valign=top><td width=182><img src="images/21.gif" width=182 height=52></td>
		<td width=585 style="background:url(images/22.gif);" align="right">
			<span id="dostat" style="color: #e1ac00; float:left; font-size:8pt;"></span>
			<div align="right"><img src="images/23.jpg" width="305" height="13"></div>
			<table border=0 cellpadding=0 cellspacing=0 class="menu" style="margin-top:1px">
			 <tr>
			 	<td class="sel"><a href="http://www.desinventar.org/" target=_blank>DesInventar.org</a></td>
				<td class="sel"><a href="index.php">DesInventar 8</a></td>
<!--
				<td class="sel"><a href="javascript:void(null);" onclick="updateList('pagecontent', 'http://www.desinventar.org/sp/proyectos/index.html', 'p=projects')">Proyectos</a></td>
				<td class="sel"><a href="javascript:void(null);" onclick="updateList('pagecontent', 'http://www.desinventar.org/sp/software/index.html', 'p=software')">Software</a></td>
				<td class="sel"><a href="javascript:void(null);" onclick="updateList('pagecontent', 'index.php','p=MainPagecredits')">Créditos</a></td>
				<td class="sel"><a href="javascript:void(null);" onclick="updateList('pagecontent', 'index.php','p=MainPagecontactus')">Contácto</a></td>
-->
				<td><a href="javascript:void(null);" onMouseover="dropdownmenu(this, event, 'idioma')">{-#tlang#-}</a>
					<div id="idioma" class="submenu">
						<a href="?lang=en">English</a>
						<a href="?lang=es">Español</a>
					</div>
				</td>
			 </tr>
			</table>
		</td>
		<td width=40><img src="images/24.jpg" width=40 height=52 border=0></td>
	 </tr>
	</table>
	<!-- fin menu hor -->
	<table width=807 border=0 cellpadding=0 cellspacing=0>
	 <tr valign="top">
		<td class="izq">
		<!-- Regions -->
		<script type="text/javascript" language="javascript">
		// personalization List menu..
		function displayList(elem) {
			lst = 3;
			for (i=1; i <= lst; i++) {
				if (i == elem)
					$("sect"+ i).style.display = 'block';
				else
					$("sect"+ i).style.display = 'none';
			}
		}
		</script>
		<table bgcolor="#CF9D15" border=0 cellpadding=0 cellspacing=0>
			<tr><td>
				<table width="133" border=0 cellpadding=0 cellspacing=0 align=center>
					<tr><td><img src="images/p_paises1.gif" width=5 height=16></td>
							<td width="32px" bgcolor="#fcc700">GAR-ISDR</td>
					<td><img src="images/p_paises3.gif" width=73 height=16></td></tr>
					<tr><td colspan="3">
						<img src="images/p_ini.gif" width="133" height="5"></td></tr>
				<!-- ASIAN-->
					<tr><td class="paisel" colspan="3">
						<a href="javascript:void(null);" 
								onClick="displayList('1');">Asia</a></td></tr>
					<tr><td colspan="3">
						<img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
				</table>
				<table width="133" border=0 cellpadding=0 cellspacing=0 align=center id="sect1" style="display:none;">
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=INORISSA');">India - Orissa</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=INTAMILNADU');">India - Tamil Nadu</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=IRAN');">Iran</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=NEPAL');">Nepal</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=SRILANKA');">Srilanka</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
				</table>
				<!-- LATIN AMERICA -->
				<table width="133" border=0 cellpadding=0 cellspacing=0 align=center>
					<tr><td class="paisel">
						<a href="javascript:void(null);" 
								onClick="displayList(2);">Latin America</a></td></tr>
					<tr><td>
						<img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
				</table>
				<table width="133" border=0 cellpadding=0 cellspacing=0 align=center id="sect2" style="display:none;">
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=ARGENTINA');">Argentina</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=BOLIVIA');">Bolivia</a>
					</td></tr>
					<tr><td><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=COLOMBIA');">Colombia</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=COSTARICA');">Costa Rica</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=ECUADOR');">Ecuador</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=SALVADOR');">El Salvador</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=MEXICO');">México</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=PERU');">Perú</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=VENEZUELA');">Venezuela</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
				</table>
				<!-- CITIES -->
				<table width="133" border=0 cellpadding=0 cellspacing=0 align=center>
					<tr><td class="paisel">
						<a href="javascript:void(null);" 
								onClick="displayList(3);">{-#treg7#-}</a></td></tr>
				</table>
				<table width="133" border=0 cellpadding=0 cellspacing=0 align=center id="sect3" style="display:none;">
					<tr><td class="pais" colspan="3">&nbsp;&nbsp;&nbsp; >
						<a href="javascript:void(null);" onclick="updateList('pagecontent', 'region.php', 'r=COLCALI');">Cali - Colombia</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_sep.gif" width=133 height=6 border=0></td></tr>
				</table>
				<table width="133" border=0 cellpadding=0 cellspacing=0 align=center>
					<tr><td colspan="3"><img src="images/p_fin.gif" width="133" height="5"></td></tr>
				</table>
				<br>
				<table width="133" border=0 cellpadding=0 cellspacing=0 align=center>
					<tr><td><img src="images/p_paises1.gif" width=5 height=16></td>
							<td width="103px" bgcolor="#fcc700">{-#tvirtualreg#-}</td>
							<td><img src="images/p_paises3.gif" width=25 height=16></td></tr>
					<tr><td colspan="3"><img src="images/p_ini.gif" width="133" height="5"></td></tr>
					<tr><td class="pais" colspan="3">
						<a href="javascript:void(null)" onclick="updateList('pagecontent', 'region.php', 'r=CAN&v=true')">SubRegión Andina</a>
					</td></tr>
					<tr><td colspan="3"><img src="images/p_fin.gif" width="133" height="5"></td></tr>
				</table>
			</td></tr>
			<tr><td><img src="images/25.gif" width=150 height=52></td></tr>
		</table>
		<!-- References -->
		<table bgcolor="#CF9D15" border=0 cellpadding=0 cellspacing=0 align="center">
			<tr><td bgcolor="white" align="center">
				<a href="http://www.unisdr.org" target="_blank"><img src="images/logos/UNISDR.gif" border="0"></a><br>
				<a href="http://www.undp.org" target="_blank"><img src="images/logos/UNDP.gif" border="0"></a><br>
				<a href="http://www.gripweb.org" target="_blank"><img src="images/logos/GRIPweb.jpg" border="0"></a>
			</td></tr>
		</table>
		<!-- end left-menu -->
		</td>
		<td class="centro">
			<div id="pagecontent"></div>
		</td>
		<td class="der"><img src="images/bgder.gif" width=32 height=5></td>
	 </tr>
	</table>
 </td>
 <td style="background:url(images/bg2.gif) 0px -1px"><img src="images/e2.gif" width=16 height=74 border=0></td>
</tr>
<tr valign=bottom>
 <td style="background:url(images/bg1.gif) 0px -1px"><img src="images/e3.gif" width="16" height=85 border=0></td>
 <td>
	<table width=807 border=0 cellpadding=0 cellspacing=0 style="background:url(images/40_1.gif) left bottom no-repeat">
	 <tr><td width="182"><img src="images/31_1.gif" width="182" height="22" border=0></td>
		<td style="background:url(images/32_1.gif)"><img src="images/32_1.gif" width="1" height="22" border=0></td>
		<td width="40"><img src="images/33_1.gif" width="40" height="22" border=0></td>
	 </tr>
	 <tr><td colspan="3">
		<div align="right" style="margin-right:30px;">
			<img src="images/logos/osso_lared.jpg" border=0>
		</div>
	 </td></tr>
	</table>
	<img src="images/40.gif" width=807 height=15 border="0">
 </td>
 <td style="background:url(images/bg2.gif) 0px -1px"><img src="images/e4.gif" width="16" height=85 border=0></td>
</tr>
</table>
</body>
</html>
{-/if-}
