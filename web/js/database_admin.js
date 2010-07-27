function onReadyDatabaseAdmin() {
	// Table Stripes...
	jQuery('#tblDatabaseList tr:odd').removeClass('normal').addClass('normal');
	jQuery('#tblDatabaseList tr:even').removeClass('normal').addClass('under');
	
	jQuery('#tblDatabaseList #RegionId').hide();
	jQuery('#tblDatabaseList #LangIsoCode').hide();

	// Highlight row on mouseOver
	jQuery('#tblDatabaseList tr:not(:first)').unbind('hover').hover(
		function() {
			jQuery(this).addClass('highlight');
		},
		function() {
			jQuery(this).removeClass('highlight');
		}
	).unbind('click').click(function() {
		uploadMsg(''); 
		jQuery('#frmDatabaseEdit :input').unhighlight();
		jQuery('#frmDatabaseEdit #cmd').val('cmdRegionUpdate');
		setRegionPA(jQuery(this).find('#RegionId').html(),
		            jQuery(this).find('#CountryIso').html(),
		            jQuery(this).find('#RegionLabel').html(),
		            jQuery(this).find('#LangIsoCode').html(),
		            jQuery(this).find('#RegionUserAdmin').html(),
		            jQuery(this).find('#RegionActive input').attr('checked'),
		            jQuery(this).find('#RegionPublic input').attr('checked')
		);
	});

	
	jQuery('#frmDatabaseEdit').unbind('submit').submit(function() {
		// Validate Fields
		var a=new Array('CountryIso','RegionLabel','LangIsoCode','RegionUserAdmin');
		var bContinue = checkForm('frmDatabaseEdit',a, '{-#errmsgfrm#-}');
		var s = jQuery(this).find('#RegionStatus');
		s.val(0);
		if (jQuery(this).find('#RegionActive').attr('checked')) {
			s.val(parseInt(s.val()) | 1);
		}
		if (jQuery(this).find('#RegionPublic').attr('checked')) {
			s.val(parseInt(s.val()) | 2);
		}
		var params = jQuery(this).serializeObject();
		if (bContinue) {
			jQuery('#frmDatabaseEdit :input').unhighlight();
			jQuery.post('index.php',
				{cmd        : 'cmdRegionUpdate',
				 RegionInfo : params
				},
				function(data) {
					if (parseInt(data.Status) > 0) {
						// (jhcaiced) Change this for a method to update only the 
						// affected row intead of loading all list again
						updateList('dbl', 'region.php', 'cmd=adminreg');
					}
				},
				'json'
			);
		}
		return false;
	});
}

function setRegionPA(prmRegionId, prmCountryIso, prmRegionLabel, 
					 prmLangIsoCode, prmUserId_AdminRegion, 
					 prmRegionActive, prmRegionPublic) {
	mod = "regionpa";
	$(mod + 'addsect').style.display = 'block';
	jQuery('#frmDatabaseEdit #RegionId').val(prmRegionId);
	jQuery('#frmDatabaseEdit #CountryIso').val(prmCountryIso);
	jQuery('#frmDatabaseEdit #RegionLabel').val(prmRegionLabel);
	jQuery('#frmDatabaseEdit #LangIsoCode').val(prmLangIsoCode);
	jQuery('#frmDatabaseEdit #RegionUserAdmin').val(prmUserId_AdminRegion);
	jQuery('#frmDatabaseEdit #RegionActive').attr('checked', prmRegionActive);
	jQuery('#frmDatabaseEdit #RegionPublic').attr('checked', prmRegionPublic);
}
