{-*** REGISTER NEW USER - CONTENT SECTION ***-}
{-config_load file="$lg.conf" section="di8_user"-}
<link rel="stylesheet" href="css/desinventar.css?version={-$jsversion-}" type="text/css">
{-include file="jquery.tpl" -}
<script type="text/javascript" src="{-$desinventarURL-}/include/md5.js"></script>
<script type="text/javascript" src="{-$desinventarURL-}/js/jquery.snippets.js?version={-$jsversion-}"></script>
<script type="text/javascript" src="{-$desinventarURL-}/js/user.js?version={-$jsversion-}"></script>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#divUserEdit").show();
		//onReadyUserAdmin();
	});	
</script>
{-include file="user_editform.tpl" adminEdit=false-}

