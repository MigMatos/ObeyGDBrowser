<?php include("../../_init_.php"); ?>

<head>
	<title id="tabTitle">Developer Apps</title>
	<meta charset="utf-8">
	<link href="../../assets/css/browser.css?v=3" type="text/css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.css" rel="stylesheet">
	<!-- <link href="https://unpkg.com/prismjs@1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet"> -->
    
	<link rel="icon" href="../../assets/devapps/defaultDevApp.png">
	<meta id="meta-title" property="og:title" content="Developer Apps">
	<meta id="meta-desc" property="og:description" content="Find songs to use in your levels!">
	<meta id="meta-image" name="og:image" itemprop="image" content="https://migmatos.alwaysdata.net/legacy/cdn/icons/disc.png">
	<meta name="twitter:card" content="summary">
	
</head>

<?php include("../../assets/htmlext/loadingalert.php"); ?>
<?php include("../../assets/htmlext/flayeralert.php"); ?>

<style>
	.searchResult {
		background-color: #3737378c;
	}
	.searchResult:nth-child(odd) {
		background-color: #0000007d;
	}

	#searchBox {
		background-color: rgb(0 0 0 / 0%);
	}
	
	.font-helvetica {
		font-size: 2.5vh;
	}

	.font-gold-pusab {
		font-size: 4.5vh;
	}

	.codeFormat {
		font-family: 'HELVETICA';
    	font-size: 2.5vh;
	}

	select.gdsInput{
		font-family: 'Pusab', Arial;
		border: 0 solid transparent;
		border-radius: 2vh;
		background-color: rgba(0, 0, 0, 0.3);
		white-space: nowrap;
		width: 100%;
		font-size: 3vh;
	}

	.codeApp-container {
        width: 80%;
        max-width: 800px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
		font-family: aller, helvetica, arial;
		margin-left: auto;
		margin-right: auto;
    }

    .codeApp-tabs {
        display: flex;
        background: #2d3748;
        border-bottom: 2px solid #1a202c;
    }

    .codeApp-tab {
        flex: 1;
        text-align: center;
        padding: 12px 0;
        cursor: pointer;
        color: #a0aec0;
        font-weight: bold;
        transition: background 0.3s, color 0.3s;
    }

    .codeApp-tab.active {
        background: #1a202c;
        color: #edf2f7;
    }
	
    .codeApp-content {
        display: none;
        padding: 16px;
        background: #1a202c;
        color: #edf2f7;
        font-family: "Courier New", Courier, monospace;
        font-size: 14px;
        overflow-x: auto;
        line-height: 1.5;
		text-align: left;
    }

    .codeApp-content.active {
        display: block;
    }

    pre {
        margin: 0 !IMPORTANT;
		padding: 0vh 0vh 0vh 1em !IMPORTANT;
		border-radius: 0 !IMPORTANT;
		height: 14em;
    }

	.token.comment{
		background-color: rgba(0,0,0,0);
	}

	.nodesingBtn {
		padding: 0px 0px;
		margin: 0px 0px;
		background: none;
		cursor: pointer;
		border: none;
	}
	
	.itemSelector {
		width: 7.6vh;
		height: 7.6vh;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.itemSelector:hover {
		transform: scale(1.070);
		background-color: rgb(255, 255, 255, 0.3);
		border-radius: 1vh;
	}

	.iconBtn > img {
		width: 6.5vh;
	}

	.colorBtn > div {
		width: 6.5vh;
		height: 6.5vh;
		border-radius: 1vh;
		border: 0.3vh solid black;
	}

	.selectedItem {
		border-image: url("../../assets/select.png") 10 stretch !important;
		border: 0.7vh solid;
	}

	.colorGroup {
		padding: 1vh;
    	display: flex;
	}

	.colorRadius > div {
		border-radius: 100%;
	}

	.itemsAssignedRewards {
		display: flex;
		align-items: center;
		flex-direction: column;
		padding: 0vh 2vh 0vh 2vh;
	}

	.customH3 {
		font-size: 3.3vh;
	}

</style>

<body class="levelBG darkBG" onbeforeunload="saveUrl()">

<div id="everything" style="overflow: auto;">

	

	<div class="popup" id="pageDiv">
		<div class="brownbox bounce center supercenter" style="width: 60vh; height: 34%">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Jump to Page</h2>
			<input type="number" id="pageSelect" placeholder="1"><br>
			<img src="../../assets/ok.png" height=20%; id="pageJump" class="gdButton center closeWindow">
			<img class="closeWindow gdButton" src="../../assets/close.png" height="25%" style="position: absolute; top: -13.5%; left: -6vh">

			<div class="supercenter" style="left: 25%; top: 43%; height: 10%;">
				<img class="gdButton" src="../../assets/whitearrow-left.png" height="160%" onclick="$('#pageSelect').val(parseInt($('#pageSelect').val() || 0) - 1); $('#pageSelect').trigger('input');">
			</div>
		
			<div class="supercenter" style="left: 75%; top: 43%; height: 10%;">
				<img class="gdButton" src="../../assets/whitearrow-right.png" height="160%" onclick="$('#pageSelect').val(parseInt($('#pageSelect').val() || 0) + 1); $('#pageSelect').trigger('input');">
			</div>
		</div>
	</div>


	<div class="popup" id="searchDiv">
		<div class="brownbox bounce center supercenter" style="width: 60vh; height: 34%">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Search Song</h2>
			<input type="text" id="searchSong" placeholder="Search!" style="width:85%; margin: 8% 0% 8% 0%; height: 25%; text-align: center;"><br>
			<img src="../../assets/ok.png" height=20%; id="searchSongBtn" class="gdButton center closeWindow">
			<img class="closeWindow gdButton" src="../../assets/close.png" height="25%" style="position: absolute; top: -13.5%; left: -6vh">
		</div>
	</div>

	<div class="popup" id="settingsDiv">
		<div id="filterStuff" class="brownbox bounce center supercenter" style="width: 101vh; height: 50%; padding-top: 0.3%; padding-bottom: 3.5%; padding-left: 1%">
			<h1 style="margin-bottom: 4%">Advanced Options</h1><br>
			<!-- <input type="text" id="searchSong" placeholder="Search!" style="width:85%; margin: 8% 0% 8% 0%; height: 25%; text-align: center;"><br> -->
			<div style="width: 93%;background-color: #00000065;border-radius: 2.5vh;padding: 1vh 0vh 1vh 5vh;">
				<h3 class="center supercenter" style="top: 23%;margin-bottom: 4%;color: gold;">Disable platforms</h3><br>
				<div><h1><input type="checkbox" id="box-nounknown" url="&amp;nounknown"><label for="box-nounknown" class="gdcheckbox gdButton" tabindex="0"></label>Unknown</h1></div>
				<div><h1><input type="checkbox" id="box-nodiscord" url="&amp;nodiscord"><label for="box-nodiscord" class="gdcheckbox gdButton" tabindex="0"></label>Discord</h1></div>
				<div><h1 style="font-size: 3.6vh;"><input type="checkbox" id="box-nong" url="&amp;nong"><label for="box-nong" class="gdcheckbox gdButton" tabindex="0"></label>Newgrounds</h1></div>
				<br>
				<div><h3><input type="checkbox" id="box-noroblibrary" url="&amp;noroblibrary"><label for="box-noroblibrary" class="gdcheckbox gdButton" tabindex="0"></label>Robtop Library</h3></div>
				<div><h3><input type="checkbox" id="box-noogdlibrary" url="&amp;noogdlibrary"><label for="box-noogdlibrary" class="gdcheckbox gdButton" tabindex="0"></label>OGDMusic Library</h3></div>
				<div><h1><input type="checkbox" id="box-nodropbox" url="&amp;nodropbox"><label for="box-nodropbox" class="gdcheckbox gdButton" tabindex="0"></label>Dropbox</h1></div>
			<!-- <img src="../assets/ok.png" height=20%; id="settingsDivBtn" class="gdButton center closeWindow"> -->
			</div>

			<div style="width: 100%; padding: 3vh 0vh 1vh 5vh;">
				<div><h3><input type="checkbox" id="box-removeunused" url="&amp;removeunused"><label for="box-removeunused" class="gdcheckbox gdButton" tabindex="0"></label>Remove unused</h3></div>
				<div><h3><input type="checkbox" id="box-removethumbs" url="&amp;removethumbs"><label for="box-removethumbs" class="gdcheckbox gdButton" tabindex="0"></label>Remove thumbnails</h3></div>
			</div>

			<img id="searchAdvSong" src="../../assets/btn-submit.png" height=13%; style="padding-top: 2vh;" id="settingsDivBtn" class="gdButton center closeWindow">
			<img class="closeWindow gdButton" src="../../assets/close.png" height="15%" style="position: absolute; top: -11.5%; left: -6vh">
		</div>
	</div>

	<div class="popup" id="devAppInfo">
		
		<div class="invisiblebox bounce center supercenter" id="devAppInfoBox" style="width: 130vh; height: 80%; background-color: #282737;">
			<div style="position: absolute; left: 0%; width: 133.4vh; left: -1.5%; top: -2.3%; border-top-right-radius: 2.2vh; border-top-left-radius: 2.2vh; overflow: hidden;"><img class="valign rightSpace dAlbum" src="data:image/svg+xml;charset=utf-8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100'><rect width='100%' height='100%' fill='rgba(0,0,0,0)'/></svg>" id="appImageBG" style="object-fit: cover; width: 135vh; height: 22.5vh; object-position: 0% 47%; background-color: #00000085;"></div>
			

			

			<h1 class="lessSpaced" style="font-size: 5.8vh; margin-top: 8.5%; margin-bottom: 4%; width: 90vh; "><img class="valign rightSpace dAlbum" src="../../assets/devapps/defaultDevApp.png" onerror="this.onerror=null; this.src='../../assets/devapps/defaultDevApp.png';" style="transform: translate(-160%, 0%); height: 23%;" id="devAppImage"><span style="position: absolute; transform: translate(-31%, 0%); width: 103vh; top: 17.6%; text-align: left; overflow: hidden;" id="appName">?</span></h1>
			
			<h3 class="lessSpaced" style="font-size: 3vh;margin-top: 0%;position: absolute;top: 91.5%;text-align: center;left: 21.5%;" id="devAppInfoExt">Developer apps will have <cg>permissions</cg> <br>based on the <cy>moderator</cy> who added the app.</h3>


			<h3 class="closeWindow lessSpaced" style="font-size: 4.6vh; margin-top: 1%; color: #ffbc3d;" title="Search songs from that artist"><span style="position: absolute; transform: translate(-39.5%, 0%); width: 103vh; top: 27.8%; text-align: left; pointer-events: none;"><span class="pre smaller inline gdButton help" id="appAuthor">?</span></span></h3>
			
			<div class="supercenter" style="top: 66%;height: 43%;padding-top: 2%;width: 70%;border: 0.7vh solid #00000075;background-color: #0000003b;border-radius: 5%;">
			
			
			<h3 class="lessSpaced" style="font-size: 3.5vh; margin-top: 1%;"><img class="valign rightSpace" src="../../assets/song/note.png" height="10%">SongID: <cg1 style="color:#ff75ff;"><span id="songID">0</span></cg1></h3>
			<h3 class="lessSpaced" style="font-size: 3.5vh; margin-top: 1%;"><img class="valign rightSpace" src="../../assets/smallinfo.png" height="10%">Size: <cg1 style="color:#ff75ff;"><span id="songID">0</span> MB</cg1></h3>
			<h3 class="lessSpaced" style="font-size: 3.5vh; margin-top: 1%;"><img class="valign rightSpace" src="../../assets/song/views.png" height="7%">Level(s) count: <cg1 style="color:#ff75ff;"><span id="songCount">0</span></cg1></h3>
			<h3 class="lessSpaced" style="font-size: 3.5vh; margin-top: 1%;"><img class="valign rightSpace" src="../../assets/site.png" height="10%">Platform: <cg1 style="color:#ff75ff;"><span id="songPlatform">?</span></cg1></h3>
			
				
			</div>

			<div class="supercenter" style="top: 82%; height: 5%; display: inline-flex; align-items: center;">
				<div class="gdsButton blue" onclick="regenerateAppToken(document.getElementById('activateAppID').value)" src="none" id="songLink" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/new.png" height="80%">Regenerate token</h3></div>
				<div class="gdsButton" onclick="copyTokenApp(document.getElementById('appTokenResult').textContent)" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/iconkitbuttons/copy.png" height="80%">Copy token</h3></div>
				<div class="gdsButton red closeWindow" style="padding-left:1.5vh;padding-right:1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/x.png" height="80%">Exit</h3></div>
			</div>

			
			<img class="closeWindow gdButton" src="../../assets/close.png" onclick="closeMessageCustomFrame()" height="15%" style="position: absolute; top: -10.5%; left: -6vh">

			
		
		</div>
	</div>


	<div class="popup" id="createApp">
		<form autocomplete="off" id="createAppForm" class="purplebox bounce center supercenter" style="width: 120vh; height: 90%" target="_blank" onsubmit="return false;">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Add vault code</h2>
			<input type="text" name="act" value="create" hidden>
			<input type="text" name="token" id="partialCreateApptoken" value="" hidden>
			<input type="text" name="accountID" value="<?php echo isset($_SESSION['accountID']) ? $_SESSION['accountID'] : 0; ?>" hidden id="accountIDCreateApp">

			<h3 class="smaller" style="font-size: 5.5vh; margin-top: 3vh;">Code: 
				<input type="text" placeholder="Your code name" maxlength="255" name="code" required style="width:50%; margin: 0.1% 0% 0.1% 0%; height: 7%; text-align: center;"><br>
			</h3>

			<h3 class="smaller" style="font-size: 5.5vh;margin-top: 1%;display: flex;justify-content: center;">Expiration date:
				<div style="margin-left: 2vh;" onclick="CreateFLSelector('expireDateselect','Select expiration')"><select class="gdsInput select" size="1" style="text-align: center;" id="expireDateselect" name="expiredate" required>
					<option value="-1" selected>Never</option>
					<option value="21600">6 hours</option>
					<option value="43200">12 hours</option> 
					<option value="86400">1 day</option>
					<option value="345600">2 days</option>
					<option value="604800">1 week</option>        
					<option value="1209600">2 weeks</option>     
					<option value="2592000">1 month</option>     
					<option value="15552000">6 months</option>    
					<option value="31536000">1 year</option>     
			</select></div></h3>

			<h3 class="smaller" style="font-size: 5.5vh; margin-top: 1%">Uses: 
				<input type="number" placeholder="Infinite uses" min="1" name="uses" style="width:50%; margin: 0.1% 0% 0.1% 0%; height: 7%; text-align: center;"><br>
			</h3>

			<h3 class="smaller" style="font-size: 5.5vh;margin-top: 1%;display: flex;align-items: center;flex-direction: column;">Add rewards
				<div style="display: flex;background-color: rgba(0, 0, 0, 0.3);border-radius: 5vh;width: fit-content;align-items: center;justify-content: center;padding-left: 5vh;padding-right: 5vh;">
					<div onclick="CreateFLAlertRewardsAPI(this,10)" style="display: flex;align-items: center; justify-content: center;"><select class="gdsInput select" size="1" style="text-align: center;" id="rewardSelector" min-options="1" max-options="10" api-url="../../api/vaultcodes.php" required><option value="0" disabled hidden selected>Select here!</option></select></div>
					<div class="gdsButton bluepink" id="addRewardBtnItem" onclick="showNoItemSelected()" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 3vh;height: 5vh; padding-top: 0.8vh; display: flex; justify-content: center;"><h3 class="gdfont-Pusab" style="" id="textContentFileSelect">Select <span id="select-type-text">amount</span></h3></div>
					<div class="gdsButton blue" onclick="processRewardSelection()" style="padding-left:1.5vh;padding-right:1.5vh;height: 5vh; padding-top: 0.8vh; display: flex; justify-content: center;"><h3 class="gdfont-Pusab" style="" id="textContentFileSelect">Add reward</h3></div>
				</div>
			</h3>

			<!-- ---------- REWARDS HIDDEN ----------- -->
			<input type="number" id="rewardAmountID" style="height: 6vh; display: none;">
			<select class="gdsInput select" multiple name="rewardsid[]" style="display: none; text-align: center;height: 6vh;" id="rewardSelectorTypeID"></select>
			<select class="gdsInput select" multiple name="rewardsamount[]" style="display: none; text-align: center;height: 6vh;" id="rewardSelectorAmounts"></select>
			<!-- ------------------------------------- -->

			<h3 class="smaller" style="font-size: 5.5vh;margin-top: 1%;display: flex;align-items: center;flex-direction: column;">Assigned rewards
				<div id="rewardItems" style="height: 18vh; margin-top: 1.5vh;padding: 2vh 0 3vh 0;display: flex;background-color: rgba(0, 0, 0, 0.3);border-radius: 5vh;width: 85%;padding-left: 5vh;align-items: center;justify-content: center;">
					<h2 class="smaller center" style="font-size: 3.5vh; margin-top: 1%">None reward</h2>
				</div>
			</h3>

			<img style="margin-top: 2.8vh;" src="../../assets/btn-submit.png" height=7%; id="" class="gdButton center submitForm">

			<img class="closeWindow gdButton" src="../../assets/close.png" height="10%" style="position: absolute; top: -6.5%; left: -6vh">
		</form>
	</div>

	<div class="popup" id="rewardsPopup" type-reward="item">
		<form id="rewardsPopupBox" autocomplete="off" class="bluebox bounce center supercenter" style="width: 80%; height: 80%;" action="" onsubmit="return false;">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Select <span id="rewardTitle-Select"></span></h2>

			<h3 class="smaller" id="form-reward-amount" style="font-size: 5.5vh; margin-top: 1%">Amount:
				<input type="number" min="1" value="1" id="get-reward-amount" required style="width:50%; margin: 0.1% 0% 0.1% 0%; height: 5.5vh; text-align: center;"><br>
			</h3>

			<h3 class="smaller" id="form-reward-itemselect" style="font-size: 5.5vh;margin-top: 1%;display: flex;align-items: center;flex-direction: column;">
				<div id="rewardIconsAmount" style="flex-wrap: wrap;margin-top: 1.5vh;padding: 2vh 1vh 3vh 1vh;display: flex;background-color: rgba(0, 0, 0, 0.3);border-radius: 5vh;width: 85%;align-items: center;justify-content: center;height: 35vh;overflow-y: auto;">
					<h2 class="smaller center" id="noneIconsText" style="font-size: 3.5vh; margin-top: 1%">None item</h2>
					<div id="loadingIcons" style="height: 35%; display: none;">
						<img class="spin noSelect" src="../../assets/loading.png" height="105%">
					</div>
				</div>
			</h3>

			<!-- <div style="top: 85%;height: 5%;display: ruby;align-items: center;justify-content: center; text-wrap: nowrap;">
				<div class="gdsButton blue" onclick="regenerateAppToken(document.getElementById('activateAppID').value)" src="none" id="songLink" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/new.png" height="80%">Regenerate token</h3></div>
				<div class="gdsButton" onclick="copyTokenApp(document.getElementById('appTokenResult').textContent)" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/iconkitbuttons/copy.png" height="80%">Copy token</h3></div>
				<div class="gdsButton" onclick="updateAppInfo(document.getElementById('activateAppID').value)" style="padding-left:1.5vh;padding-right:1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/refresh.png" height="80%">Refresh</h3></div>
				<div class="gdsButton red closeWindow" style="padding-left:1.5vh;padding-right:1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/x.png" height="80%">Exit</h3></div>
			</div> -->

			<img src="../../assets/ok.png" style="width: 11vh; margin-top: 2vh;" onclick="$('#rewardsPopup').attr('style', 'display: none;') , returnIntValueReward($('#rewardsPopup').attr('type-reward')); " class="gdButton center">
		</form>
	</div>

	<!-- <div class="popup" id="editApp">
		<form autocomplete="off" id="editAppForm" class="bluebox bounce center supercenter" style="width: 65%; height: 60%; overflow-y: auto;">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Edit app</h2>
			<p>Developer apps will have <cg>permissions</cg> based on the <cy>moderator</cy> who added the app.</p>

			<input type="text" name="act" value="edit" hidden id="editAppAct">
			<input type="number" name="id" value="0" hidden id="editAppID">

			<h3 class="smaller" style="font-size: 5.5vh; margin-top: 1%">App name</h3>
			<input type="text" name="nameApp" required style="width:60%; margin: 1% 0% 1% 0%; height: 10%; text-align: center;" id="editAppName"><br>

			<h3 class="smaller" style="font-size: 5.5vh; margin-top: 1%">App expiration
				<div onclick="CreateFLSelector('appExpdevEdit','Select Difficulty')"><select class="gdsInput select" size="1" style="width:60%; height: 10%; text-align: center; margin-left: 20%;" id="appExpdevEdit" name="expireDate" required>
					<option value="-1" selected>Never</option>
					<option value="43200">12 hours</option> 
					<option value="86400">1 day</option> 
					<option value="604800">1 week</option>  
					<option value="3628800">6 weeks</option> 
					<option value="31536000">1 year</option> 
			</select></div></h3>

			<div style="position: relative; top: 5%;height: 5%;display: ruby;align-items: center;justify-content: center; text-wrap: nowrap;">
				<div class="gdsButton" onclick="editAppInfo(document.getElementById('editAppID').value)" style="padding-left:1.5vh;padding-right:1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/editBtn.png" height="80%">Edit App</h3></div>
				<div class="gdsButton red closeWindow" style="padding-left:1.5vh;padding-right:1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/x.png" height="80%">Exit</h3></div>
			</div>

			<button type="button" class="submitForm" id="submitAppActive" hidden>
		</form>
	</div> -->


	<div class="popup" id="purgeDiv">
		<div class="fancybox bounce center supercenter" style="width: 35%; height: 28%">
			<h2 class="smaller center" style="font-size: 5.5vh">Delete All</h2>
			<p class="bigger center" style="line-height: 5vh; margin-top: 1.5vh;">
				Delete all saved online levels?<br><cy>Levels will be cleared from your browser.</cy>
			</p>
			<img src="../../assets/btn-cancel-green.png" height=25%; class="gdButton center closeWindow">
			<img src="../../assets/btn-delete.png" height=25%; id="purgeSaved" class="gdButton center sideSpaceB">
		</div>
	</div>

	<div class="popup" id="shuffleDiv">
		<div class="fancybox bounce center supercenter">
			<h2 class="smaller center" style="font-size: 5.5vh">Random Level</h2>
			<p class="bigger center" id="levelInfo" style="line-height: 5vh; margin-top: 1.5vh;">
				A random level cannot be picked with your current <cy>search filters!</cy>
				This is because there is no way to tell how many results were found, due to the GD servers inaccurately saying there's <cg>9999</cg>.
			</p>
			<img src="../../assets/ok.png" width=20%; class="gdButton center closeWindow">
		</div>
	</div>

	<div style="position:absolute; bottom: 0%; left: 0%; width: 100%">
		<img class="cornerPiece" src="../../assets/corner.png" width=7%;>
	</div>

	<div style="position:absolute; bottom: 0%; right: 0%; width: 100%; text-align: right;">
		<img class="cornerPiece noframe" src="../../assets/corner.png" width=7%; style="transform: scaleX(-1)">
	</div>

	<div id="searchBox" class="supercenter dragscroll">
		<div style="height: 4.5%"></div>
	</div>
	
	<div class="epicbox supercenter gs" style="width: 120vh; height: 80%; pointer-events: none;"></div>

	<div class="center noframe" style="position:absolute; top: 8%; left: 0%; right: 0%">
		<h1 id="header" style="position: absolute; left: 50%; transform: translate(-50%, 1280%);"></h1>
		
	</div>

	<div style="text-align: right; position:absolute; top: 1%; right: 2%">
		<h2 class="smaller noframe" style="font-size: 4.5vh" id="pagenum"></h2>
	</div>

	<div title="Search Song" style="text-align: right; position:absolute; top: 7.5%; right: 2%; height: 12%;">
		<img src="../../assets/magnify.png" height="60%" class="gdButton noframe" style="margin-top: 5%" onclick="$('#searchDiv').show();">
	</div>

	<div title="Jump to page" style="text-align: right; position:absolute; top: 15.5%; right: 1.5%; height: 11%;">
		<img src="../../assets/double-arrow.png" height="60%" class="gdButton noframe" style="margin-top: 5%" onclick="$('#pageDiv').show(); $('#pageSelect').focus().select()">
	</div>

	<div title="Jump to page" style="text-align: right; position:absolute; top: 23.5%; right: 2%; height: 12%;">
		<img src="../../assets/settingsbutton.png" height="60%" class="gdButton noframe" style="margin-top: 5%" onclick="$('#settingsDiv').show();">
	</div>

	<div style="position:absolute; top: 2%; left: 1.5%; width: 10%; height: 25%; pointer-events: none">
		<img class="gdButton yesClick noframe" id="backButton" src="../../assets/back.png" height="30%" onclick="backButton()">
	</div>

	<div id="purge" style="position:absolute; bottom: 1%; right: -3%; width: 10%; display:none;">
		<img class="gdButton noframe" src="../../assets/delete.png" width="60%" onclick="$('#purgeDiv').show()">
	</div>

	<div onclick="createApp()" title="Create new mappack" class="checkperm-mappacks" style="position:absolute; bottom: 15.5%; right: 1%; width: 15%; text-align: right;">
		<h3 style="transform: translate(3%, -5%);">Add App</h3>
		<img class="gdButton" src="../../assets/newBtn.png" width="40%" id="createMapPack"></a>
	</div>

	<div style="position:absolute; bottom: 2%; right: 1%; text-align: right; width: 15%;">
		<img class="gdButton noframe" src="../../assets/refresh.png" width="40%" id="refreshPage">
		<img onclick="$('#rewardsPopup').show();" class="gdButton noframe" src="../../assets/info.png" width="40%" id="refreshPage">
	</div>

	<div style="position:absolute; bottom: 2%; right: 8.5%; text-align: right; width: 15%; display: none" id="gdWorld">
		<a title="Geometry Dash World" href="/search/*?type=gdw"><img class="gdButton" src="../../assets/gdw_circle.png" width="40%"></a>
	</div>

	<div style="position:absolute; bottom: 2%; right: 8.5%; text-align: right; width: 15%; display: none" id="normalGD">
		<a title="Back to Geometry Dash" href="/search/*?type=featured"><img class="gdButton" src="../../assets/gd_circle.png" width="40%"></a>
	</div>

	<div style="position: absolute; left: 7%; top: 45%; height: 10%;">
		<img class="gdButton noframe" id="pageDown" style="display: none"; src="../../assets/arrow-left.png" height="90%">
	</div>

	<div style="position: absolute; right: 7%; top: 45%; height: 10%;">
		<img class="gdButton noframe" id="pageUp" style="display: none"; src="../../assets/arrow-right.png" height="90%">
	</div>

	<div class="supercenter noframe" id="loading" style="height: 10%; top: 47%; display: none;">
		<!-- <img class="spin noSelect" src="../assets/loading.png" height="105%"> -->
	</div>

</div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch-jsonp/1.1.1/fetch-jsonp.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch-jsonp/1.1.1/fetch-jsonp.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="../../misc/global.js"></script>
<script type="text/javascript" src="../../misc/dragscroll.js"></script>
<script type="text/javascript" src="../../misc/gdcustomframe.js"></script>
<script type="text/javascript" src="../../misc/gdcustomalerts.js"></script>

<!-- Extensions -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<!-- PrismJS Language Plugins -->

<!-- <script src="https://unpkg.com/prismjs@1.29.0/plugins/autoloader/prism-autoloader.min.js"></script> -->


<script>
$("#loading-main").hide();

let serverType = "<?php print_r($serverType); ?>"
let iconsJSON = JSON.parse(`{"cube":"999","ship":"999","ball":"999","ufo":"999","wave":"999","robot":"999","spider":"999","swing":"999","jetpack":"999"}`);
let colorsJSON = JSON.parse(`[]`);
let deathEffects = "99";
let trails = "99";
let shipFires = "99";
let customItems = JSON.parse(`[]`);
try {
	iconsJSON = JSON.parse(`<?php print_r($iconsJSON); ?>`);
	colorsJSON = JSON.parse(`<?php print_r($colorsJSON); ?>`);
	deathEffects = `<?php print_r(isset($gdps_settings["deatheffects"]) ? $gdps_settings["deatheffects"] : "") ?>`;
	trails = `<?php print_r(isset($gdps_settings["trails"]) ? $gdps_settings["trails"] : "") ?>`;
	shipFires = `<?php print_r(isset($gdps_settings["shipfires"]) ? $gdps_settings["shipfires"] : "") ?>`;
	customItems = JSON.parse(`<?php print_r(json_encode(isset($gdps_settings["customitems"]) ? $gdps_settings["customitems"] : "")) ?>`);
} catch {
	CreateFLAlert("Warning!","Update your **_icons_ , _colors_ , _deatheffects_ , _trails_ , _shipfires_ and _customfires_ settings** in `GDPS Settings`!");
}

const MAX_API_REQUESTS = 10;
const TIME_API_WINDOW = 5000; // 5 segundos
let requestAPITimestamps = [];
const CACHE_EXPIRATION_TIME = 2 * 24 * 60 * 60 * 1000; 
const ORIGINAL_URL = window.location.href;

function WIPFunction() {
	CreateFLAlert("WIP","This feature is  `r0 not finished`, wait for  `g0 future updates!`");
}

const rewardPopup = document.getElementById("rewardsPopup");
const rewardsPopupBox = document.getElementById("rewardsPopupBox");
const rewardPopupTitle = document.getElementById("rewardTitle-Select");
const rewardAmountID = document.getElementById("rewardAmountID");

document.addEventListener("FLlayerclosed", function(event) {

	if(event.detail.message != "rewardSelector") return;
	console.log("Changed option!")

	const rewardSelector = document.getElementById("rewardSelector");

	const selectedOption = rewardSelector.options[rewardSelector.selectedIndex];
	const itemType = selectedOption.getAttribute("item-type");
	const selectTypeText = document.getElementById("select-type-text");
	const addRewardBtnItem = document.getElementById("addRewardBtnItem");


	console.log("The item type is ",itemType);

	const itemMapping = {
		"item": { text: "Amount", action: "showAmountFormItem()" },
		"color": { text: "Color", action: "showColorFormItem()" },
		"icon-cube": { text: "Cube", action: "showVehicleFormItem('cube')" },
		"icon-ship": { text: "Ship", action: "showVehicleFormItem('ship')" },
		"icon-ball": { text: "Ball", action: "showVehicleFormItem('ball')" },
		"icon-ufo": { text: "UFO", action: "showVehicleFormItem('ufo')" },
		"icon-wave": { text: "Wave", action: "showVehicleFormItem('wave')" },
		"icon-robot": { text: "Robot", action: "showVehicleFormItem('robot')" },
		"icon-spider": { text: "Spider", action: "showVehicleFormItem('spider')" },
		"icon-swing": { text: "Swing", action: "showVehicleFormItem('swing')" },
		"icon-jetpack": { text: "Jetpack", action: "showVehicleFormItem('jetpack')" },
		"deatheffect": { text: "Death Effect", action: "showDeathEffectFormItem()" },
		"item-custom": { text: "Custom Item", action: "showCustomFormItem()" },
		"trail": { text: "Trail", action: "showTrailFormItem(0)" },
		"trail-ship": { text: "Ship Trail", action: "showTrailFormItem(1)" }
	};

	if (itemMapping[itemType]) {
		rewardPopup.setAttribute('type-reward', itemType);
		selectTypeText.innerText = itemMapping[itemType].text;
		rewardPopupTitle.innerText = itemMapping[itemType].text;
		addRewardBtnItem.setAttribute("onclick", itemMapping[itemType].action);
		
	} else {
		rewardPopup.setAttribute('type-reward', 'item');
		selectTypeText.innerText = "valid reward!";
		rewardPopupTitle.innerText = "?";
		addRewardBtnItem.setAttribute("onclick", "showNoItemSelected()");
	}

	rewardAmountID.value = 0;
});

function returnIntValueReward(typeReward) {
	if(typeReward == "item") {
		rewardAmountID.value = document.getElementById("get-reward-amount").value;
		document.getElementById("get-reward-amount").value = 0;
	}
}

function showNoItemSelected() {
	CreateFLAlert("Wait!", "You must first `select` a **valid reward type!**")
}

function showAmountFormItem() {
	rewardsPopupBox.style = "width: 50%;height: 25%;";
	$("#form-reward-amount").show();
	$("#form-reward-itemselect").hide()
	$("#rewardsPopup").show();
}

function showColorFormItem() {
	console.log("Showing Color Form Item");
	generateColorForm();
	rewardsPopupBox.style = "width: 80%;height: 63%;";
	
  	$("#form-reward-amount").hide();
	$("#form-reward-itemselect").show();
	$("#rewardsPopup").show();
}

function showVehicleFormItem(type) {
	console.log(`Showing Vehicle Form Item: ${type}`);
	generateIconsForm(type, iconsJSON[type]);
	rewardsPopupBox.style = "width: 80%;height: 63%;";
	
	$("#form-reward-amount").hide();
	$("#form-reward-itemselect").show();
	$("#rewardsPopup").show();
}

function showDeathEffectFormItem() {
	console.log("Showing Death Effect Form Item");
	generateIconsForm('deatheffects', deathEffects);
	rewardsPopupBox.style = "width: 80%;height: 63%;";
	
	$("#form-reward-amount").hide();
	$("#form-reward-itemselect").show();
	$("#rewardsPopup").show();
}

function showCustomFormItem() {
	console.log("Showing Custom Form Item");
	generateCustomItemsForm();
	rewardsPopupBox.style = "width: 80%;height: 63%;";
	
	$("#form-reward-amount").hide();
	$("#form-reward-itemselect").show();
	$("#rewardsPopup").show();
}

function showTrailFormItem(type) {
	console.log(`Showing Trail Form Item: ${type}`);
	if(type == 0) generateIconsForm('trail', trails);
	else if(type == 1) generateIconsForm('trail-ship', shipFires);

	rewardsPopupBox.style = "width: 80%;height: 63%;";
	
	$("#form-reward-amount").hide();
	$("#form-reward-itemselect").show();
	$("#rewardsPopup").show();
}

function generateIconsForm(typeform, numberform) {
	const container = document.getElementById('rewardIconsAmount');
	container.querySelectorAll('button.itemSelector, div.colorGroup').forEach(btn => btn.remove());

	if (!typeform || numberform < 1) {
		$('#noneIconsText').show();
		return;
	} else {
		$('#noneIconsText').hide();
		$('#loadingIcons').show();
	}

	
	const fragment = document.createDocumentFragment();

	for (let i = 1; i <= numberform; i++) {
		const button = document.createElement('button');
		button.id = `${typeform}-${i}`;
		button.classList.add('nodesingBtn', 'itemSelector', 'iconBtn');
		button.setAttribute('form', typeform);
		button.setAttribute('idform', i);

		const img = document.createElement('img');
		if (["cube","ship","ball","ufo","wave","robot","spider","swing","jetpack"].includes(typeform)) img.src = `https://gdbrowser.com/iconkit/premade/${typeform}_${i}.png`;
		else if(["deatheffects"].includes(typeform)) img.src = `../../assets/deatheffects/${i}.png`;
		else if(["trail"].includes(typeform)) img.src = `../../assets/trails/${i}.png`;
		else if(["trail-ship"].includes(typeform)) img.src = `../../assets/shipfires/${i}.png`;
		else img.src = `../../deatheffects/0.png`;
		
		img.alt = `${typeform} ${i}`;

		button.appendChild(img);
		fragment.appendChild(button);
	}
	$('#loadingIcons').hide();
	container.appendChild(fragment); 
}

function generateColorForm() {
	const container = document.getElementById('rewardIconsAmount');
	container.querySelectorAll('button.itemSelector, div.colorGroup').forEach(btn => btn.remove());

	if (Object.keys(colorsJSON).length < 1) {
		$('#noneIconsText').show();
		return;
	} else {
		$('#noneIconsText').hide();
		$('#loadingIcons').show();
	}

	const fragment = document.createDocumentFragment();
	const sortedColors = Object.entries(colorsJSON).sort((a, b) => a[1].order - b[1].order);
	let colorGroup;
	sortedColors.forEach((entry, index) => {
		const [key, color] = entry;

		if (index % 4 === 0) {
			if (colorGroup) {fragment.appendChild(colorGroup);}
			colorGroup = document.createElement('div');
			colorGroup.classList.add('colorGroup');
		}


		const button = document.createElement('button');
		button.id = `color-${key}`;
		button.classList.add('nodesingBtn', 'itemSelector', 'colorBtn');
		button.setAttribute('form', 'color');
		button.setAttribute('idform', key);

		const colorBox = document.createElement('div');
		colorBox.style.backgroundColor = `rgb(${color.r}, ${color.g}, ${color.b})`;

		button.appendChild(colorBox);
		colorGroup.appendChild(button);
	});


	if (colorGroup) {fragment.appendChild(colorGroup);}

	$('#loadingIcons').hide();
	container.appendChild(fragment);
}

function generateCustomItemsForm() {
	const container = document.getElementById('rewardIconsAmount');
	container.querySelectorAll('button.itemSelector, div.colorGroup').forEach(btn => btn.remove());

	if (!customItems || customItems.length < 1) {
		$('#noneIconsText').show();
		return;
	} else {
		$('#noneIconsText').hide();
		$('#loadingIcons').show();
	}

	const fragment = document.createDocumentFragment();

	customItems.forEach((item) => {
		const button = document.createElement('button');
		button.id = `custom-item-${item}`;
		button.classList.add('nodesingBtn', 'itemSelector', 'iconBtn');
		button.setAttribute('form', 'item-custom');
		button.setAttribute('idform', item);

		const img = document.createElement('img');
		img.src = `../../assets/customitems/${item}.png`;
		img.alt = `Custom Item ${item}`;

		button.appendChild(img);
		fragment.appendChild(button);
	});

	$('#loadingIcons').hide();
	container.appendChild(fragment);
}

document.getElementById('rewardIconsAmount').addEventListener('click', (e) => {
	const button = e.target.closest('button.itemSelector');
	if (!button) return;

	document.querySelectorAll('#rewardIconsAmount .selectedItem').forEach(el => el.classList.remove('selectedItem'));
	button.classList.add('selectedItem');
	console.log(button.getAttribute("idform"));
	rewardAmountID.value = parseInt(button.getAttribute("idform"));
	// button.getAttribute("idform")
});

function processRewardSelection() {
	const rewardAmountID = document.getElementById('rewardAmountID').value;
	const rewardSelector = document.getElementById('rewardSelector');
	const selectedOption = rewardSelector.options[rewardSelector.selectedIndex];
	const selectedOptionValue = selectedOption.value;
	const selectedItemType = selectedOption.getAttribute('item-type');

	if (rewardAmountID === "0" || selectedOptionValue === "0") {
		CreateFLAlert("Invalid reward","Please **select a valid** `reward type` and `amount/selection`.");
		return;
	}

	const amountSelect = document.getElementById('rewardSelectorAmounts');
	const typeSelect = document.getElementById('rewardSelectorTypeID');

	const existingPairs = [...amountSelect.options].map((opt, i) => ({
		amount: opt.value,
		type: typeSelect.options[i]?.value || ""
	}));

	const isDuplicate = existingPairs.some(pair => 
		pair.amount === rewardAmountID && pair.type === selectedOptionValue
	);

	if (isDuplicate) return;

	const amountOption = document.createElement('option');
	amountOption.value = rewardAmountID;
	amountOption.text = rewardAmountID;
	amountOption.setAttribute('item-type', selectedItemType);
	amountOption.setAttribute('selected', 'selected');
	amountOption.selected = true;
	amountSelect.appendChild(amountOption);

	const typeOption = document.createElement('option');
	typeOption.value = selectedOptionValue;
	typeOption.text = selectedOption.text;
	typeOption.setAttribute('type-item', selectedItemType);
	typeOption.setAttribute('selected', 'selected');
	typeOption.selected = true;
	typeSelect.appendChild(typeOption);

	generateRewardVisuals();
}

function generateRewardVisuals() {
	const rewardItemsContainer = document.getElementById('rewardItems');
	const amountOptions = [...document.getElementById('rewardSelectorAmounts').options];
	const typeOptions = [...document.getElementById('rewardSelectorTypeID').options];

	const fragment = document.createDocumentFragment();

	for (let i = 0; i < typeOptions.length; i++) {
		const typeOption = typeOptions[i];
		const amountOption = amountOptions[i];

		const typeform = typeOption.getAttribute('type-item');
		let amountCount = typeOption.value;
		let id = amountOption.value;

		const rewardDiv = document.createElement('div');
		rewardDiv.classList.add('itemsAssignedRewards');

		let deleteBtn = document.createElement('img');
		deleteBtn.classList.add("deleteBtn");
		deleteBtn.src = `../../assets/trash.png`;
		deleteBtn.style = "width: 5vh; padding-bottom: 1.3vh; cursor: pointer;";
		deleteBtn.setAttribute('onclick', `removeRewardSelection(${i})`);
		rewardDiv.appendChild(deleteBtn);



		let img = document.createElement('img');
		if(typeform == "color") {
			img = document.createElement('div');
			rewardDiv.classList.add('colorBtn','colorRadius');
			const colorBox = document.createElement('div');
			const { r, g, b } = colorsJSON[id];
			colorBox.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
			rewardDiv.appendChild(colorBox);
			let h2 = document.createElement('h3');
			h2.classList.add('smaller','center', 'customH3');
			if(amountCount == "1002") h2.textContent = `Col 1`;
			else if(amountCount == "1003") h2.textContent = `Col 2`;
			else h2.textContent = `Col G`;
			rewardDiv.appendChild(h2);
			
		} else {
			rewardDiv.classList.add('iconBtn');
			if (["icon-cube", "icon-ship", "icon-ball", "icon-ufo", "icon-wave", "icon-robot", "icon-spider", "icon-swing", "icon-jetpack"].includes(typeform)) {
				const iconType = typeform.replace('icon-', '');
				img.src = `https://gdbrowser.com/iconkit/premade/${iconType}_${id}.png`;
			} else if (typeform === "deatheffect") {
				img.src = `../../assets/deatheffects/${id}.png`;
			} else if (typeform === "trail") {
				img.src = `../../assets/trails/${id}.png`;
			} else if (typeform === "trail-ship") {
				img.src = `../../assets/shipfires/${id}.png`;
			} else if (typeform === "item-custom") {
				img.src = `../../assets/customitems/${id}.png`;
			} else {
				img.src = `../../assets/rewards/${amountCount}.png`;
			}
			img.alt = `${typeform} reward ${id}`;
			rewardDiv.appendChild(img);
			let h2 = document.createElement('h3');
			if(typeform === "item") {
				h2.classList.add('smaller','center', 'customH3');
				h2.textContent = `${id}`;
				rewardDiv.appendChild(h2);
			}
		}



		fragment.appendChild(rewardDiv);
	}

	rewardItemsContainer.innerHTML = '';
	rewardItemsContainer.appendChild(fragment);
}

function removeRewardSelection(index) {
	const amountSelect = document.getElementById('rewardSelectorAmounts');
	const typeSelect = document.getElementById('rewardSelectorTypeID');

	if (
		index >= 0 &&
		index < amountSelect.options.length &&
		index < typeSelect.options.length
	) {
		amountSelect.remove(index);
		typeSelect.remove(index);
		generateRewardVisuals();
	}
}


function createApp() {
	$('#partialCreateApptoken').val(generateToken(16))
	$('#createApp').show();
}

function checkisActiveApp(isActive, appName, id){
	if(isActive > 0) return
	
	console.log("No active app ", id)
	
	$(`#devAppTitle${id}`).text(`${appName} (Unsigned)`)
	$(`#devNameSpan${id}`).text("App not active")
	$(`#devRequests${id}`).hide()


}

$('.addSongClass').click(function() { 
	$('#addSong').show();
})


$('#pageDown').hide()
$('#pageUp').hide()

let accID;
const urlParams = new URLSearchParams(window.location.search);
let path = urlParams.get('str');

let legacyServer = true;
if(serverType != "legacy") legacyServer = false
if(path == null) path = "" + window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);

