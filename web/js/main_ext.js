/*
 DesInventar - http://www.desinventar.org
 (c) 1998-2011 Corporacion OSSO
 - General ExtJS functions
*/
function onReadyExtJS()
{
	Ext.BLANK_IMAGE_URL = '/extJS/resources/images/default/s.gif';
	Ext.ns('DesInventar');

	// Hide Loading div...
	jQuery('#loading').hide();
	jQuery('#loading-mask').hide();	

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
	doDialogsCreate();
	doMainMenuCreate();
	jQuery('body').trigger('cmdMainMenuUpdate');
	doViewportCreate();
	doViewportShow();
} //onReadyExtJS()

function doViewportCreate()
{
	DesInventar.viewport = function(config) {
		var base_config = {
			id:'viewport',
			contentEl: 'divViewport',
			layout:'border',
			border: false,
			items:[
				{
					region:'north',
					height: 30,
					border: false,
					contentEl: 'north',
					collapsible: false
				},
				new Ext.Panel({
					region: 'west',
					id: 'westm',
					border: false,
					split: false,
					layout: 'fit',
					width: 350,
					title: jQuery('#msgQueryDesignTitle').text(),
					autoScroll: true,
					margins:'0 2 0 0',
					collapsible: true,
					contentEl: 'divWestPanel'
				}),
				{
					region: 'south',
					id: 'southm',
					split: false,
					title: jQuery('#msgHelpTitle').text(),
					height: 80,
					minSize: 100,
					maxSize: 200,
					margins: '0 0 0 0',
					contentEl: 'south',
					collapsible: true
				},
				new Ext.Panel({
					region: 'center',
					id: 'centerm',
					contentEl: 'container',
					autoScroll: true
				})
			]
		};
		Ext.apply(base_config,config);
		DesInventar.viewport.superclass.constructor.call(this, base_config);
	}
	Ext.extend(DesInventar.viewport, Ext.Viewport, {});
	var viewport = new DesInventar.viewport();
	if (jQuery('#desinventarRegionId').val() == '')
	{
		Ext.getCmp('westm').hide();
		viewport.doLayout();
	}
	viewport.show();
	Ext.getCmp('westm').on('collapse', function() {
		console.log('westm.collapse');
	});
	Ext.getCmp('westm').on('expand', function() {
		console.log('westm.expand');
		jQuery('.contentBlock').hide();
		jQuery('#divQueryResults').show();
		jQuery('body').trigger('cmdQueryResultsButtonHide');
		jQuery('#dcr').hide();
	});
} // doViewportCreate()

function doViewportShow()
{
	var UserRoleValue = parseInt(jQuery('#desinventarUserRoleValue').val());
	var RegionId = jQuery('#desinventarRegionId').val();
	jQuery('.contentBlock').hide();
	if (RegionId != '')
	{
		Ext.getCmp('westm').collapse();
		jQuery('#westm-xcollapsed').hide();
		if (UserRoleValue > 0)
		{
			jQuery('#westm-xcollapsed').show();
			Ext.getCmp('westm').expand();
			jQuery('#divQueryResults').show();
			jQuery('body').trigger('cmdQueryResultsButtonHide');
			jQuery('#dcr').hide();
			Ext.getCmp('viewport').doLayout();
		}
		else
		{
			jQuery('#divDatabasePrivate').show();
		}
	}
	else
	{
		jQuery('#divRegionList').show();
		doUpdateDatabaseListByUser();
	}
} //doViewportShow()

function doMainChangeLanguage(LangIsoCode)
{
	jQuery.post(
		jQuery('#desinventarURL').val() + '/',
		{
			cmd : 'cmdUserLanguageChange',
			LangIsoCode : LangIsoCode
		},
		function(data)
		{
			if (parseInt(data.Status) > 0)
			{
				jQuery('body').trigger('cmdWindowReload');
			}
			else
			{
				console.error('cmdUserLanguageChange error : ' + data.Status + ' ' + item.langisocode);
			}
		},
		'json'
	);
} //doMainChangeLanguage()

