	<link rel="stylesheet" href="css/tabber.css" type="text/css">
	<style type="text/css">
		.bsave {
			background-image: url(images/saveicon.png) !important;
			background-repeat: no-repeat; background-position: top center; width: 22px; height: 22px;
		}
		.bprint {
			background-image: url(images/printicon.png) !important;
			background-repeat: no-repeat; background-position: top center; width: 22px; height: 22px;
		}
		#loading-mask {
		  position: absolute;
		  left:     0;
		  top:      0;
		  width:    100%;
		  height:   100%;
		  z-index:  20000;
		  background-color: white;
		}
		#loading {
		  position: absolute;
		  left:     50%;
		  top:      50%;
		  padding:  2px;
		  z-index:  20001;
		  height:   auto;
		  margin:   -35px 0 0 -30px;
		}
		#loading .loading-indicator {
		  background: url(loading.gif) no-repeat;
		  color:      #555;
		  font:       bold 13px tahoma,arial,helvetica;
		  padding:    8px 42px;
		  margin:     0;
		  text-align: center;
		  height:     auto;
		}
		button {
			border: 0 none;
			cursor: pointer;
			font-family:arial,tahoma,helvetica,cursive; font-size:12px; 
			padding: 0 15px 0 0;
			text-align: center;
			height: 24px;
			line-height: 24px;
			width: auto;
		}
		button.rounded {
			background: transparent url( images/bright_off.png ) no-repeat scroll right top;
			clear: left;
		}
		button span {
			display: block;
			padding: 0 0 0 15px;
			position: relative;
			white-space: nowrap;
			height: 24px;
			line-height: 24px;
		}
		button.rounded span {
			background: transparent url( images/bleft_off.png ) no-repeat scroll left top;
		}
		button.rounded:hover {
			background: transparent url( images/bright_on.png ) no-repeat scroll right top;
		}
		button.rounded:hover span {
			background: transparent url( images/bleft_on.png ) no-repeat scroll left top;
		}
		button::-moz-focus-inner {
			border: none;
		}
	</style>
