{-config_load file=`$lg`.conf section="di8_DBBackup"-}
<div class="contentBlock" id="divDatabaseBackup">
	<h2>{-#msgDBBackupTitle#-}</h2>
	<table>
	<tr>
		<td rowspan="5" valign="top">
			<img src="images/db_backup.png" />
		</td>
		<td>
			<b><span id="txtDBBackupRegionLabel"></span></b><br />
		</td>
	</tr>
	<tr>
		<td>
			<div id="divDBBackupResults" style="display:none;" class="DBBackup">
				<p>{-#msgDBBackupComplete#-}</p>
				<a id="linkDBBackupDownload" href="#"><img src="images/save-as-icon.png"></a><br />
				<br />
				<hr size="2" noshade />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div id="divDBBackupParameters" class="DBBackup">
				<p>{-#msgDBBackupParameters#-}</p>
				<input id="btnDBBackupDoBackup" type="button" class="line" value="{-#msgDBBackupButton#-}" />
			</div>
			<br />
		</td>
	</tr>
	<tr>
		<td>
			<div id="divDBBackupProgress" style="display:none;" class="DBBackup">
				{-#msgDBBackupWaiting#-} &nbsp;&nbsp; <img src="loading.gif" />
			</div>
			<br />
		</td>
	</tr>
	<tr>
		<td>
			<div id="divDBBackupErrors" style="display:none;" class="DBBackup">
				{-#msgDBBackupError#-}<br />
			</div>
		</td>
	</tr>
	</table>
</div>