function doMainMenuHandler(item)
{
	var RegionId = jQuery('#desinventarRegionId').val();
	switch (item.id)
	{
		case 'mnuUserLogin':
		case 'mnuUserChangeLogin':
			jQuery('body').trigger('cmdUserLoginShow');
		break;
		case 'mnuUserLogout':
			jQuery('body').trigger('cmdUserLogout');
		break;
		case 'mnuUserChangePasswd':
			jQuery('#dbl').load(jQuery('#desinventarURL').val() + '/user.php?cmd=changepasswd',function() { onReadyUserChangePasswd('dbl-win'); });
			Ext.getCmp('wndDatabaseList').show();
		break;
		case 'mnuUserLanguageEnglish':
			doMainChangeLanguage('eng');
		break;
		case 'mnuUserLanguageSpanish':
			doMainChangeLanguage('spa');
		break;
		case 'mnuUserLanguagePortuguese':
			doMainChangeLanguage('por');
		break;
		case 'mnuUserLanguageFrench':
			doMainChangeLanguage('fre');
		break;
		// DesConsultar Menu Options
		case 'mnuQueryViewDesign':
			if (jQuery('#desinventarRegionId').val() != '')
			{
				jQuery('.contentBlock').hide();
				jQuery('#divQueryResults').show();
				Ext.getCmp('westm').expand();
			}
		break;
		case 'mnuQueryViewData':
			jQuery('body').trigger('cmdViewDataParams');
		break;
		case 'mnuQueryViewMap':
			jQuery('body').trigger('cmdViewMapParams');
		break;
		case 'mnuQueryViewGraph':
			jQuery('body').trigger('cmdViewGraphParams');
		break;
		case 'mnuQueryViewStd':
			jQuery('body').trigger('cmdViewStdParams');
		break;
		case 'mnuQueryOptionNew':
			// Just reload the current region window...(need a better solution!!)
			window.location = jQuery('#desinventarURL').val() + '/' + RegionId;
		break;
		case 'mnuQueryOptionSave':
			saveQuery();
		break;
		case 'mnuQueryOptionOpen':
			Ext.getCmp('wndQueryOpen').show();
		break;
		case 'mnuQueryResultSave':
			jQuery('#btnResultSave').trigger('click');
		break;
		case 'mnuQueryResultSaveXLS':
			jQuery('#btnResultSaveXLS').trigger('click');
		break;
		case 'mnuQueryResultSaveCSV':
			jQuery('#btnResultSaveCSV').trigger('click');
		break;
		case 'mnuQueryResultPrint':
			jQuery('#btnResultPrint').trigger('click');
		break;
		case 'mnuQueryRegionInfo':
			jQuery('.contentBlock').hide();
			jQuery('#divQueryResults').show();
			jQuery('#dcr').hide();
			jQuery('#divRegionInfo').show();
			doGetRegionInfo(jQuery('#desinventarRegionId').val());
			Ext.getCmp('westm').collapse();
		break;
		case 'mnuQuerySelectDatabase':
		case 'mnuQuerySelectAnotherDatabase':
			// Show database list
			hideQueryDesign();
			jQuery('.contentBlock').hide();
			doUpdateDatabaseListByUser();
		break;
		// Datacards Menu Items
		case 'mnuDatacardView':
		case 'mnuDatacardEdit':
			jQuery('#cardsRecordNumber').val(0);
			jQuery('#cardsRecordSource').val('');
			jQuery.post(
				jQuery('#desinventarURL').val() + '/',
				{
					cmd      : 'cmdDatabaseLoadData',
					RegionId : jQuery('#desinventarRegionId').val()
				},
				function(data)
				{
					jQuery('body').data('GeolevelsList', data.GeolevelsList);
					jQuery('body').data('EventList', data.EventList);
					jQuery('body').data('CauseList', data.CauseList);
					jQuery('body').data('RecordCount', data.RecordCount);
					var dataItems = jQuery('body').data();
					jQuery.each(dataItems, function(index, value) {
						if (index.substr(0,13) === 'GeographyList')
						{
							jQuery('body').removeData(index);
						}
					});
					jQuery('body').data('GeographyList', data.GeographyList);
					jQuery('body').trigger('cmdDatacardShow');
				},
				'json'
			);
		break;
		case 'mnuDatacardImport':
			hideQueryDesign();
			jQuery('.contentBlock').hide();
			jQuery('#divDatacardsImport').show();
			updateList('divDatacardsImport', jQuery('#desinventarURL').val() + '/import.php', 'r=' + RegionId);
		break;
		case 'mnuDatabaseDownload':
			jQuery('.clsAdminDatabaseExport').hide();
			Ext.getCmp('wndDatabaseExport').show();
			doAdminDatabaseExportAction();
		break;
		case 'mnuDatabaseCopy':
			doDatabaseUploadShow('Copy');
		break;
		case 'mnuDatabaseReplace':
			doDatabaseUploadShow('Replace');
		break;
		case 'mnuDatabaseConfig':
			hideQueryDesign();
			jQuery('.contentBlock').hide();
			jQuery('.classDBConfig_tabs:first').click();
			jQuery('#divDatabaseConfiguration').show();
			jQuery('#tabDatabaseConfiguration').show();
		break;
		case 'mnuDatabaseCreate':
			doDatabaseCreateShow();
		break;
		case 'mnuUserAccountManagement':
			jQuery('#dbl').load(jQuery('#desinventarURL').val() + '/user.php?cmd=adminusr',function() { onReadyUserAdmin(); });
			Ext.getCmp('wndDatabaseList').show();
		break;
		case 'mnuAdminDatabases':
			jQuery('.contentBlock').hide();
			jQuery('#divAdminDatabase').show();
			doAdminDatabaseUpdateList();
		break;
		case 'mnuHelpAbout':
			Ext.getCmp('wndDialog').show();
		break;
		case 'mnuHelpWebsite':
			window.open('http://www.desinventar.org', '', '');
		break;
		case 'mnuHelpMethodology':
			var url = 'http://www.desinventar.org';
			if (jQuery('#desinventarLang').val() == 'spa')
			{
				url = url + '/es/metodologia';
			}
			else
			{
				url = url + '/en/methodology';
			}
			window.open(url, '', '');
		break;
		case 'mnuHelpDocumentation':
			var url = 'http://www.desinventar.org/';
			window.open(url, '', '');
		break;
	} //switch
} //doMainMenuHandler()