// if (!path || path.trim() === '') window.location.href = './search.php';
// if (path == "0") path = "*"
document.addEventListener('endLoadingItems', function(event) {
	if (new URLSearchParams(window.location.search).has('gdframe')) {
		$("#searchBox").hide()
		$("#scoreCustomTabs").hide()
		$("#leaderboardBox").hide()
		$('.noframe').hide();
		let songIDSelected = isNaN(Number(path)) ? 0 : Number(path)
		const $songElement = $(`#song${songIDSelected}`);
		if ($songElement.length) {$songElement.click();}
		else {
			$('#songInfo').show();
		}
		$('#songAuthor').css('pointer-events','none');
		$('#songInfoBox').removeClass('bounce');
	}
});


function profileRedirect(url) {
	var queryProfile = "";
    if (legacyServer == true) {
		queryProfile = "../../profile/?u=" + (encodeURIComponent(url).replace(/%2F/gi, "") || "");
	} else {
		queryProfile = "../../profile/" + (encodeURIComponent(url).replace(/%2F/gi, "") || "") 
	}
    if (queryProfile) window.location.href = "./u/" + queryProfile
}

function searchLevelsArtistRedirect(songID) {
	var queryLvl = "";
    if (legacyServer == true) {
		queryLvl = "/search/search.php/?s=0&songID="+ (encodeURIComponent(songID) || "0") + "&customSong";
	} else {
		queryLvl = "/search/0?songID="+ (encodeURIComponent(songID) || "0") + "&customSong";
	}
    if (queryLvl) window.location.href = ".." + queryLvl
}

