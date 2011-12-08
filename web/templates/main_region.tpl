<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>DesInventar</title>
		{-include file="jquery.tpl"-}
		{-include file="extjs.tpl"-}
		<link rel="stylesheet" type="text/css" href="{-$desinventarURL-}/css/desinventar.css?version={-$jsversion-}" />
		<link rel="stylesheet" type="text/css" href="{-$desinventarURL-}/css/datacards.css?version={-$jsversion-}" />
		<link rel="stylesheet" type="text/css" href="{-$desinventarURL-}/css/main.css?version={-$jsversion-}" />
		<script type="text/javascript" src="/fileuploader/fileuploader.js"></script>
		<script type="text/javascript" src="{-$desinventarURL-}/js/jquery.snippets.js?version={-$jsversion-}"></script>
		<script type="text/javascript" src="{-$desinventarURL-}/js/main.js?version={-$jsversion-}"></script>
		<script type="text/javascript" src="{-$desinventarURL-}/js/admin_database.js?version={-$jsversion-}"></script>
		<script type="text/javascript" src="{-$desinventarURL-}/js/admin_database_edit.js?version={-$jsversion-}"></script>
		<script type="text/javascript" src="{-$desinventarURL-}/js/admin_database_export.js?version={-$jsversion-}"></script>
		<script type="text/javascript" src="{-$desinventarURL-}/js/admin_database_upload.js?version={-$jsversion-}"></script>
		<script type="text/javascript" src="{-$desinventarURL-}/js/database_create.js?version={-$jsversion-}"></script>
		<script type="text/javascript" src="{-$desinventarURL-}/js/userperm_admin.js?version={-$jsversion-}"></script>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				onReadyAdminDatabase();
				//onReadyDatabaseCreate();
				onReadyUserPermAdmin();
				//doAdminDatabaseUpdateList();
				//doAdminDatabaseExportCreate();
				// 2011-04-29 (jhcaiced) Fix for use of ExtJS in IE9 ?
				if ((typeof Range !== "undefined") && !Range.prototype.createContextualFragment)
				{
					Range.prototype.createContextualFragment = function(html)
					{
						var frag = document.createDocumentFragment(), div = document.createElement("div");
						frag.appendChild(div);
						div.outerHTML = html;
						return frag;
					};
				}
				jQuery('#btnTest').click(function() {
					doUserPermAdminShow();
				});
				jQuery('#btnTest').trigger('click');
				// Initialize Ext.QuickTips
				Ext.QuickTips.init();
				Ext.apply(Ext.QuickTips.getQuickTip(), {maxWidth: 200, minWidth: 100, showDelay: 50, trackMouse: true});
			});
		</script>
	</head>
	<body>
		DesInventar Database Admin
		Version : {-$jsversion-}<br />
		Language : {-$lg-}<br />
		{-include file="userperm_admin_ext.tpl"-}
		{-include file="desinventarmenu.tpl"-}
		{-include file="desinventarinfo.tpl"-}
		<br />
		<a class="button" id="btnTest"><span>Test</span></a>
	</body>
</html>