function hideQueryDesign()
{
	// Hide Query Design Panel
	Ext.getCmp('westm').collapse();
} //hideQueryDesign()

function doMainMenuCreate()
{
	// Main menu
	var mnuUserLanguage = new Ext.menu.Menu({
		id: 'mnuUserLanguage',
		items: [
			{id:'mnuUserLanguageEnglish'   , text: jQuery('span#mnuUserLanguageEnglish').text()   , handler: doMainMenuHandler },
			{id:'mnuUserLanguageSpanish'   , text: jQuery('span#mnuUserLanguageSpanish').text()   , handler: doMainMenuHandler },
			{id:'mnuUserLanguagePortuguese', text: jQuery('span#mnuUserLanguagePortuguese').text(), handler: doMainMenuHandler },
			{id:'mnuUserLanguageFrench'    , text: jQuery('span#mnuUserLanguageFrench').text()    , handler: doMainMenuHandler }
		]
	});
	
	var mnuUser = new Ext.menu.Menu({
		id: 'mnuUser',
		items: [
			{id: 'mnuUserLogin'            , text: jQuery('span#mnuUserLogin').text()            , handler: doMainMenuHandler }, 
			{id: 'mnuUserChangeLogin'      , text: jQuery('span#mnuUserChangeLogin').text()      , handler: doMainMenuHandler },
			{id: 'mnuUserChangePasswd'     , text: jQuery('span#mnuUserChangePasswd').text()     , handler: doMainMenuHandler },
			{id: 'mnuUserAccountManagement', text: jQuery('span#mnuUserAccountManagement').text(), handler: doMainMenuHandler },
			{id: 'mnuUserLanguage'         , text: jQuery('span#mnuUserLanguage').text()         , menu: mnuUserLanguage      },
			{id: 'mnuUserLogout'           , text: jQuery('span#mnuUserLogout').text()           , handler: doMainMenuHandler }
		]
	});

	var mnuQueryOption = new Ext.menu.Menu({
		id: 'mnuQueryOption', items: [
			{id:'mnuQueryOptionNew'  , text: jQuery('span#mnuQueryOptionNew').text() , handler: doMainMenuHandler },
			{id:'mnuQueryOptionSave' , text: jQuery('span#mnuQueryOptionSave').text(), handler: doMainMenuHandler },
			{id:'mnuQueryOptionOpen' , text: jQuery('span#mnuQueryOptionOpen').text(), handler: doMainMenuHandler }
		]
	});

	var mnuQuery = new Ext.menu.Menu({
		id: 'mnuQuery', items: [
			{id:'mnuQueryViewDesign'           , text: jQuery('span#mnuQueryViewDesign').text()           , handler: doMainMenuHandler },
			{id:'mnuQueryViewData'             , text: jQuery('span#mnuQueryViewData').text()             , handler: doMainMenuHandler },
			{id:'mnuQueryViewMap'              , text: jQuery('span#mnuQueryViewMap').text()              , handler: doMainMenuHandler },
			{id:'mnuQueryViewGraph'            , text: jQuery('span#mnuQueryViewGraph').text()            , handler: doMainMenuHandler },
			{id:'mnuQueryViewStd'              , text: jQuery('span#mnuQueryViewStd').text()              , handler: doMainMenuHandler },
			{id:'mnuQueryOption'               , text: jQuery('span#mnuQueryOption').text()               , menu: mnuQueryOption },
			{id:'mnuQueryResultSave'           , text: jQuery('span#mnuQueryResultSave').text()           , handler: doMainMenuHandler },
			{id:'mnuQueryResultSaveXLS'        , text: jQuery('span#mnuQueryResultSaveXLS').text()        , handler: doMainMenuHandler },
			{id:'mnuQueryResultSaveCSV'        , text: jQuery('span#mnuQueryResultSaveCSV').text()        , handler: doMainMenuHandler },
			{id:'mnuQueryResultPrint'          , text: jQuery('span#mnuQueryResultPrint').text()          , handler: doMainMenuHandler },
			{id:'mnuQueryRegionInfo'           , text: jQuery('span#mnuQueryRegionInfo').text()           , handler: doMainMenuHandler },
			{id:'mnuQuerySelectDatabase'       , text: jQuery('span#mnuQuerySelectDatabase').text()       , handler: doMainMenuHandler },
			{id:'mnuQuerySelectAnotherDatabase', text: jQuery('span#mnuQuerySelectAnotherDatabase').text(), handler: doMainMenuHandler }
		]
	});

	var mnuDatacard = new Ext.menu.Menu({
		id: 'mnuDatacard', items: [
			{id:'mnuDatacardView', text: jQuery('span#mnuDatacardView').text(), handler: doMainMenuHandler },
			{id:'mnuDatacardEdit', text: jQuery('span#mnuDatacardEdit').text(), handler: doMainMenuHandler }
		]
	});

	var mnuDatabaseUpload = new Ext.menu.Menu({
		id: 'mnuDatabaseUpload', items: [
			{id:'mnuDatabaseCopy'   , text: jQuery('span#mnuDatabaseCopy').text()   , handler: doMainMenuHandler },
			{id:'mnuDatabaseReplace', text: jQuery('span#mnuDatabaseReplace').text(), handler: doMainMenuHandler }
		]
	});
	
	var mnuDatabase = new Ext.menu.Menu({
		id: 'mnuDatabase',
		items: [
			{id:'mnuDatabaseDownload', text: jQuery('span#mnuDatabaseDownload').text(), handler: doMainMenuHandler },
			{id:'mnuDatabaseUpload'  , text: jQuery('span#mnuDatabaseUpload').text()  , menu: mnuDatabaseUpload    },
			{id:'mnuDatabaseCreate'  , text: jQuery('span#mnuDatabaseCreate').text()  , handler: doMainMenuHandler },
			{id:'mnuDatabaseConfig'  , text: jQuery('span#mnuDatabaseConfig').text()  , handler: doMainMenuHandler }
		]
	});

	var mnuHelp = new Ext.menu.Menu({
		id   : 'mnuHelp',
		style: { overflow: 'visible' },
		items: [
			{id:'mnuHelpWebsite'       , text: jQuery('span#mnuHelpWebsite').text()       , handler: doMainMenuHandler },
			{id:'mnuHelpMethodology'   , text: jQuery('span#mnuHelpMethodology').text()   , handler: doMainMenuHandler },
			{id:'mnuHelpDocumentation' , text: jQuery('span#mnuHelpDocumentation').text() , handler: doMainMenuHandler },
			{id:'mnuHelpAbout'         , text: jQuery('span#mnuHelpAbout').text()         , handler: doMainMenuHandler }
		]
	});
	
	var tb = new Ext.Toolbar({renderTo: 'toolbar', items : [] });
	tb.add({ id:'mnuUser'            , text: jQuery('span#mnuUser').text()    , menu: mnuUser     });
	tb.add({ id:'mnuQuery'           , text: jQuery('span#mnuQuery').text()   , menu: mnuQuery    });
	tb.add({ id:'mnuDatacard'        , text: jQuery('span#mnuDatacard').text(), menu: mnuDatacard });
	tb.add({ id:'mnuDatabase'        , text: jQuery('span#mnuDatabase').text(), menu: mnuDatabase });
	tb.add({ id:'mnuHelp'            , text: jQuery('span#mnuHelp').text()    , menu: mnuHelp     });
	tb.add('->',{id: 'mnuWaiting'    , text: '<img src="' + jQuery('#desinventarURL').val() + '/images/loading.gif" alt="" />', hidden: true });
	tb.add('->',{id: 'mnuRegionLabel'     , text: '' });
	tb.add('->',{id: 'mnuHelpWebsiteLabel', text: '<img src="' + jQuery('#desinventarURL').val() + '/images/di_logo4.png" alt="" />' });

	// Attach main events to body
	jQuery('body').on('cmdMainWaitingShow', function() {
		Ext.getCmp('mnuWaiting').show();
	});
	jQuery('body').on('cmdMainWaitingHide', function() {
		Ext.getCmp('mnuWaiting').hide();
	});

	jQuery('body').on('cmdMainMenuUpdate', function() {
		doMainMenuUpdate();
	});
	jQuery('body').on('cmdMainMenuResultButtonsEnable', function() {
		if (jQuery('#DCRes').val() == 'D' || jQuery('#DCRes').val() == 'S')
		{
			Ext.getCmp('mnuQueryResultSave').hide();
			Ext.getCmp('mnuQueryResultSaveXLS').show();
			Ext.getCmp('mnuQueryResultSaveXLS').enable();
			Ext.getCmp('mnuQueryResultSaveCSV').show();
			Ext.getCmp('mnuQueryResultSaveCSV').enable();
		}
		else
		{
			Ext.getCmp('mnuQueryResultSave').show();
			Ext.getCmp('mnuQueryResultSave').enable();
			Ext.getCmp('mnuQueryResultSaveXLS').hide();
			Ext.getCmp('mnuQueryResultSaveCSV').hide();
		}
		Ext.getCmp('mnuQueryResultPrint').show();
		Ext.getCmp('mnuQueryResultPrint').enable();
	});
	jQuery('body').on('cmdMainMenuResultButtonsDisable', function() {
		Ext.getCmp('mnuQueryResultSave').hide();
		Ext.getCmp('mnuQueryResultSaveXLS').hide();
		Ext.getCmp('mnuQueryResultSaveCSV').hide();
		Ext.getCmp('mnuQueryResultPrint').hide();
	});
	jQuery('body').on('cmdMainWindowUpdate', function() {
		if (jQuery('#desinventarRegionId').val() != '')
		{
			Ext.getCmp('westm').collapse();
			jQuery('#westm-xcollapsed').hide();
		}
		jQuery('.contentBlock').hide();
		jQuery('#divLoading').show();
		setTimeout(function()
		{
			if (jQuery('#desinventarRegionId').val() != '')
			{
				jQuery('#westm-xcollapsed').show();
				Ext.getCmp('westm').expand();
			}
			jQuery('body').trigger('cmdMainMenuUpdate');
			if (jQuery('#desinventarRegionId').val() != '')
			{
				jQuery('body').trigger('cmdMainQueryUpdate');
			}
			jQuery('.contentBlock').hide();
			jQuery('#divLoading').hide();
			doViewportShow();
		}, 2000);
	});
} //doCreateMainMenu()

