<script type="text/javascript">
		function onMenuItem(item) {
			var RegionId = jQuery('#desinventarRegionId').val();
			switch (item.id) {
				case 'mnuRegionInfo':
					jQuery('#dcr').hide();
					doGetRegionInfo(jQuery('#desinventarRegionId').val());
					jQuery('#divRegionInfo').show();
				break;
				case 'mnuUserLogin':
				case 'mnuUserChangeLogin':
					//updateUserBar(jQuery('#desinventarURL').val() + '/user.php', '', '', '');
					usrw.show();
				break;
				case 'mnuUserLogout':
					doUserLogout();
				break;
				case 'mnuUserEditAccount':
					jQuery('#dbl').load(jQuery('#desinventarURL').val() + '/user.php?cmd=changepasswd',function() { onReadyUserChangePasswd('dbl-win'); });
					dblw.show();
				break;
				{-foreach name=LanguageList key=key item=item from=$LanguageList-}
					case '{-$key-}':
						window.location = jQuery('#desinventarURL').val() + '/index.php?r={-$reg-}&lang={-$key-}';
					break;
				{-/foreach-}
				case 'mnuFileQuit':
					self.close();
				break;
				// query menu
				case 'menuQueryToggle':
					w = Ext.getCmp('westm');
					jQuery('.contentBlock').hide();
					if (RegionId == '') {
						jQuery('#divQueryResults').hide();
						w.hide();
					} else {
						jQuery('#divQueryResults').show();
						w.show();
					}
					if (w.isVisible()) {
						w.collapse(); //hide()
					} else {
						w.expand(); //show()
					}
				break;
				case 'mnuQueryNew':
					// Just reload the current region window...(need a better solution!!)
					window.location = jQuery('#desinventarURL').val() + '/index.php?r=' + RegionId;
				break;
				case 'menuQuerySave':
					saveQuery();
				break;
				case 'mnuQueryOpen':
					var qryw;
					if (!qryw) {
						qryw = new Ext.Window({
							el:'qry-win',  layout:'fit',  width:300, height:200, 
							closeAction:'hide', plain: true, animCollapse: false,
							items: new Ext.Panel({
							contentEl: 'qry-cfg', autoScroll: true }),
							buttons: [{
								text:'{-#tclose#-}',
								handler: function() {
									qryw.hide();
								}
							}]
						});
					}
					qryw.show(this);
				break;
				// Datacards Menu Items
				case 'mnuDatacardView':
				case 'mnuDatacardInsertEdit':
					jQuery('#cardsRecordNumber').val(0);
					jQuery('#cardsRecordSource').val('');
					jQuery.post(jQuery('#desinventarURL').val() + '/index.php',
						{cmd      : 'getRegionRecordCount',
						 RegionId : jQuery('#desinventarRegionId').val()
						},
						function(data) {
							jQuery('#cardsRecordNumber').val(0);
							jQuery('#cardsRecordCount').val(data.RecordCount);
							$('DICard').reset();	
							//doDatacardClear();
							jQuery('#divDatacardWindow').trigger('display');
							doDatacardNavButtonsEnable();
							difw.show();
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
				case 'mnuDatabaseExport':
					hideQueryDesign();
					jQuery('.contentBlock').hide();
					jQuery('#divDatabaseExport').trigger('DBBackupRestart');
					jQuery('#divDatabaseExport').show();
				break;
				case 'mnuDatabaseImport':
					hideQueryDesign();
					jQuery('.contentBlock').hide();
					jQuery('#divDatabaseImport').show();
				break;
				case 'mnuDatabaseConfig':
					hideQueryDesign();
					jQuery('.contentBlock').hide();
					jQuery('#divDatabaseConfiguration').show();
					jQuery('#tabDatabaseConfiguration').show();
				break;
				// databases menu
				case 'mnuDatabaseFind':
					// Show database list
					hideQueryDesign();
					jQuery('.contentBlock').hide();
					updateDatabaseListByUser();
				break;
				case 'mnuAdminUsers':
					//updateList('dbl', jQuery('#desinventarURL').val() + '/user.php', 'cmd=adminusr', 'onReadyUserAdmin');
					jQuery('#dbl').load(jQuery('#desinventarURL').val() + '/user.php?cmd=adminusr',function() { onReadyUserAdmin(); });
					dblw.show();
				break;
				case 'mnuAdminDatabases':
					jQuery('.contentBlock').hide();
					jQuery('#divAdminDatabase').show();
					doAdminDatabaseUpdateList();
				break;
				// help menu
				case 'mnuHelpAbout':
					dlgw.show();
				break;
				case 'mnuHelpWebsite':
					window.open('http://www.desinventar.org', '', '');
				break;
				case 'mnuHelpMethodology':
					var url = 'http://www.desinventar.org';
					if (jQuery('#desinventarLang').val() == 'spa') {
						url = url + '/es/metodologia';
					} else {
						url = url + '/en/methodology';
					}
					window.open(url, '', '');
				break;
				case 'mnuHelpDocumentation':
					var url = 'http://www.desinventar.org/';
					window.open(url, '', '');
				break;
			} //switch
		} //function
		
		function hideQueryDesign() {
			// Hide Query Design Panel
			w = Ext.getCmp('westm');
			if (w != undefined) {
				w.hide();
				w.collapse();
			}
		}

	var	w;
	var	s;
	var difw;
	var usrw;
	var dblw;
	var dlgw;
	// Layout, buttons and internal windows - UI DesConsultar module
	Ext.onReady(function() {
		// Initialize User Login Form
		onReadyUserLogin();
		jQuery('#loading').hide();
		jQuery('#loading-mask').hide();
		
		jQuery('body').bind('UserLoggedIn',function() {
			Ext.getCmp('viewport').destroy();
			jQuery('#loading').show();
			jQuery('#loading-mask').show();
			// When the user completes the login procedure, reload the current page...
			 window.location.reload(false);
		});

		jQuery('body').bind('UserLoggedOut',function() {
			Ext.getCmp('viewport').destroy();
			jQuery('#loading').show();
			jQuery('#loading-mask').show();
			// When the user logouts, reload the current page...
			 window.location.reload(false);
		});

		Ext.QuickTips.init();

		// User functions Window
		if (!usrw)
		{
			usrw = new Ext.Window({
				el:'usr-win', layout:'fit', x:300, y:100, width:500, height:300, 
				closeAction:'hide', plain: true, animCollapse: false,
				items: new Ext.Panel({ contentEl: 'usr', autoScroll: true })
			});
		}
		
		// Search databases window
		if (!dblw)
		{
			dblw = new Ext.Window({
				el:'dbl-win', layout:'fit', x:200, y:100, width:600, height:450, 
				closeAction:'hide', plain: true, animCollapse: false,
				items: new Ext.Panel({ contentEl: 'dbl', autoScroll: true })
			});
		}
		
		// Dialog window
		if (!dlgw)
		{
			dlgw = new Ext.Window({
				el:'dlg-win', layout:'fit', x:350, y:200, width:300, height:150, 
				closeAction:'hide', plain: true, animCollapse: false,
				items: new Ext.Panel({ contentEl: 'dlg', autoScroll: true })
			});
		}
		
		// DesInventar (input form) Window
		if (!difw)
		{
			difw = new Ext.Window({
				el:'divDatacardWindow', layout:'fit', 
				x: 65, y: 0, width:960, height:638, 
				closeAction:'hide', plain: true, animCollapse: false,
				items: new Ext.Panel({ contentEl: 'dif-cfg', autoScroll: true })
			});
			difw.on('hide',function() {
				jQuery('#divDatacardWindow').hide();
				showtip('');					
			});
		}
		
		// Main menu
		var mnuLang = new Ext.menu.Menu({
			id: 'langSubMenu',
			items:
			[
				{-foreach name=LanguageList key=key item=item from=$LanguageList-}
				{id: '{-$key-}', text: '{-$item-}', handler: onMenuItem},
				{-/foreach-}
			]
		});
		
		var muser = new Ext.menu.Menu({
			id: 'userMenu',
			items: [
				{id: 'mnuUserLogin'       , text: '{-#benter#-}'            , handler: onMenuItem }, 
				{id: 'mnuUserChangeLogin' , text: '{-#mnuUserChangeLogin#-}', handler: onMenuItem, hidden: true },
				{id: 'mnuUserEditAccount' , text: '{-#tconfigacc#-}'        , handler: onMenuItem, hidden: true },
				{id: 'mnuUserLogout'      , text: '{-#tclosesess#-}'        , handler: onMenuItem, hidden: true }, 
				{id: 'mnuUserLanguage'    , text: '{-#mlang#-}'             , menu: mnuLang },
				{id: 'mnuFileQuit',  text: '{-#mquit#-}'                    , handler: onMenuItem  }
			]
		});
		
		var mquery = new Ext.menu.Menu({
			id: 'queryMenu',
			items: [
				{id:'menuQueryToggle', text: '{-#mgotoqd#-}'   , handler: onMenuItem  },
				{id:'mnuQueryNew'    , text: '{-#mnewsearch#-}', handler: onMenuItem  },
				{id:'menuQuerySave'  , text: '{-#msavequery#-}', handler: onMenuItem  },
				{id:'mnuQueryOpen'   , text: '{-#mopenquery#-}', handler: onMenuItem  }
			]
		});
		
		var mcards = new Ext.menu.Menu({
			id: 'cardsMenu',
			items: [
				{id:'mnuDatacardView'      , text: '{-#mnuDatacardView#-}'      , handler: onMenuItem },
				{id:'mnuDatacardInsertEdit', text: '{-#mnuDatacardInsertEdit#-}', handler: onMenuItem, hidden: true },
				{id:'mnuDatacardImport'    , text: '{-#mnuDatacardImport#-}'    , handler: onMenuItem, hidden: true },
				{id:'mnuDatabaseExport'    , text: '{-#mnuDatabaseExport#-}'    , handler: onMenuItem, hidden: true },
				{id:'mnuDatabaseImport'    , text: '{-#mnuDatabaseImport#-}'    , handler: onMenuItem, hidden: true },
				{id:'mnuDatabaseConfig'    , text: '{-#mnuDatabaseConfig#-}'    , handler: onMenuItem, hidden: true }
			]
		});
		
		var mbases = new Ext.menu.Menu({
			id: 'basesMenu',
			items: [
				{id:'mnuDatabaseFind'   , text: '{-#mdbfind#-}'          , handler: onMenuItem },
				{id:'mnuAdminUsers'     , text: '{-#mnuUserAdmin#-}'     , handler: onMenuItem, hidden: true },
				{id:'mnuAdminDatabases' , text: '{-#mnuAdminDatabase#-}' , handler: onMenuItem, hidden: true }
			]
		});
		
		var mhelp = new Ext.menu.Menu({
			id: 'helpMenu',
			style: { overflow: 'visible' },
			items: [
				{id:'mnuHelpWebsite'      , text: '{-#mwebsite#-}' , handler: onMenuItem  },
				{id:'mnuHelpMethodology'  , text: '{-#hmoreinfo#-}', handler: onMenuItem  },
				{id:'mnuHelpDocumentation', text: '{-#hotherdoc#-}', handler: onMenuItem  },
				{id:'mnuRegionInfo'       , text: '{-#hdbinfo#-}'  , handler: onMenuItem, hidden: true },
				{id:'mnuHelpAbout'        , text: '{-#mabout#-}'   , handler: onMenuItem  }
			]
		});
		
		var tb = new Ext.Toolbar({
			renderTo: 'toolbar',
			items : [
				{ id:'mnuUser'       , text:'{-#tuser#-}'     , menu: muser },
				{ id:'mnuQuery'      , text:'{-#msearch#-}'   , menu: mquery, hidden: true },
				{ id:'mnuCards'      , text:'{-#mdcsection#-}', menu: mcards, hidden: true },
				{ id:'mnuDB'         , text:'{-#mdatabases#-}', menu: mbases},
				{ id:'mnuHelp'       , text:'{-#mhelp#-}'     , menu: mhelp}
			]
		});
		tb.add('->',{id: 'mnuRegionInfoLabel', text: '', handler: onMenuItem });
		tb.add('->',{id: 'mnuHelpWebsite'    , text: '<img src="{-$desinventarURL-}/images/di_logo4.png" alt="" />', handler: onMenuItem });

		// Add UserId to menu text when user is logged in
		if (jQuery('#desinventarUserId').val() != '')
		{
			Ext.getCmp('mnuUser').setText(Ext.getCmp('mnuUser').getText() + ' : ' + jQuery('#desinventarUserId').val());
			Ext.getCmp('mnuUserLogin').hide();
			Ext.getCmp('mnuUserChangeLogin').show();
			Ext.getCmp('mnuUserEditAccount').show();
			Ext.getCmp('mnuUserLogout').show();
		}

		// Configure which options are visible using RoleValue
		var UserRoleValue = parseInt(jQuery('#desinventarUserRoleValue').val());

		if (UserRoleValue >= 5)
		{
			Ext.getCmp('mnuAdminUsers').show();
			Ext.getCmp('mnuAdminDatabases').show();
		}
		
		// Hide Menu items when no Region is Selected
		if (jQuery('#desinventarRegionId').val() != '')
		{
			Ext.getCmp('mnuRegionInfo').show();
			Ext.getCmp('mnuRegionInfoLabel').setText('[' + jQuery('#desinventarRegionLabel').val() + ']');
			Ext.getCmp('mnuQuery').show();
			Ext.getCmp('mnuCards').show();

			// Feeder/Supervisor/Admin
			if (UserRoleValue >= 2) 
			{
				// Edit datacards instead of only view them
				Ext.getCmp('mnuDatacardView').hide();
				Ext.getCmp('mnuDatacardInsertEdit').show();
				// Enable other functions
				Ext.getCmp('mnuDatacardImport').show();
				Ext.getCmp('mnuDatabaseExport').show();
				if (UserRoleValue >= 4)
				{
					Ext.getCmp('mnuDatabaseImport').show();
					Ext.getCmp('mnuDatabaseConfig').show();
				}
			}
			
		} //if


		// layout
		var viewport = new Ext.Viewport({
			id:'viewport',
			contentEl: 'divViewport',
			layout:'border',
			items:[
				{
					region:'north',
					height: 30,
					contentEl: 'north'
				},
				{
					region: 'south',
					id: 'southm',
					split: false,
					title: '{-#tmguidedef#-}',
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
				}),
				{
					region: 'west',
					id: 'westm',
					split: false,
					width: 350,
					title: '{-#tsubtitle#-}',
					autoScroll: true,
					margins:'0 2 0 0',
					collapsible: true,
					contentEl: 'west'
				}
			]
		}); //viewport

		if (jQuery('#desinventarRegionId').val() == '')
		{
			Ext.getCmp('westm').hide();
			viewport.doLayout();
		}
		
		// ==> Results Configuration Windows
		// Data
		var datw;
		var datb = Ext.get('dat-btn');
		if (datb != null)
		{
			datb.on('click', function() {
				if (validateQueryDefinition()) {
					if (!datw) {
						datw = new Ext.Window({
							el:'dat-win',
							layout:'fit',
							width:600,
							height:400, 
							closeAction:'hide',
							plain: true,
							animCollapse: false,
							items: new Ext.Panel({contentEl: 'dat-cfg', autoScroll: true }),
							buttons: [
								{text:'{-#tclear#-}',
									handler: function() {
										$('CD').reset();
										} //handler
								},
								{text:'{-#tsend#-}',
									handler: function() {
										if (sendList("result")) {
											$('DCRes').value = "D";
											datw.hide();
											$('bsave').style.visibility = 'visible';
											$('bprint').style.visibility = 'visible';
										} else {
											console.debug("{-#derrmsgfrm#-}");
										}
									} //handler
								},
								{text:'{-#tclose#-}',
									handler: function() {
										datw.hide();
									} //handler
								}
							] //button
						});
					}
					datw.show(this);
				}
			}); // data window
		}
		// Statistics
		var stdw;
		var stdb = Ext.get('std-btn');
		if (stdb != null)
		{
			stdb.on('click', function() {
				if (validateQueryDefinition()) {
					if (!stdw) {
						stdw = new Ext.Window({
							el:'std-win',  layout:'fit',  width:600, height:400, 
							closeAction:'hide', plain: true, animCollapse: false,
							items: new Ext.Panel({contentEl: 'std-cfg', autoScroll: true }),
							buttons: [
								{text:'{-#tclear#-}',
									handler: function() {
										$('CS').reset();
									}
								},
								{text:'{-#tsend#-}',
									handler: function() {
										if (sendStatistic("result")) {
											$('DCRes').value = "S";
											stdw.hide();
											$('bsave').style.visibility = 'visible';
											$('bprint').style.visibility = 'visible';
										} else {
											console.debug("{-#serrmsgfrm#-}");
										}
									} //handler
								},
								{text:'{-#tclose#-}',
									handler: function() {
										stdw.hide();
									}
								}
							]
						});
					}
					stdw.show(this);
				}
			}); // statistics
		}
		// Graphic
		var grpw;
		var grpb = Ext.get('grp-btn');
		if (grpb != null)
		{
			grpb.on('click', function() {
				if (validateQueryDefinition()) {
					if (!grpw) {
						grpw = new Ext.Window({
							el:'divGraphParameters',  layout:'fit',  width:750, height:420, 
							closeAction:'hide', plain: true, animCollapse: false,
							items: new Ext.Panel({contentEl: 'grp-cfg', autoScroll: true }),
							buttons: [
								{text:'{-#tclear#-}',
									handler: function() {
										$('CG').reset();
									}
								},
								{text:'{-#tsend#-}',
									handler: function() {
										sendGraphic('result');
										$('DCRes').value = "G";
										grpw.hide();
										$('bsave').style.visibility = 'visible';
										$('bprint').style.visibility = 'visible';
									}
								},
								{text:'{-#tclose#-}',
									handler: function() {
										grpw.hide();
									}
								}
							]
						});
					}
					grpw.show(this);
				}
			}); // Graphics
		}
		// Map
		var map; // Map Object
		var mapw;
		var mapb = Ext.get('map-btn');
		if (mapb != null)
		{
			mapb.on('click', function() {
				if (validateQueryDefinition()) {
					if (!mapw) {
						mapw = new Ext.Window({
							el:'map-win',  layout:'fit',  width:650, height:400, 
							closeAction:'hide', plain: true, animCollapse: false,
							items: new Ext.Panel({contentEl: 'map-cfg', autoScroll: true }),
							buttons: [
								{text:'{-#tclear#-}',
									handler: function() {
										$('CM').reset();
									}
								},
								{text:'{-#tsend#-}',
									handler: function() {
										if (sendMap("result")) {
											$('DCRes').value = "M";
											mapw.hide();
											$('bsave').style.visibility = 'visible';
											$('bprint').style.visibility = 'visible';
										} else {
											console.debug("{-#serrmsgfrm#-}");
										}
									}
								},
								{text:'{-#tclose#-}',
									handler: function() {
										mapw.hide();
									}
								}
							]
						});
					}
					mapw.show(this);
				}
			}); // Map
		}

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

		// quicktips
		Ext.apply(Ext.QuickTips.getQuickTip(), {maxWidth: 200, minWidth: 100, showDelay: 50, trackMouse: true});

	}); // Ext.onReady()
	// end ExtJS object

	function setTotalize(lnow, lnext)
	{
		var sour = $(lnow);
		var dest = $(lnext);
		// clean dest list
		for (var i = dest.length - 1; i>=0; i--)
		{
			dest.remove(i);
		}
		for (var i=0; i < sour.length; i++)
		{
			if (!sour[i].selected)
			{
				var opt = document.createElement('option');
				opt.value = sour[i].value;
				opt.text = sour[i].text;
				var pto = dest.options[i];
				try
				{
					dest.add(opt, pto);
				}
				catch(ex)
				{
					dest.add(opt, i);
				}
			}
		} //for
	} //function
	
	function setAdvQuery(value, ope)
	{
		$('QueryCustom').value += value + ' ';
		switch (ope)
		{
			case 'text':
				disab($('<'));
				disab($('>'));
				enab($('='));  $('=').value = "=''";
				enab($('<>')); $('<>').value = "<>''";
				enab($("LIKE '%%'"));
				disab($('=-1')); disab($('=0')); disab($('=-2'));
			break;
			case 'date':
				enab($('<')); $('<').value = "<''";
				enab($('>')); $('>').value = ">''";
				enab($('=')); $('=').value = "=''";
				enab($('<>')); $('<>').value = "<>''";
				enab($("LIKE '%%'"));
				disab($('=-1')); disab($('=0')); disab($('=-2'));
			break;
			case 'number':
				enab($('<')); $('<').value = "<";
				enab($('>')); $('>').value = ">";
				enab($('=')); $('=').value = "=";
				enab($('<>'));$('<>').value = "<>";
				disab($("LIKE '%%'"));
				enab($('=-1')); enab($('=0')); enab($('=-2'));
			break;
			case 'boolean':
				disab($('<'));
				disab($('>'));
				disab($('='));
				disab($('<>'));
				disab($("LIKE '%%'"));
				enab($('=-1')); enab($('=0')); enab($('=-2'));
			break;
		} //switch
	} //function
	
	function printRes()
	{
		window.print();
	}
	
	// Find all Effects fields enable by saved query
	window.onload = function()
	{
		// select optimal height in results frame
		//varhgt = screen.height * 360 / 600;
		//$('dcr').style = "height:"+ hgt + "px;"
		{-foreach name=ef1 key=k item=i from=$ef1-}
			{-assign var="ff" value="D_$k"-}
			{-if $qd.$ff[0] != ''-}
				enadisEff('{-$k-}', true);
				showeff('{-$qd.$ff[0]-}', 'x{-$k-}', 'y{-$k-}');
			{-/if-}
		{-/foreach-}
		{-foreach name=sec key=k item=i from=$sec-}
			{-assign var="sc" value="D_$k"-}
			{-if $qd.$sc[0] != ''-}
				{-foreach name=sc2 key=k2 item=i2 from=$i[3]-}
					{-assign var="ff" value="D_$k2"-}
					{-if $qd.$ff[0] != ''-}
						enadisEff('{-$k2-}', true);
						showeff('{-$qd.$ff[0]-}', 'x{-$k2-}', 'y{-$k2-}');
					{-/if-}
				{-/foreach-}
				enadisEff('{-$k-}', true);
			{-/if-}
		{-/foreach-}
		{-foreach name=ef3 key=k item=i from=$ef3-}
			{-assign var="ff" value="D_$k"-}
			{-if $qd.$ff[0] != ''-}
				enadisEff('{-$k-}', true);
				showeff('{-$qd.$ff[0]-}', 'x{-$k-}', 'y{-$k-}');
			{-/if-}
		{-/foreach-}
		{-foreach name=geol key=k item=i from=$geol-}
			{-if $i[3]-}
				setSelMap('{-$i[0]-}', '{-$k-}', true);
			{-/if-}
		{-/foreach-}
	} //function
		
		var geotree = new CheckTree('geotree');
</script>
