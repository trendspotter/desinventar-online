{-config_load file="$lg.conf" section="dc_thematicmap"-}
{-config_load file="$lg.conf" section="dc_qdetails"-}
{-**** SHOW RESULTS ****-}
{-if $ctl_showres-}
	{-include file="maps_include.tpl"-}
	<style type="text/css">
		#map {	width: 100%; height: 100%; border: 1px solid black; }
		#queryOut {	width:800px; height: 200px; border: 1px solid black;
								position:absolute; left:10px; top:500px; overflow:auto; }
	</style>

	<table class="grid" height="100%">
		<tr>
			<td>
				{-$mapfilename-}
			</td>
		</tr>
		<tr>
			<td valign="top">
				<div class="dwin" style="width:250px;">
					<p align="right">{-#trepnum#-}: {-$MapNumberOfRecords-}</p>
					<hr />
					<h4 id="defaultMapTitle">{-#tmapof#-} {-$rgl[0].info.TITLE-}</h4>
					<div align="justify" class="dwin" style="height:250px;">{-#lev#-}: {-$rgl[0].info.LEVEL-}; 
						{-foreach key=k item=i from=$rgl[0].info-}
							{-if $k == "GEO"-}<i>{-#geo#-}:</i> {-$i-}; {-/if-}
							{-if $k == "EVE"-}<i>{-#eve#-}:</i> {-$i-}; {-/if-}
							{-if $k == "CAU"-}<i>{-#cau#-}:</i> {-$i-}; {-/if-}
							{-if $k == "EFF"-}<i>{-#eff#-}:</i> {-$i-}; {-/if-}
							{-if $k == "BEG"-}<i>{-#beg#-}:</i> {-$i-}; {-/if-}
							{-if $k == "END"-}<i>{-#end#-}:</i> {-$i-}; {-/if-}
							{-if $k == "SOU"-}<i>{-#sou#-}:</i> {-$i-}; {-/if-}
							{-if $k == "SER"-}<i>{-#ser#-}:</i> {-$i-}; {-/if-}
						{-/foreach-}
						{-$rgl[0].regname-}
					</div>
					<hr />
					<image src="{-$desinventarURL-}/images/ge_icon.png" /><a href="{-$desinventarURL-}/thematicmap.php?r={-$reg-}&cmd=getkml">{-#tgetgearth#-}</a>
					<hr />
					<img src="{-$legend-}" /><br />
				</div>
			</td>
			<td valign="top">
				<input type="text" id="MapTitle" name="MapTitle" size=110 />
				<img id="linkRestoreMapTitle" border="0" src="{-$desinventarURL-}/images/reload.jpg"><br />
				<div id="map" class="dwin" style="width:700px; height:530px"></div>
			</td>
		</tr>
	</table>
	<div style="display:none;">
		<input type="hidden" id="prmMapRegionId" value="{-$reg-}"/>
		<input type="hidden" id="prmMapLat"      value="{-$lat-}"/>
		<input type="hidden" id="prmMapLon"      value="{-$lon-}"/>
		<input type="hidden" id="prmMapZoom"     value="{-$zoom-}"/>
		<input type="hidden" id="prmMapMinX"     value="{-$minx-}"/>
		<input type="hidden" id="prmMapMinY"     value="{-$miny-}"/>
		<input type="hidden" id="prmMapMaxX"     value="{-$maxx-}"/>
		<input type="hidden" id="prmMapMaxY"     value="{-$maxy-}"/>
		<input type="hidden" id="prmMapServer"   value="{-$mps-}"/>
		<input type="hidden" id="prmMapBase"     value="{-$basemap-}"/>
	</div>
	<div id="MapEffectLayers" style="display:none;">
		{-foreach name=rgl key=k item=i from=$rgl-}
			<div id=EffectLayer{-$k-}>
				<span>{-$i.regname-}</span>
				<span>{-$i.map-}</span>
				<span>{-$i.ly1-}</span>
			</div>
		{-/foreach-}
	</div>
	<div id="MapAdminLayers" style="display:none;">
		{-foreach name=glev key=ky item=it from=$glev-}
			<div id=AdminLayer{-$smarty.foreach.glev.iteration-}>
				<span>{-$it[0]-}</span>
				<span>{-foreach name=ly key=k2 item=i2 from=$it[2]-}{-$i2[0]-}admin0{-$ky-}{-if !$smarty.foreach.ly.last-},{-/if-}{-/foreach-}</span>
			</div>
		{-/foreach-}
	</div>
{-else-}
	{-#msgMapNoData#-}
{-/if-}