function doMainMenuUpdate()
{
	jQuery('#divMainMenu span.item').each(function() {
		var w = Ext.getCmp(jQuery(this).attr('id'));
		if (w != undefined)
		{
			w.disable();
		}
	});

	// Menu items that are always enabled
	jQuery('#divMainMenu span.clsMenuAlwaysOn').each(function() {
		Ext.getCmp(jQuery(this).attr('id')).enable();
	});
	Ext.getCmp('mnuUser').setText(jQuery('span#mnuUser').text());
	
	// Enable menu items when a User is logged in
	if (jQuery('#desinventarUserId').val() == '')
	{
		jQuery('#divMainMenu span.clsMenuWithoutUser').each(function() {
			Ext.getCmp(jQuery(this).attr('id')).enable();
		});
		Ext.getCmp('mnuUserLogin').show();
		Ext.getCmp('mnuUserChangeLogin').hide();
	}
	else
	{
		jQuery('#divMainMenu span.clsMenuWithUser').each(function() {
			Ext.getCmp(jQuery(this).attr('id')).enable();
		});
		Ext.getCmp('mnuUserLogin').hide();
		Ext.getCmp('mnuUserChangeLogin').show();
		Ext.getCmp('mnuUser').setText(jQuery('span#mnuUser').text() + ' : ' + jQuery('#desinventarUserId').val());
	}

	// Configure which options are visible using RoleValue
	var UserRoleValue = parseInt(jQuery('#desinventarUserRoleValue').val());

	Ext.getCmp('mnuUserAccountManagement').hide();
	if (UserRoleValue >= 5)
	{
		Ext.getCmp('mnuUserAccountManagement').show();
		Ext.getCmp('mnuUserAccountManagement').enable();
	}

	Ext.getCmp('mnuDatabaseReplace').hide();
	Ext.getCmp('mnuDatabaseConfig').hide();

	Ext.getCmp('mnuDatacardView').show();
	Ext.getCmp('mnuDatacardEdit').hide();
	
	// Show some menu items when a Region is Selected
	if (jQuery('#desinventarRegionId').val() == '')
	{
		Ext.getCmp('mnuQuerySelectDatabase').show();
		Ext.getCmp('mnuQuerySelectAnotherDatabase').hide();
	}
	else
	{
		Ext.getCmp('mnuQuerySelectDatabase').hide();
		Ext.getCmp('mnuQuerySelectAnotherDatabase').show();
		Ext.getCmp('mnuRegionLabel').setText('[' + jQuery('#desinventarRegionLabel').val() + ']');

		if (UserRoleValue > 0)
		{
			jQuery('#divMainMenu span.clsMenuWithRegion').each(function() {
				Ext.getCmp(jQuery(this).attr('id')).enable();
			});
			Ext.getCmp('mnuDatacardView').show();
			Ext.getCmp('mnuDatacardView').enable();
			Ext.getCmp('mnuDatacardEdit').hide();
		}
		if (UserRoleValue >= 2) 
		{
			// Edit datacards instead of only view them
			Ext.getCmp('mnuDatacardView').hide();
			Ext.getCmp('mnuDatacardEdit').show();
			Ext.getCmp('mnuDatacardEdit').enable();
			// Enable other functions
			Ext.getCmp('mnuDatabaseDownload').enable();

			if (UserRoleValue >= 4)
			{
				Ext.getCmp('mnuDatabaseReplace').show();
				Ext.getCmp('mnuDatabaseReplace').enable();
				Ext.getCmp('mnuDatabaseConfig').show();
				Ext.getCmp('mnuDatabaseConfig').enable();
			}
		}		
	}
	jQuery('body').trigger('cmdMainMenuResultButtonsDisable');
} //doMainMenuUpdate()

