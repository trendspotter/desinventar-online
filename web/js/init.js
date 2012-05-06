/*
 DesInventar - http://www.desinventar.org
 (c) 1998-2012 Corporacion OSSO
*/
function onReadyInit()
{
	jQuery('body').on('cmdDatabaseLoadData', function() {
		doDatabaseLoadData();
	});

	jQuery(window).bind('hashchange', function(e) {
		var url = jQuery.param.fragment();
		var options = url.split('/');
		switch(options[0])
		{
			case '':
				//Nothing to do
				jQuery('#desinventarRegionId').val('');
				jQuery('body').trigger('cmdViewportShow');
			break;
			default:
				var RegionId = options[0];
				jQuery('#desinventarRegionId').val(RegionId);
				jQuery('body').trigger('cmdDatabaseLoadData');
			break;
		}
	});
} //onReadyInit()

function doDatabaseLoadData()
{
	console.log('doDatabaseLoadData()');
	if (jQuery('#desinventarRegionId').val() != '')
	{
		jQuery.post(
			jQuery('#desinventarURL').val() + '/',
			{
				cmd      : 'cmdDatabaseLoadData',
				RegionId : jQuery('#desinventarRegionId').val()
			},
			function(data)
			{
				// Initialize data-* components for body
				jQuery('body').data('RegionId', data.RegionId);
				jQuery('body').data('params', data.params);
				jQuery('body').data('GeolevelsList', data.GeolevelsList);
				jQuery('body').data('EventList', data.EventList);
				jQuery('body').data('CauseList', data.CauseList);
				jQuery('body').data('EEFieldList', data.EEFieldList);
				jQuery('body').data('RecordCount', data.RecordCount);

				//Compatibility with old methods
				jQuery('#desinventarUserId').val(data.params.UserId);
				jQuery('#desinventarUserFullName').val(data.params.UserFullName);
				jQuery('#desinventarUserRole').val(data.params.UserRole);
				jQuery('#desinventarUserRoleValue').val(data.params.UserRoleValue);
				
				var dataItems = jQuery('body').data();
				jQuery.each(dataItems, function(index, value) {
					if (index.substr(0,13) === 'GeographyList')
					{
						jQuery('body').removeData(index);
					}
				});
				jQuery('body').data('GeographyList', data.GeographyList);
				// Info
				jQuery('#desinventarLang').val(data.params.LangIsoCode);
				jQuery('#desinventarRegionId').val(data.params.RegionId);
				jQuery('#desinventarRegionLabel').val(data.params.RegionLabel);
				jQuery('#desinventarNumberOfRecords').val(data.RecordCount);
				
				// Trigger event on mainblock components to update them
				jQuery('.mainblock').trigger('cmdInitialize');
				// Trigger ViewportShow
				jQuery('body').trigger('cmdViewportShow');
				/*
				console.log('loadData');
				console.log(data.query_design);
				var query_design = jQuery.parseXML(data.query_design);
				jQuery(query_design).find('geography_id').each(function() {
					var geography_id = jQuery(this).text();
					jQuery('div.QueryDesign div.GeographyList li.item input:checkbox[value="' + geography_id + '"]').trigger('click');
					console.log(geography_id);
				});
				console.log('endLoadData');
				*/
			},
			'json'
		);
	}
} //doDatabaseLoadData()
