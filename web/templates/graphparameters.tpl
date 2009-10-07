<!-- BEGIN GRAPHIC PARAMETERS -->
{-config_load file=`$lg`.conf section="di8_index"-}

<button id="grp-btn" class="rounded" ext:qtip="{-#tgraphicmsg#-}"><span>{-#bgraphic#-}</span></button>
<div id="grp-win" class="x-hidden">
	<div class="x-window-header">{-#bgraphic#-}</div>
	<div id="grp-cfg">
		<form id="CG" method="POST">
			<table class="conf" cellpadding=1 cellspacing=1>
			<tr valign="top"  style="height:30px;">
				<td colspan=3 align="center">
					<b>{-#gopttitle#-}</b><input type="text" name="_G+Title" class="line fixw" />
					<!--<b>{-#goptsubtit#-}</b><br>-->
				</td>
			</tr>
			<tr valign="top">
				<td align="right">
					<u>{-#gveraxis#-} 1:</u><br>
					<b onMouseOver="showtip('{-$dic.GraphField[2]-}');">{-$dic.GraphField[0]-}</b><br>
					<select id="_G+Field" name="_G+Field" onMouseOver="showtip('{-$dic.GraphField[2]-}');" class="line">
						<option value="D.DisasterId||" selected>{-$dic.GraphDisasterId_[0]-}</option>
					{-foreach name=ef1 key=k item=i from=$ef1-}
						<option value="D.{-$k-}Q|>|-1">{-$i[0]-}</option>
						<option value="D.{-$k-}|=|-1">{-#tauxhave#-} {-$i[0]-}</option>
					{-/foreach-}
					{-foreach name=ef2 key=k item=i from=$ef2-}
						<option value="D.{-$k-}|>|-1">{-$i[0]-}</option>
					{-/foreach-}
					{-foreach name=ef3 key=k item=i from=$ef3-}
						<option value="D.{-$k-}|>|-1">{-$i[0]-}</option>
					{-/foreach-}
					{-foreach name=ef3 key=k item=i from=$sec-}
						<option value="D.{-$k-}|=|-1">{-#tauxaffect#-} {-$i[0]-}</option>
					{-/foreach-}
						<option disabled>___</option>
					{-foreach name=eef key=k item=i from=$exteffel-}
						{-if $i[2] == "INTEGER" || $i[2] == "DOUBLE"-}
							<option value="E.{-$k-}|>|-1">{-$i[0]-}</option>
						{-/if-}
					{-/foreach-}
					</select>
					<br />
					<b onMouseOver="showtip('{-$dic.GraphScale[2]-}');">{-$dic.GraphScale[0]-}</b><br />
					<select id="_G+Scale" name="_G+Scale" onMouseOver="showtip('{-$dic.GraphScale[2]-}');" class="line">
						<option value="textint" selected>{-#gscalin#-}</option>
						<option value="textlog">{-#gscalog#-}</option>
					</select>
					<br />
					<b onMouseOver="showtip('{-$dic.GraphShow[2]-}');">{-$dic.GraphShow[0]-}</b><br />
					<select id="_G+Data" name="_G+Data" onMouseOver="showtip('{-$dic.GraphShow[2]-}');" class="line">
						<option value="VALUE">{-#gshwval#-}</option>
						<option id="_G+D_perc" value="PERCENT" disabled>{-#gshwperce#-}</option>
						<option id="_G+D_none" value="NONE" selected>{-#gshwnone#-}</option>
					</select>
					<br />
					<b onMouseOver="showtip('{-$dic.GraphMode[2]-}');">{-$dic.GraphMode[0]-}</b><br/>
					<select id="_G+Mode" name="_G+Mode" onMouseOver="showtip('{-$dic.GraphMode[2]-}');" class="line">
						<option value="NORMAL" selected>{-#gmodnormal#-}</option>
						<option id="_G+M_accu" value="ACCUMULATE">{-#gmodaccumul#-}</option>
						<option id="_G+M_over" value="OVERCOME" disabled>{-#gmodovercome#-}</option>
					</select>
				</td>
				<td align="center">
					<table border="1" width='90%' height='100%'>
					<tr>
						<td align="center">
							<!--<b onMouseOver="showtip('{-$dic.GraphKind[2]-}');">{-$dic.GraphKind[0]-}</b><br>-->
							<select id="_G+Kind" name="_G+Kind" size="3" onChange="grpSelectbyKind();"
								onMouseOver="showtip('{-$dic.GraphKind[2]-}');" class="line">
								<option value="BAR" selected>{-#gkndbars#-}</option>
								<option id="_G+K_line" value="LINE">{-#gkndlines#-}</option>
								<option id="_G+K_pie" value="PIE" disabled>{-#gkndpie#-}</option>
							</select>
							<br /><br />
							<!--<b onMouseOver="showtip('{-$dic.GraphFeel[2]-}');">{-$dic.GraphFeel[0]-}</b><br>-->
							<select id="_G+Feel" name="_G+Feel" size="2" onMouseOver="showtip('{-$dic.GraphFeel[2]-}');" class="line">
								<option value="2D">{-#gfee2d#-}</option>
								<option value="3D" selected>{-#gfee3d#-}</option>
							</select>
						</td>
					</tr>
					</table>
				</td>
				<td>
					<u>{-#gveraxis#-} 2:</u><br />
					<b onMouseOver="showtip('{-$dic.GraphField[2]-}');">{-$dic.GraphField[0]-}</b><br />
					<select id="_G+Field2" name="_G+Field2" size="1" onMouseOver="showtip('{-$dic.GraphField[2]-}');"
						onChange="enab($('_G+Scale2')); enab($('_G+Data2')); enab($('_G+Mode2'));" class="line">
						<option value="" selected></option>
						<option value="D.DisasterId||">{-$dic.GraphDisasterId_[0]-}</option>
						{-foreach name=ef1 key=k item=i from=$ef1-}
							<option value="D.{-$k-}Q|>|-1">{-$i[0]-}</option>
							<option value="D.{-$k-}|=|-1">{-#tauxhave#-} {-$i[0]-}</option>
						{-/foreach-}
						{-foreach name=ef2 key=k item=i from=$ef2-}
							<option value="D.{-$k-}|>|-1">{-$i[0]-}</option>
						{-/foreach-}
						{-foreach name=ef3 key=k item=i from=$ef3-}
							<option value="D.{-$k-}|>|-1">{-$i[0]-}</option>
						{-/foreach-}
						{-foreach name=ef3 key=k item=i from=$sec-}
							<option value="D.{-$k-}|=|-1">{-#tauxaffect#-} {-$i[0]-}</option>
						{-/foreach-}
						<option disabled>___</option>
						{-foreach name=eef key=k item=i from=$exteffel-}
							{-if $i[2] == "INTEGER" || $i[2] == "DOUBLE"-}
								<option value="E.{-$k-}|>|-1">{-$i[0]-}</option>
							{-/if-}
						{-/foreach-}
					</select>
					<br />
					<b onMouseOver="showtip('{-$dic.GraphScale[2]-}');">{-$dic.GraphScale[0]-}</b><br />
					<select id="_G+Scale2" name="_G+Scale2" class="disabled line" disabled
						onMouseOver="showtip('{-$dic.GraphScale[2]-}');">
						<option value="int" selected>{-#gscalin#-}</option>
						<option value="log">{-#gscalog#-}</option>
					</select>
					<br />
					<b onMouseOver="showtip('{-$dic.GraphShow[2]-}');">{-$dic.GraphShow[0]-}</b><br />
					<select id="_G+Data2" name="_G+Data2" class="disabled line" disabled 
						onMouseOver="showtip('{-$dic.GraphShow[2]-}');">
						<option value="VALUE">{-#gshwval#-}</option>
						<option id="_G+D_perc2" value="PERCENT" disabled>{-#gshwperce#-}</option>
						<option id="_G+D_none2" value="NONE" selected>{-#gshwnone#-}</option>
					</select>
					<br />
					<b onMouseOver="showtip('{-$dic.GraphMode[2]-}');">{-$dic.GraphMode[0]-}</b><br />
					<select id="_G+Mode2" name="_G+Mode2" class="disabled line" disabled
						onMouseOver="showtip('{-$dic.GraphMode[2]-}');">
						<option value="NORMAL" selected>{-#gmodnormal#-}</option>
						<option id="_G+M_accu2" value="ACCUMULATE">{-#gmodaccumul#-}</option>
						<option id="_G+M_over2" value="OVERCOME" disabled>{-#gmodovercome#-}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table border=0 height="100%">
					<tr>
						<td colspan="2" align="center">
							<p><u>{-#ghoraxis#-}:</u></p>
						</td>
					</tr>
					<tr>
						<td>
							<b>{-#ghistogram#-}</b>
						</td>
						<td>
							<select id="_G+TypeH" onChange="grpSelectbyType('_G+TypeH');" class="line"
								onMouseOver="showtip('{-$dic.GraphType[2]-}');">
								<option value="" disabled></option>
								<option value="D.DisasterBeginTime" selected>{-$dic.GraphHisTemporal[0]-}</option>
								<option value="D.DisasterBeginTime|D.EventId">{-$dic.GraphHisEveTemporal[0]-}</option>
								{-foreach name=glev key=k item=i from=$glev-}
								<option value="D.DisasterBeginTime|D.GeographyId_{-$k-}">{-$i[0]-} {-$dic.GraphHisGeoTemporal[0]-}</option>
								{-/foreach-}
								<option value="D.DisasterBeginTime|D.CauseId">{-$dic.GraphHisCauTemporal[0]-}</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<b onMouseOver="showtip('{-$dic.GraphPeriod[2]-}');">{-$dic.GraphPeriod[0]-}
						</td>
						<td>
							<select id="_G+Period" name="_G+Period" onChange="$('_G+Stat').value = '';" class="line"
								onMouseOver="showtip('{-$dic.GraphPeriod[2]-}');">
								<option value=""></option>
								<option value="YEAR" selected>{-#gperannual#-}</option>
								<option value="YMONTH">{-#gpermonth#-}</option>
								<option value="YWEEK">{-#gperweek#-}</option>
								<option value="YDAY">{-#gperday#-}</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<b onMouseOver="showtip('{-$dic.GraphSeaHistogram[2]-}');">{-#GHISTOANNUAL#-}</b>
							<select id="_G+Stat" name="_G+Stat" onChange="$('_G+Period').value = '';" class="line"
								onMouseOver="showtip('{-$dic.GraphSeaHistogram[2]-}');">
								<option value=""></option>
								<option value="DAY">{-#gseaday#-}</option>
								<option value="WEEK">{-#gseaweek#-}</option>
								<option value="MONTH">{-#gseamonth#-}</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<b>{-#gcomparative#-}</b>
						</td>
						<td>
							<select id="_G+TypeC" onChange="grpSelectbyType('_G+TypeC');" class="line"
								onMouseOver="showtip('{-$dic.GraphType[2]-}');">
								<option value="" disabled selected></option>
								<option value="D.EventId">{-$dic.GraphComByEvents[0]-}</option>
								<option value="D.CauseId">{-$dic.GraphComByCauses[0]-}</option>
								{-foreach name=glev key=k item=i from=$glev-}
								<option value="D.GeographyId_{-$k-}">{-$dic.GraphComByGeography[0]-} {-$i[0]-}</option>
								{-/foreach-}
							</select>
						</td>
					</tr>
					</table>
					<input type="hidden" id="_G+Type" name="_G+Type" value="D.DisasterBeginTime" />
				</td>
				<td></td>
			</tr>
			</table>
			<input type="hidden" id="_G+cmd" name="_G+cmd" value="result" />
		</form>
	</div>
</div>