function doDialogsCreate()
{
	var w;
	// Query Open Window
	w = new Ext.Window({id:'wndQueryOpen',
		el:'qry-win', layout:'fit', width:300, height:200,
		closeAction:'hide', plain: true, animCollapse: false, constrainHeader: true,
		items: new Ext.Panel({contentEl: 'qry-cfg', autoScroll: true }),
		buttons:
		[
			{
				text: jQuery('#msgQueryOpenButtonClose').text(),
				handler: function()
				{
					Ext.getCmp('wndQueryOpen').hide();
				}
			}
		]
	});

	// Database List - Database Search Window
	w = new Ext.Window({id:'wndDatabaseList',
		el:'dbl-win', layout:'fit', x:200, y:100, width:600, height:450, 
		closeAction:'hide', plain: true, animCollapse: false, constrainHeader: true,
		items: new Ext.Panel({ contentEl: 'dbl', autoScroll: true })
	});
	w = new Ext.Window({id:'wndDialog',
		el:'dlg-win', layout:'fit', x:350, y:200, width:300, height:150, 
		closeAction:'hide', plain: true, animCollapse: false, constrainHeader: true,
		items: new Ext.Panel({ contentEl: 'dlg', autoScroll: true })
	});
	// Datacard View/Edit Window
	w = new Ext.Window({id:'wndDatacard',
		el:'divDatacardWindow', layout:'fit', 
		width:960, height:638, //x: 65, y: 0, 
		closeAction:'hide', plain: true, animCollapse: false, constrainHeader: true,
		items: new Ext.Panel({ contentEl: 'divDatacardContent', autoScroll: true })
	});
	w.on('hide',function() {
		jQuery('#divDatacardWindow').hide();
		showtip('');					
	});

	w = new Ext.Window({id:'wndViewDataParams', 
		el:'divViewDataParamsWindow', layout:'fit',
		width:600, height:420, 
		closeAction:'hide', plain: true, animCollapse: false, constrainHeader: true,
		items: new Ext.Panel({contentEl: 'divViewDataParamsContent', autoScroll: true }),
		buttons: [
			{
				text: jQuery('#msgViewDataButtonClear').text(),
				handler: function()
				{
					$('CD').reset();
				} //handler
			},
			{
				text: jQuery('#msgViewDataButtonSend').text(),
				handler: function()
				{
					if (sendList("result"))
					{
						$('DCRes').value = "D";
						jQuery('body').trigger('cmdQueryResultsButtonShow');
						Ext.getCmp('wndViewDataParams').hide();
					}
					else
					{
						console.debug('Error while executing function ViewData');
					}
				} //handler
			},
			{
				text: jQuery('#msgViewDataButtonClose').text(),
				handler: function()
				{
					Ext.getCmp('wndViewDataParams').hide();
				} //handler
			}
		] //button
	});

	w = new Ext.Window({id:'wndViewMapParams',
		el:'map-win',  layout:'fit',  width:650, height:420, 
		closeAction:'hide', plain: true, animCollapse: false, constrainHeader: true,
		items: new Ext.Panel({contentEl: 'map-cfg', autoScroll: true }),
		buttons: [
			{
				text: jQuery('#msgViewMapButtonClear').text(),
				handler: function()
				{
					$('CM').reset();
				}
			},
			{
				text: jQuery('#msgViewMapButtonSend').text(),
				handler: function()
				{
					if (sendMap("result"))
					{
						$('DCRes').value = "M";
						Ext.getCmp('wndViewMapParams').hide();
						jQuery('body').trigger('cmdQueryResultsButtonShow');
					}
					else
					{
						console.debug('Error while executing function ViewMap');
					}
				}
			},
			{
				text: jQuery('#msgViewMapButtonClose').text(),
				handler: function()
				{
					Ext.getCmp('wndViewMapParams').hide();
				}
			}
		]
	});

	w = new Ext.Window({id:'wndViewGraphParams',
		el:'divGraphParameters',  layout:'fit',  width:750, height:420, 
		closeAction:'hide', plain: true, animCollapse: false, constrainHeader: true,
		items: new Ext.Panel({contentEl: 'grp-cfg', autoScroll: true }),
		buttons: [
			{
				text: jQuery('#msgViewGraphButtonClear').text(),
				handler: function()
				{
					$('CG').reset();
					jQuery('#prmGraphTypeHistogram').change();
				}
			},
			{
				text: jQuery('#msgViewGraphButtonSend').text(),
				handler: function()
				{
					sendGraphic('result');
					$('DCRes').value = "G";
					Ext.getCmp('wndViewGraphParams').hide();
					jQuery('body').trigger('cmdQueryResultsButtonShow');
				}
			},
			{
				text: jQuery('#msgViewGraphButtonClose').text(),
				handler: function()
				{
					Ext.getCmp('wndViewGraphParams').hide();
				}
			}
		]
	});

	w = new Ext.Window({id:'wndViewStdParams',
		el:'std-win',  layout:'fit',  width:600, height:420, 
		closeAction:'hide', plain: true, animCollapse: false, constrainHeader: true,
		items: new Ext.Panel({contentEl: 'std-cfg', autoScroll: true }),
		buttons: [
			{
				text: jQuery('#msgViewStdButtonClear').text(),
				handler: function()
				{
					$('CS').reset();
				}
			},
			{
				text: jQuery('#msgViewStdButtonSend').text(),
				handler: function()
				{
					if (sendStatistic("result"))
					{
						$('DCRes').value = "S";
						Ext.getCmp('wndViewStdParams').hide();
						jQuery('body').trigger('cmdQueryResultsButtonShow');
					}
					else
					{
						console.debug('Error while executing ViewStd function');
					}
				} //handler
			},
			{
				text: jQuery('#msgViewStdButtonClose').text(),
				handler: function()
				{
					Ext.getCmp('wndViewStdParams').hide();
				}
			}
		]
	});

} //doDialogsCreate()

