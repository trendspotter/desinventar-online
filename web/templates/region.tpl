{-config_load file=`$lg`.conf section="di8_region"-}
<link rel="stylesheet" href="css/desinventar.css" type="text/css">
<script type="text/javascript" src="include/prototype.js"></script>
<script type="text/javascript" src="include/diadmin.js"></script>
{-* ADMINREG: Interface to Edit Portal Admin *-}
{-if $ctl_adminreg-}
<h2>{-#ttname#-}</h2>
<br>
<div class="dwin" style="width:560px; height:250px;">
 <table class="col">
	<thead>
		<tr>
			<td class="header"><b>{-#tregcntlist#-}</b></td>
			<td class="header"><b>{-#tregnamlist#-}</b></td>
			<td class="header"><b>{-#tregadmlist#-}</b></td>
			<td class="header"><b>{-#tregactlist#-}</b></td>
			<td class="header"><b>{-#tregpublist#-}</b></td>
		</tr>
	</thead>
	<tbody id="lst_regionpa" style="overflow:auto; height:200px;">
{-/if-}
{-** ADMINREG: reload region lists **-}
{-if $ctl_reglist-}
{-foreach name=rpa key=key item=item from=$regpa-}
	<tr class="{-if ($smarty.foreach.rpa.iteration - 1) % 2 == 0-}normal{-else-}under{-/if-}"
   		onMouseOver="Element.addClassName(this, 'highlight');" onMouseOut="Element.removeClassName(this, 'highlight');"
   		onClick="uploadMsg(''); mod='regionpa'; setRegionPA('{-$item[0]-}','{-$key-}','{-$item[1]-}','{-$item[2]-}','{-$item[3]-}','{-$item[4]-}'); 
   					$('RegionUUID2').value='{-$key-}'; $('cmd').value='update';">
    <td>{-$item[0]-}</td>
    <td>{-$item[1]-}</td>
    <td>{-$item[2]-}</td>
    <td><input type="checkbox" {-if ($item[3] == 1) -} checked {-/if-} disabled></td>
    <td><input type="checkbox" {-if ($item[4] == 1) -} checked {-/if-} disabled></td>
	</tr>
{-/foreach-}
{-/if-}
{-* Continue with adminreg.. *-}
{-if $ctl_adminreg-}
  </tbody>
 </table>
</div>
  <br>
  <input id="add" type="button" value="{-#baddoption#-}" class="line"
  		onclick="setRegionPA('', '', '', '', '1','0'); $('cmd').value='insert'; $('RegionUUID').disabled=false;">
	<span id="regionpastatusmsg" class="dlgmsg"></span><br>
	<div id="regionpaaddsect" style="display:none">
   	<form name="regionpafrm" id="regionpafrm" method="GET" action="javascript: var s=$('regionpafrm').serialize(); 
		mod='regionpa'; sendData('','region.php', s, '');" onSubmit="javascript: 
		var a=new Array('CountryIsoCode','RegionUUID','RegionLabel','RegionUserAdmin'); return(checkForm(a, '{-#errmsgfrm#-}'));">
		<table class="grid">
			<tbody>
				<tr>
					<td>{-#tregcntlist#-}<b style="color:darkred;">*</b></td>
					<td>
						<select id="CountryIsoCode" name="CountryIsoCode" class="fixw">
							<option value=""></option>
{-foreach name=cnt key=key item=item from=$cntl-}
							<option value="{-$key-}">{-$item-}</option>
{-/foreach-}
						</select></td>
				</tr>
<!--					<tr>
					<td>{-#tregionuuid#-}<b style="color:darkred;">*</b></td>
					<td>
						<input id="RegionUUID" name="RegionUUID" type="text" maxlength="20" class="line fixw" disabled
							onBlur="updateList('chkruuid', 'region.php', 'cmd=chkruuid&RegionUUID='+ $('RegionUUID').value);">
						<input type="hidden" id="RegionUUID2" name="RegionUUID2">
						<span id="chkruuid"></span></td>
				</tr>-->
				<tr>
					<td>{-#tregnamlist#-}<b style="color:darkred;">*</b></td>
					<td><input id="RegionLabel" name="RegionLabel" type="text" maxlength="200" class="line fixw"></td>
				</tr>
				<tr>
					<td>{-#tregadmlist#-}<b style="color:darkred;">*</b></td>
					<td>
						<select id="RegionUserAdmin" name="RegionUserAdmin" class="fixw">
							<option value=""></option>
{-foreach name=usr key=key item=item from=$usr-}
							<option value="{-$key-}">{-$item-}</option>
{-/foreach-}
						</select></td>
				</tr>
				<tr>
					<td><a class="info" href="javascript:void(null)" 
						onMouseOver="showtip('{-$dic.DBRegionLangIsoCode[2]-}')">{-$dic.DBRegionLangIsoCode[0]-}<b style="color:darkred;">*</b><span>{-$dic.DBRegionLangIsoCode[1]-}</span></a>
					</td>
					<td><select id="RegionLangCode" name="RegionLangCode" {-$ro-} class="line fixw" 
									onFocus="showtip('{-$dic.DBRegionLangCode[2]-}')" tabindex="1">
{-foreach name=lglst key=key item=item from=$lglst-}
							<option value="{-$key-}">{-$item[0]-}</option>
{-/foreach-}
						</select>
					</td>
				</tr>
				<tr>
					<td>{-#tregactlist#-}<b>*</b></td>
					<td><input id="RegionActive" name="RegionActive" type="checkbox" checked></td>
				</tr>
				<tr>
					<td>{-#tregpublist#-}<b>*</b></td>
					<td><input id="RegionPublic" name="RegionPublic" type="checkbox"></td>
				</tr>
				<tr>
					<td colspan=2 align="center">
						<input id="cmd" name="cmd" type="hidden">
						<input type="submit" value="{-#bsave#-}" class="line">
						<input type="reset" value="{-#bcancel#-}" onClick="$('regionpaaddsect').style.display='none'; uploadMsg('');" class="line">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	</div>
{-/if-}
{-**** SHOW LIST OF REGIONS BY COUNTRY (CONTENT) ****-}
{-if $ctl_regions-}
<h2>{-$cnt-}</h2>
<p align="justify">
{-#tviewdbase#-}<br>
{-if $ctl_available-}
<select onChange="updateList('shwreg', 'region.php', 'r='+ this.value)" size=4 style="width: 500px;">
{-foreach name=dbs key=key item=item from=$dbs-}
	<option value="{-$key-}" class="regl">{-$item-}</option>
{-/foreach-}
</select>
<div id="shwreg"></div>
{-else-}
 <br>{-#tdbnotavail#-}
{-/if-}
</p><br>
{-/if-}
{-** REGION INDEX: show main option according with user and database **-}
{-if $ctl_index-}
  <p style="font-size:14px;">Bienvenido {-if $userid != ""-}<b>{-$userid-}</b>{-else-}a DesInventar8{-/if-},</p>
  <br>
 {-if $ctl_noregion-}
  <b>{-#tviewdbase#-}</b><br>
  {-foreach name=regions key=key item=item from=$reglst-}
  * <a href="javascript:void(null)" onClick="parent.window.location = 'index.php?r={-$key-}'">{-$item-}</a><br>
  {-/foreach-}
 {-/if-}
  <hr>
{-/if-}
{-***** REGINFO: Show Region Info - CONTENT SECTION *****-}
{-if $ctl_showreg || $ctl_reginfo-}
 <table border=0 style="width:550px; font-family:Lucida Grande, Verdana; font-size:10px;">
  <tr>
	<td valign="center"><img src="region.php?r={-$reg-}&view=logo"></td>
	<td valign="top">
 	  <h2>{-$regname-}</h2>
{-if $period[0] != "" && $period[1] != ""-}
	 {-#tperiod#-}: {-$period[0]-} - {-$period[1]-}<br>
{-/if-}
     {-#trepnum#-}: {-$dtotal-}<br>
     {-#tlastupd#-}: {-$lstupd-}<br>
	</td>
  </tr>
 {-if !$ctl_reginfo-}
<!--
  {-if $ctl_showdimod-}
	  <img id="dimod" src="images/b_desinventar1.jpg" border="0" style="cursor: pointer;"
		onClick="$('dimod').src='images/b_desinventar2.jpg'; runWin('desinventar/cards.php?r={-$reg-}', 'desinventar');"
		onMouseOver='$("dimod").src="images/b_desinventar3.jpg"; $("modinfo").innerHTML="{-#tmoddesinv#-}";'
		onMouseOut="$('dimod').src='images/b_desinventar1.jpg'; $('modinfo').innerHTML='';"></a> &nbsp;&nbsp; &nbsp;&nbsp;
  {-/if-}
  {-if $ctl_showdcmod-}
	  <img id="dcmod" src="images/b_desconsultar1.jpg" style="cursor: pointer;"
		onClick="$('dcmod').src='images/b_desconsultar2.jpg'; runWin('desinventar/index.php?r={-$reg-}{-if $isvreg-}&v=true{-/if-}', 'desconsultar');"
		onMouseOver='$("dcmod").src="images/b_desconsultar3.jpg"; $("modinfo").innerHTML="{-#tmoddescon#-}";'
		onMouseOut="$('dcmod').src='images/b_desconsultar1.jpg'; $('modinfo').innerHTML='';">
  {-else-}
	  <b>{-#tnopublic#-}</b><br>
  {-/if-}
      <div id="modinfo" class="dlgmsg" style="text-align:center;"></div><br>
-->
 {-/if-}
  <tr>
	<td colspan=2 align="center"><!--
  {-if $userid == ""-}
	* USER LOGIN<br>
	* FIND DATABASES <br>
  {-else-}
	* MY DATABASES<br>
   {-if $role == "USER" || $role == "SUPERVISOR"-}
    * INSERT CARDS (ADMIN,USER,SUPER)<br>
   {-elseif $role == "ADMINREGION"-}
    * INSERT CARDS (ADMIN,USER,SUPER)<br>
    * CONFIG DATABASE (ADMIN)<br>
   {-/if-}
  {-/if-}-->
  {-if $ctl_inactivereg-}
	  <b>{-#tinactive#-}</b><br>
  {-/if-}
   </td>
  </tr>
  <tr>
   <td colspan="2">
	<a href="javascript:void(null)" onClick="$('info').style.display='block';">More info</a>
	<div id="info" style="display:none" align="justify">
 {-foreach name=info key=k item=i from=$info-}
  {-if $i != ""-}
	<b>{-$k-}</b><br>{-$i-}<br>
  {-/if-}
 {-/foreach-}
	</div>
   </td>
  </tr>
 </table>
{-/if-}

{-*** CHECK Region ID MESSAGES - STATUS SPAN ***-}
{-if $ctl_chkruuid-}
 {-if $cregion-}
 	{-#tvalregid#-}
 {-else-}
 	{-#tinvregid#-}
 {-/if-}
{-/if-}

{-*** INSERT OR UPDATE MESSAGES - STATUS SPAN ***-}
{-if $ctl_admregmess-}
 {-if $cfunct == 'insert'-}
 	{-#tinsert#-}
 {-elseif $cfunct == 'update'-}
  {-#tupdate#-}
 {-else-}
  {-#terrinsupd#-}
 {-/if-}
 {-if $csetrole-}
 	{-#tsetrole#-}
 {-else-}
  {-#terrsetrole#-} [{-$errsetrole-}]
 {-/if-}
 {-$regid-}
{-/if-}