//if (!path || path.trim() === '') path = '*';

let type = urlParams.get('type')


let loading = false;

let page = Math.max(0, urlParams.get('page'))

console.log(page);

let pages = 0
let results = 0
let legalPages = true
let gdwMode = false
let pageCache = {}
let apiURL = "../../api/vaultcodes.php"
let searchFilters = apiURL + "?str=" + path + "&page=[PAGE]";


// ---- Clean Text ----- //

function clean(text) {return ( text || "").toString().replace(/&/g, "&#38;").replace(/</g, "&#60;").replace(/>/g, "&#62;").replace(/=/g, "&#61;").replace(/"/g, "&#34;").replace(/'/g, "&#39;")}

// --- End --- //

function Append(firstLoad, noCache) {

	loading = true;
	if (!firstLoad) $('#pagenum').text(`Page ${(page + 1)}${pages ? ` of ${pages}` : ""}`)
	$('#searchBox').html('<div style="height: 4.5%"></div>')
	$('#pageSelect').val(page + 1)
	$('#loading').show()

	

	if (page == 0) $('#pageDown').hide()
	else $('#pageDown').show()

	if (page == (pages - 1)) $('#lastPage').addClass('grayscale').find('img').removeClass('gdButton')
	else $('#lastPage').removeClass('grayscale').find('img').addClass('gdButton')

	if (!noCache && pageCache[page]) appendLevels(pageCache[page])
	else Fetch(searchFilters.replace("[PAGE]", page)).then(appendLevels).catch(e => $('#loading').hide())

	function appendLevels(res) {

	

	if (res == '-1' || res.length == 0) { $('#loading').hide();  $('#pageUp').hide(); return loading = false }
	
	pageCache[page] = res

	

	if (firstLoad) {
		pages = res[0].pages - 1;
		results = res[0].results;
		if (!pages || pages == 1000 || pages < 1) {
			pages = null
			if (!superSearch) $('#shuffle').addClass('grayscale')
			else $('#shuffle').css('filter', 'hue-rotate(100deg)')
		}
		$('#shuffle').show()
		if (pages > 1) $('#lastPage').show()
		$('#pagenum').text(`Page ${page + 1}${pages ? ` of ${pages}` : ""}`)
	}

	

	if ((pages && page+1 >= pages) || (!pages && res.length < 9 && type != "recent")) $('#pageUp').hide()
	else $('#pageUp').show()
	
	console.log("Levels:", res);

	res.forEach((x, y) => {
		console.log("INIT")

		x.code = clean(x.code);
		// x.developer.userName = clean(x.developer.userName);

		
		
		$('#searchBox').append(`<div class="searchresult" title="Code: ${x.code}" id="app${x.id}">

			<div style="position: relative; height: 85%; align-content: center;">
			<h1 title="Code: ${x.code}" id="vaultCode${x.id}" style="width: fit-content; padding-right: 1%; font-size: 5.5vh;">${(x.code.length > 20 ? x.code.substring(0,20) + '...' : x.code) || " "}</h1>
			<!-- <h2 class="pre smaller inline gdButton help" title="unknown" style="margin-bottom: 2%; font-size: 3.9vh;"><span id="unknown${x.id}"></h2> -->
			<h3 class="lessSpaced" style="width: fit-content;margin-bottom: 0.1%; font-size: 3vh;">
				<img class="help valign rightSpace" src="../../assets/smallinfo.png" height="16%">Rewards: ${x.rewardscount}
			</h3>
			</div>

			
		
			<div class="center" style="position:absolute; top: ${11.5 + (y * 33.5)}%; left: 4.4%; transform:scale(0.82); height: 10%; width: 12.5%;">


				<div class="difficultyBox">
					<img class="dAlbum" id="dFace${x.id}" src="../../assets/secretVaultCodes.png" style="height:125%">
				</div>
			</div>

			<div class="center" style="position:absolute; right: 7%; transform:translateY(-13vh); height: 10%">
				<div class="modActionBox">
					<h3 class="lessSpaced" style="cursor: default;">Mod actions</h3>
						<img onclick="editApp(${page},${y})" title="Edit App" class="valign gdButton editApp" src="../../assets/editBtn.png" height="105%">
						<img onclick="deleteApp(${page},${y})" title="Delete App" class="valign gdButton delApp" src="../../assets/trash.png" height="105%">
				</div>
				<a title="View app" id="app${x.id}" onclick="${x.isAlive} > 0 ? showDevPanel(${page},${y}) : showActiveAppPanelWithRegenerateToken('${btoa(encodeURIComponent(page))}','${btoa(encodeURIComponent(y))}')" ><img style="margin-bottom: 4.5%" class="valign gdButton" src="../../assets/view.png" height="105%"></a>
			</div>

		</div>`)

	})

	$('#searchBox').append('<div style="height: 4.5%"></div>').scrollTop(0)
	$('#loading').hide()
	loading = false;
	}
	
}

let debounceTimeout;
let debounceInitTimeout;
let tabToggle;



function initLoadingEvent() {
	document.dispatchEvent(new Event('initLoadingAlert'));
}

function finishLoadingEvent() {
	changeLoadingAlert("Songs loaded!","done")
	event = new Event('finishLoadingAlert');
	
	document.dispatchEvent(event);
}

// function debounceLoadingEvent(type) {
//     if (debounceTimeout && type) {
//         clearTimeout(debounceTimeout);
//     }
// 	if (type){ debounceTimeout = setTimeout(initLoadingEvent, 1000); }
// 	else { debounceTimeout = setTimeout(finishLoadingEvent, 1000); }
// }


function copyTokenApp(id){
	navigator.clipboard.writeText(id)
            .then(function() {
				document.dispatchEvent(new Event('initLoadingAlert'));
				changeLoadingAlert("App Token copied!","done");
				setTimeout(function() {
					document.dispatchEvent(new Event('finishLoadingAlert'));
				}, 1000);
            })
            .catch(function(error) {
				changeLoadingAlert("Error copying App Token","error");
                console.error('Fatal error using navigator.clipboard:', error);
            });
}

function searchLevelSong(songID) {
	if(document.getElementById("songLevelID").getAttribute("disabled")) return
	else searchLevelsArtistRedirect(songID);
}

function showDevPanel(a,b) {
	appCache = pageCache[a][b]
	console.log(appCache);
	$('#devAppImage').prop('src', appCache.imageURLApp)
	$('#appName').text(appCache.nameApp)
	$('#appAuthor').text(appCache.developer)
	$('#devAppInfo').show();
}

function showActiveAppPanel(appName,appToken) {
	$('#appNameResult').text(appName);
	$('#appTokenResult').text(appToken);
	$('#activateApp').show();
	startActivateAppDev();
}

function regenerateAppToken(appID) {
	$('#activateAppAct').val("regenerate").attr("value", "regenerate");
	$('#activateAppID').val(appID);
	$('#activateAppToken').val(generateToken(16));
	$('#submitAppActive').trigger('click');
}

function editApp(pg, id) {
	$('#editApp').show();
	appEditCache = pageCache[pg][id]
	$('#editAppID').val(appEditCache.id)
	$('#editAppName').val(appEditCache.nameApp)
	$('#appExpdevEdit').val(appEditCache.expireDate)
	console.log(appEditCache);
}


function updateAppInfo(appID) {
	$('#activateAppAct').val("refresh").attr("value", "refresh");
	if(appID) $('#activateAppID').val(appID);
	$('#activateAppToken').val("UPDATEINFO");
	$('#submitAppActive').trigger('click');
}

function showActiveAppPanelWithRegenerateToken(idDat,idObj) {
	idDat = decodeURIComponent(atob(idDat));
	idObj = decodeURIComponent(atob(idObj));
	let currentlyData = pageCache[idDat][idObj];

	regenerateAppToken(currentlyData.id);
	showActiveAppPanel(currentlyData.nameRGApp, currentlyData.token);
}

let intervalActivateAppDev;
function startActivateAppDev() {
    intervalActivateAppDev = setInterval(function() {
        if ($('#activateApp').is(':visible')) {
            // console.log("El elemento está visible.");
			updateAppInfo(0);
        } else {
            // console.log("El elemento está oculto.");
			stopActivateAppDev();
        }
    }, 15000);
}
function stopActivateAppDev() {
    clearInterval(intervalActivateAppDev);
}



// ------- AutoScroll Song Page -------- // 
let scrollAnimationFrame;

function autoScroll(elementId, speed = 2, direction = 1) {
    const container = document.getElementById(elementId);
    const maxScrollLeft = container.scrollWidth - container.clientWidth;

    function scroll() {
        container.scrollLeft += speed * direction;
        if (container.scrollLeft >= maxScrollLeft || container.scrollLeft <= 0) direction *= -1;
        scrollAnimationFrame = requestAnimationFrame(scroll);
    }

    scroll();
}

function resetScroll(elementId) {
    cancelAnimationFrame(scrollAnimationFrame); 
    document.getElementById(elementId).scrollLeft = 0;
}


const scrollContainer = document.getElementById('appName');
scrollContainer.addEventListener('mouseenter', () => autoScroll('appName',3));
scrollContainer.addEventListener('mouseleave', () => resetScroll('appName',3));
// ------- End AutoScroll Song Page -------- // 

Append(true)


$('#pageUp').click(function() {page += 1; if (!loading) {Append(false,true); pushNewStateURL();}})
$('#pageDown').click(function() {page -= 1;  if (!loading) {Append(false,true); pushNewStateURL();}})
//$('#lastPage').click(function() {page = (pages - 1); if (!loading) Append()})
$('#pageJump').click(function() {if (loading) return; page = parseInt(($('#pageSelect').val() || 1) - 1); Append(); pushNewStateURL();})
$('#refreshPage').click(function() { Append(false, true) } )

$('#searchSongBtn').click(function() { 
	tabToggle = "";
	tabFilter = "";
	page = 0;
	path = "" + document.getElementById("searchSong").value;

	searchFilters = apiURL + `?str=` + path + "&page=[PAGE]";
	$('#header').text(decodeURIComponent(path));
	$('#tabTitle').text(decodeURIComponent(path) + " - Song Search")

	const scoreCustomTabsDiv = document.getElementById('scoreCustomTabs');
	scoreCustomTabsDiv.querySelectorAll('[id]').forEach(tab => {
    	if (tab.getAttribute("activetab") !== "disabled") tab.setAttribute("activetab", "off");
	});
	
	Append(true, true);
	pushNewStateURL();
	
	} 
)
function pushNewStateURL(){
	// window.history.replaceState(null, null, ORIGINAL_URL.slice(0,ORIGINAL_URL.lastIndexOf("?")) + searchFilters.replace("[PAGE]",page).replace(apiURL,""));
}


if (true) {
	$('body').addClass('darkBG')
	$('.cornerPiece').addClass('grayscale')
}

if (!$('#header').text()) {
	if (path != "") {
		$('#header').text(decodeURIComponent(path))
		$('#tabTitle').text(decodeURIComponent(path) + " - Song Search")
	} else
		$('#header').text("")
}


$('.closeWindow').click(function() {
	$(".popup").attr('style', 'display: none;');
})

var max = 9999
var min = 1



$('#pageSelect').on('input', function () {
    var x = $(this).val();
    if ($(this).val() != "") $(this).val(Math.max(Math.min(Math.floor(x), max), min));
});

$('#pageSelect').on('blur', function () {
    var x = $(this).val();
    if ($(this).val() != "") $(this).val(Math.max(Math.min(Math.floor(x), max), min));
});

$(document).keydown(function(k) {
	if (loading) return;

	if ($('#pageDiv').is(':visible')) {
		if (k.which == 13) $('#pageJump').trigger('click') //enter 
		else return;
	}

    if (k.which == 37 && $('#pageDown').is(":visible")) $('#pageDown').trigger('click')   // left
	if (k.which == 39 && $('#pageUp').is(":visible")) $('#pageUp').trigger('click')       // right

});

$('.submitForm').click(function() {
	document.dispatchEvent(new Event('initLoadingAlert'));

	if ( $('.box-auto').prop("checked") == false ){
		$('.box-auto').prop("checked",true);
		$('.box-auto').val("0");
	}
	
	let formJquery = $(this).closest('form');
    let form = document.getElementById(formJquery.attr('id'));

	let typeact = formJquery.find('[name="act"]').attr('value'); 

	console.log(form)
	console.log(typeact)

	// form.dispatchEvent(new Event('submit'));
    if (form.checkValidity()) {
        let formData = new FormData(form);

		console.log("submiting data", formData)

        fetch('../../api/vaultcodes.php', {
            method: 'POST',
            body: formData,
			credentials: 'include'
        })
        .then(response => {$('.box-auto').prop("checked",false); $('.box-auto').val("1"); return response.text();})
        .then(data => {
			try {
				data = JSON.parse(data); 
			} catch(err) {
				console.log("Data ERROR Response: ", data);
				console.error("Error in JSON Structure");
			}
			console.log("Data Response: ", data);
			if (data.success == "true") {
				
				if(typeact == "create") {
					changeLoadingAlert("Vault code created!","done");
					$(`#${$(this).closest('form').attr('id')}`).find('input, textarea, select').not('[name="act"]').val('');
					$(this).closest('.popup').hide();
					$('#refreshPage').trigger('click');
				} else if(typeact == "") {
					changeLoadingAlert("Token regenerated!","done");
					$('#appTokenResult').text(data.token);
				} else if(typeact == "") {
					changeLoadingAlert("App information updated!","done");
					if(data[0].isAlive >= 1) {
						$(this).closest('.popup').hide();
						$('#refreshPage').trigger('click');
						CreateFLAlert("App activated!","`g0 Application successfully activated` by `a0 developer`.\n# **Read the ObeyGDBrowser API documentation:**\n _ `a0 [ObeyGDBrowser API Docs](../../api/index.html) ` _")
					}
					
				}

				// changeLoadingAlert(`${data.message}`,"done");
				// CreateFLAlert("Song Uploaded!","Your song ID: `a0 **" + data.songID + "**`")
				// $(`#${$(this).closest('form').attr('id')}`).find('input, textarea, select').not('[name="act"]').val('');
				// $(this).closest('.popup').hide();
				setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1500);
			}
			else {
				changeLoadingAlert(`${data.error}`,"error");
			}
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1500);
			
        })
        .catch(error => {
			changeLoadingAlert(`${error}`,"error");
            console.error('Error:', error);
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1500);
        });
		
		
    } else {
		changeLoadingAlert("Data not completed!","error");
        form.reportValidity();
		setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
    }

})

</script>