function doGetRegionInfo(RegionId)
{
	jQuery('#divRegionInfo #divRegionLogo').html('<img src="' + jQuery('#desinventarURL').val() + '/images/loading.gif" alt="" />');
	jQuery.post(jQuery('#desinventarURL').val() + '/',
		{
		  cmd         : 'cmdDatabaseGetInfo', 
		  RegionId    : RegionId,
		  LangIsoCode : jQuery('#desinventarLang').val()
		},
		function(data)
		{
			if (parseInt(data.Status)>0)
			{
				var i = data.RegionInfo;
				jQuery('#divRegionInfo #divRegionLogo').html('<img src="' + jQuery('#desinventarURL').val() + '/?cmd=cmdDatabaseGetLogo&RegionId=' + RegionId + '" alt="" />');
				jQuery('#divRegionInfo #txtRegionLabel').text(i.RegionLabel);
				jQuery('#divRegionInfo #txtRegionPeriod').text(i.PeriodBeginDate + ' - ' + i.PeriodEndDate);
				jQuery('#divRegionInfo #txtRegionNumberOfRecords').text(i.NumberOfRecords);
				jQuery('#divRegionInfo #txtRegionLastUpdate').text(i.RegionLastUpdate);

				jQuery('#divRegionInfo #divInfoGeneral').hide();
				if (i.InfoGeneral != '')
				{
					jQuery('#divRegionInfo #divInfoGeneral #Text').html(i.InfoGeneral);
					jQuery('#divRegionInfo #divInfoGeneral').show();
				}
				jQuery('#divRegionInfo #divInfoCredits').hide();
				if (i.InfoCredits != '')
				{
					jQuery('#divRegionInfo #divInfoCredits #Text').html(i.InfoCredits);
					jQuery('#divRegionInfo #divInfoCredits').show();
				}
				jQuery('#divRegionInfo #divInfoSources').hide();
				if (i.InfoSources != '')
				{
					jQuery('#divRegionInfo #divInfoSources #Text').html(i.InfoSources);
					jQuery('#divRegionInfo #divInfoSources').show();
				}
				jQuery('#divRegionInfo #divInfoSynopsis').hide();
				if (i.InfoSynopsis != '')
				{
					jQuery('#divRegionInfo #divInfoSynopsis #Text').html(i.InfoSynopsis);
					jQuery('#divRegionInfo #divInfoSynopsis').show();
				}
			}
		},
		'json'
	);
} //doGetRegionInfo()

