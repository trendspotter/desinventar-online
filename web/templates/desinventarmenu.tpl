<div id="divMainMenu" style="display:none;">
	<span id="mnuMenuQuery">{-#msearch#-}</span>
		<span id="mnuQueryToggle">{-#mgotoqd#-}</span>
		<span id="mnuQueryNew">{-#mnewsearch#-}</span>
		<span id="mnuQuerySave">{-#msavequery#-}</span>
		<span id="mnuQueryOpen">{-#mopenquery#-}</span>
	<span id="mnuMenuUser">{-#mnuMenuUser#-}</span>
		<span id="mnuUserLogin">{-#mnuUserLogin#-}</span>
		<span id="mnuUserChangeLogin">{-#mnuUserChangeLogin#-}</span>
		<span id="mnuUserEditAccount">{-#mnuUserEditAccount#-}</span>
		<span id="mnuUserLogout">{-#mnuUserLogout#-}</span>
		<span id="mnuMenuUserLanguage">{-#mnuMenuUserLanguage#-}</span>
			{-foreach name=LanguageList key=key item=item from=$LanguageList-}
			<span id="mnuUserLanguage-{-$key-}">{-$item-}</span>
			{-/foreach-}
		<span id="mnuUserQuit">{-#mnuUserQuit#-}</span>
	<span id="mnuMenuDatacards">{-#mdcsection#-}</span>
		<span id="mnuDatacardView">{-#mnuDatacardView#-}</span>
		<span id="mnuDatacardInsertEdit">{-#mnuDatacardInsertEdit#-}</span>
		<span id="mnuDatacardImport">{-#mnuDatacardImport#-}</span>
		<span id="mnuDatabaseExport">{-#mnuDatabaseExport#-}</span>
		<span id="mnuDatabaseImport">{-#mnuDatabaseImport#-}</span>
		<span id="mnuDatabaseConfig">{-#mnuDatabaseConfig#-}</span>
	<span id="mnuMenuDatabase">{-#mdatabases#-}</span>
		<span id="mnuDatabaseFind">{-#mdbfind#-}</span>
		<span id="mnuAdminUsers">{-#mnuUserAdmin#-}</span>
		<span id="mnuAdminDatabases">{-#mnuAdminDatabase#-}</span>
	<span id="mnuMenuHelp">{-#mhelp#-}</span>
		<span id="mnuHelpWebsite">{-#mwebsite#-}</span>
		<span id="mnuHelpMethodology">{-#hmoreinfo#-}</span>
		<span id="mnuHelpDocumentation">{-#hotherdoc#-}</span>
		<span id="mnuRegionInfo">{-#hdbinfo#-}</span>
		<span id="mnuHelpAbout">{-#mabout#-}</span>
</div>