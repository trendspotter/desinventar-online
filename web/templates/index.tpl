{-config_load file="$lg.conf" section="grpDatacard"-}
{-config_load file="$lg.conf" section="grpMainStrings"-}
{-config_load file="$lg.conf" section="grpMenuUser"-}
{-config_load file="$lg.conf" section="querydef"-}
{-config_load file="$lang.conf" section="grpDatabaseFind"-}
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>DesInventar</title>
		<script type="text/javascript" src="{-$desinventarURL-}/scripts/prototype.js"></script>
		<!-- jQuery -->
		{-include file="jquery.tpl"-}
		<!-- ExtJS -->
		{-include file="extjs.tpl"-}

		<link rel="stylesheet" type="text/css" href="{-$desinventarURL-}/css/desinventar-{-$jsversion-}.css" />

		<script type="text/javascript" src="{-$desinventarURL-}/external/jquery.jec-1.3.3.js"></script>
		<script type="text/javascript" src="{-$desinventarLibs-}/valums-fileuploader/valums-fileuploader-b3b20b1-patched/fileuploader.js"></script>
		{-if $desinventarMode=='normal'-}
			<script type="text/javascript" src="{-$desinventarURL-}/scripts/other-{-$jsversion-}.js"></script>
			<script type="text/javascript" src="{-$desinventarURL-}/scripts/desinventar-{-$jsversion-}.js"></script>
		{-else-}
			{-include file="js.tpl"-}
		{-/if-}

		{-include file="maps_include.tpl"-}
		{-if $appOptions.UseRemoteMaps > 0-}
			<script type="text/javascript" src="http://api.maps.yahoo.com/ajaxymap?v=3.0&amp;appid=euzuro-openlayers"></script>
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		{-/if-}
		<link rel="stylesheet" type="text/css" href="{-$desinventarURL-}/external/checktree/checktree.css"/>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				onReadyExtJS();
				onReadyInit();
				onReadyMain();
			});
		</script>
		{-if $appOptions.IsOnline > 0-}
			{-include file="ga.tpl"-}
		{-/if-}		
	</head>
	<body>
		<div id="loading-mask"></div>
		<div id="loading">
			<div class="loading-indicator">Loading...</div>
		</div>
		<div id="divViewport">
			<!-- Top Menu Area - Toolbar -->
			<div id="north">
				<div id="toolbar"></div>
			</div>
			<!-- Query Design -->
			<div id="divWestPanel">
				{-include file="block_querydesign.tpl"-}
			</div>
			
			<!-- Central Content Area -->
			<div id="container" style="heigth:100%;">
				{-include file="database_delete_ext.tpl"-}
				{-include file="block_content.tpl"-}
			</div>

			<!-- Help Section -->
			<div id="south">
				{-include file="block_help.tpl"-}
			</div>
		</div>
		
		<!-- General App Information -->
		{-include file="desinventarinfo.tpl"-}
		{-include file="desinventarmenu.tpl"-}
		{-if $appOptions.IsOnline > 0-}
			{-include file="statcounter.tpl"-}
		{-/if-}		
	</body>
</html>
