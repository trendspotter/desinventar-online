	<div id="DBConfig_tabs">
		<ul>
			<li><a class="classDBConfig_tabs" href="#DBConfig_tabs-1"    cmd="cmdDBInfoEdit"      data-url="{-$desinventarURL-}/info.php"        >{-#mreginfo#-}</a></li>
			<li><a class="classDBConfig_tabs" href="#DBConfig_Geolevels" cmd=""                                                                  >{-#msgDBConfig_Geolevels#-}</a></li>
			<li><a class="classDBConfig_tabs" href="#DBConfig_tabs-3"    cmd="cmdDBInfoGeography" data-url="{-$desinventarURL-}/geography.php"   >{-#mgeography#-}</a></li>
			<li><a class="classDBConfig_tabs" href="#DBConfig_Events"    cmd=""                                                                  >{-#msgDBConfig_Events#-}</a></li>
			<li><a class="classDBConfig_tabs" href="#DBConfig_tabs-5"    cmd="cmdDBInfoCause"     data-url="{-$desinventarURL-}/causes.php"      >{-#mcauses#-}</a></li>
			<li><a class="classDBConfig_tabs" href="#DBConfig_tabs-6"    cmd="cmdDBInfoEEField"   data-url="{-$desinventarURL-}/extraeffects.php">{-#meeffects#-}</a></li>
			<li><a class="classDBConfig_tabs" href="#DBConfig_Users"     cmd=""                                                                  >{-#msgDBConfig_RolesAndDiffusion#-}</a></li>
		</ul>
		<div id="DBConfig_tabs-1">
			<div class="tooltip hidden">
			</div>
			<div class="content">
			</div>
		</div>
		<div id="DBConfig_Geolevels">
			<div class="tooltip hidden">{-#msgGeolevels_Tooltip#-}</div>
			<div class="content">
				{-include file="database_geolevels.tpl"-}
			</div>
		</div>
		<div id="DBConfig_tabs-3">
			<div class="tooltip hidden">{-#msgGeolevels_Tooltip#-}</div>
			<div class="content">
			</div>
		</div>
		<div id="DBConfig_Events">
			<div class="tooltip hidden"></div>
			<div class="content">
				{-include file="database_events.tpl"-}
			</div>
		</div>
		<div id="DBConfig_tabs-5">
			<div class="tooltip hidden">
			</div>
			<div class="content">
			</div>
		</div>
		<div id="DBConfig_tabs-6">
			<div class="tooltip hidden">
			</div>
			<div class="content">
			</div>
		</div>
		<div id="DBConfig_Users">
			<div class="tooltip hidden">
			</div>
			<div class="content">
				{-include file="database_users.tpl"-}
			</div>
		</div>
	</div>