function doUpdateDatabaseListByUser()
{
	jQuery(".contentBlock").hide();
	jQuery("#divRegionList").show();
	// Hide everything at start...
	jQuery('.databaseTitle').hide();
	jQuery('.databaseList').hide();

	jQuery.post(jQuery('#desinventarURL').val() + '/',
		{
			cmd: 'cmdSearchDB',
			searchDBQuery: '', 
			searchDBCountry : 0
		},
		function(data)
		{
			if (parseInt(data.Status) > 0)
			{
				if (parseInt(data.NoOfDatabases) > 0)
				{
					jQuery('#divDatabaseFindList').show();
					jQuery('#divDatabaseFindError').hide();
					RegionByRole = new Array(5);
					RegionByRole['ADMINREGION'] = new Array();
					RegionByRole['SUPERVISOR'] = new Array();
					RegionByRole['USER'] = new Array();
					RegionByRole['OBSERVER'] = new Array();
					RegionByRole['NONE'] = new Array();

					$RoleList = new Array(5);
					var iCount = 0;
					jQuery('.databaseList').empty();
					jQuery.each(data.RegionList, function(RegionId, value) {
						jQuery('#divRegionList #title_' + value.Role).show();
						jQuery('#divRegionList #list_' + value.Role).show().append('<a href="' + jQuery('#desinventarURL').val() + '/' + RegionId + '" id="' + RegionId + '" class="databaseLink">' + value.RegionLabel + '</a><br />');
						iCount++;
					});
					
					jQuery('.databaseLink').addClass("alt").unbind('click').click(function() {
						RegionId = jQuery(this).attr('id');
						if (jQuery('#desinventarPortalType').val() != '')
						{
							displayRegionInfo(RegionId);
						}
						else
						{
							window.location = jQuery('#desinventarURL').val() + '/' + RegionId;
						}
						return false;
					}); //bind
				}
				else
				{
					jQuery('#divDatabaseFindList').hide();
					jQuery('#divDatabaseFindError').show();
				}
			} //if
		},
		'json' //function
	);
} //doUpdateDatabaseListByUser()
