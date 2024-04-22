<?php

	include("_init_.php");

?>


<head>
	<title>Geometry Dash Browser!</title>
	<meta charset="utf-8">
	<link href="assets/css/browser.css" type="text/css" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135255146-3"></script><script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-135255146-3');</script>
	<link rel="icon" href="assets/coin.png">
	<meta id="meta-title" property="og:title" content="Geometry Dash Browser!">
	<meta id="meta-desc" property="og:description" content="Browse all of Geometry Dash's online features, right from this handy little website! Levels, profiles, leaderboards, comments, and more!">
	<meta id="meta-image" name="og:image" content="https://gdbrowser.com/assets/coin.png" itemprop="image">
	<meta name="twitter:card" content="summary">

	<link href="https://cdn.obeygdbot.xyz/css/dashboard.css?v=14" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
	<?php 
        echo file_get_contents("https://cdn.obeygdbot.xyz/htmlext/loadingalert.html");
        echo file_get_contents("https://cdn.obeygdbot.xyz/htmlext/flayeralert.html");
    ?>

</head>


<body class="levelBG" onbeforeunload="saveUrl()">

<div id="everything">

	<div class="popup" id="credits">
	</div>

	<div style="position:absolute; bottom: 0%; left: 0%; width: 100%; pointer-events: none">
		<img class="cornerPiece" src="assets/corner.png" width=7%;>
	</div>

	<div style="position:absolute; top: 0%; left: 0%; width: 100%; pointer-events: none">
		<img class="cornerPiece" src="assets/corner.png" width=7%; style="transform: scaleY(-1)">
	</div>

	<div style="position:absolute; top: 1.7%; right: 2%; text-align: right; width: 10%;">
		<img id="creditsButton" class="gdButtonBrowser" src="assets/credits.png" width="60%" onclick="showCredits()">
	</div>

	

	<div style="position: absolute;
    bottom: 10.5%;
    display: flex;
	left: -2%;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    align-content: center;
    flex-direction: column;
	width: 15%;">
	<p>
		<?php if(!$logged) echo 'Login here!'; else echo $userName; ?>
	</p>
		<a href="./account/login" style="width:30%;"><img class="gdButtonBrowser" src="assets/user.png" width = "100%"></a>
	</div>

	<?php if($logged && $isAdmin) {
		?> 
		<div style="position:absolute; bottom: 2%; right: 1%; text-align: right; width: 15%; display: flex;
		justify-content: center;
		flex-direction: column;
		align-items: center;">
			<p style="text-align: center;">Click here to check updates!</p>
			<img class="gdButtonBrowser" src="assets/plus.png" width="40%" onclick="updateCoreWebButton()"></a>
		</div>; 

		<div style="position:absolute; bottom: 27%; right: 1%; text-align: right; width: 15%; display: flex;
		justify-content: center;
		flex-direction: column;
		align-items: center;">
			<p style="text-align: center;">GDPS Settings</p>
			<img class="gdButtonBrowser" src="assets/edit.png" width="40%" onclick="openGDPSSettings()"></a>
		</div>; 
		<?php
	} ?>
	

	<!-- <div class="menu-achievements" style="position:absolute; top: 5.5%; left: 3%; width: 12%;">
		<a href="../achievements"><img class="gdButton" src="assets/achievements.png" width="40%"></a>
	</div>

	<div class="menu-messages" style="position:absolute; top: -1.7%; left: 11%; text-align: left; width: 10%;">
		<a href="../messages"><img class="iconRope" src="assets/messagerope.png" width="40%"></a>
	</div>

	<div style="position:absolute; top: -1.5%; right: 10%; text-align: right; width: 10%;">
		<a href="../iconkit"><img class="iconRope" src="assets/iconrope.png" width="40%"></a>
	</div> -->
	
	<div class="supercenter center" id="menuButtons" style="bottom: 5%;">
			<table>
					<tr class="menuButtonList">
						<!-- <td><a tabindex="1" href="./search/*?type=saved"><img class="menubutton menu-saved" src="assets/category-saved.png" title="Saved Levels"></a></td> -->
						
						<?php if ($gdpsVersion > 20) { ?>
						<td><a tabindex="1" href="./level?id=!daily"><img class="menubutton menu-daily" src="assets/category-daily.png" title="Daily Level"></a></td>
						<td style="display: block" id="menu_weekly"><a tabindex="1" href="./level?id=!weekly"><img class="menubutton menu-weekly" src="assets/category-weekly.png" title="Weekly Demon"></a></td>
						<?php } else { ?>
						<td style="display: block" id="menu_featured"><a tabindex="1" href="./lvls?levelName=*?type=featured"><img class="menubutton menu-featured" src="assets/category-featured.png" title="Featured"></a></td>
						<?php } ?>
						<!-- <td><a tabindex="1" href="./gauntlets"><img class="menubutton menu-gauntlets" src="assets/category-gauntlets.png" title="Gauntlets"></a></td> -->
					</tr>
					<tr class="menuButtonList">
						<!-- <td><a tabindex="1" href="./leaderboard"><img class="menubutton menu-leaderboard" src="assets/category-scores.png" title="Scores"></a></td> -->
						<!-- <img src="./assets/exclamation.png" style="position: absolute; height: 18%; left: 3.5%; bottom: 23%; pointer-events: none; z-index: 50;"> -->
						<?php if ($gdpsVersion > 20) { ?>
						<td><a tabindex="1" href="./lvls?levelName=*&type=hof"><img class="menubutton menu-hof" src="assets/category-hof.png" title="Hall Of Fame"></a></td>
						<?php } ?>
						<!-- <td><a tabindex="1" href="./mappacks"><img class="menubutton menu-mappacks" src="assets/category-packs.png" title="Map Packs"></a></td> -->
						<td><a tabindex="1" href="./search"><img class="menubutton menu-search" src="assets/category-search.png" title="Search"></a></td>
					</tr>
			</table>


			<p style="color: #ffffff1f; font-size: 2.5vh;">Development in beta, this may contain unwanted bugs.</p>
	</div>

	<!-- <div style="position:absolute; bottom: 17%; right: 7%; width: 9%; text-align: right; pointer-events: none">
		<img src="assets/privateservers.png" width=85%;">
	</div>

	<div style="position:absolute; bottom: 2.5%; right: 1.5%; text-align: right; width: 18%;">
		<a href="../gdps" title="GD Private Servers"><img class="gdButton" src="assets/basement.png" width="40%"></a>
	</div>

	 -->

	
  

	<div class="center" width="100%" style="margin-top: 2%">
    	<img src="<?php echo isset($gdps_settings["gdps_logo_url"]) ? $gdps_settings["gdps_logo_url"] : 'assets/gdlogo.png'; ?>" height="11.5%"><br>
    	<img id="browserlogo" src="<?php echo isset($gdps_settings["gdps_level_browser_logo_url"]) ? $gdps_settings["gdps_level_browser_logo_url"] : 'assets/browser.png'; ?>" height="7%" style="margin: 0.5% 0% 0% 30%">
	</div>

	<div id="noDaily" style="display: none;">
		<div class="copied center noClick" style="position:absolute; top: 29%; left: 50%; transform: translate(-50%,-50%); width: 90vh; background-color: rgba(0, 0, 0, 0.7);">
			<h1 class="smaller noSelect">No active <span id="noLevel">daily</span> level!</h1>
		</div>
	</div>

</div>

</body>
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="./misc/sizecheck.js"></script>

<script>
	$("#loading-main").hide();
	function updateCoreWebButton(){
		$("#loading-main").show();
		const event = new Event('initLoadingAlert');
		document.dispatchEvent(event);
		changeLoadingAlert("Checking and updating...");
		window.location.href = "./update";
	}

	function openGDPSSettings(){
		$("#loading-main").show();
		const event = new Event('initLoadingAlert');
		document.dispatchEvent(event);
		changeLoadingAlert("Opening settings...");
		window.location.href = "./gdpsettings";
	}


	let alertValue = (new URLSearchParams(window.location.search)).get("alert");
	if (alertValue == "installed"){
		let newURLpush = window.location.href.replace(new RegExp(`(\\?alert=${alertValue})`), '');
		window.history.pushState(null, null, newURLpush);
		fetch(`https://api.github.com/repos/migmatos/ObeyGDBrowser/releases/latest`)
		.then(response => response.json())
		.then(data => {
			if (data.body) {
				$releaseNotesDescription = "# `g0 **" + data.name + "** ` \n\n" + data.body;
				CreateFLAlert("Updated to last version!",$releaseNotesDescription)
			} else {
				console.log('Error: No release notes found.');
				CreateFLAlert("Updated!","ObeyGDBrowser has been updated to last version!");
			}
		})
		.catch(error => {
			console.log("Error: Failed fetching release notes from github, debug: ", error);
			CreateFLAlert("Updated!","ObeyGDBrowser has been updated to last version!");
		}
		);
	}
	else if (alertValue == "lasted"){
		let newURLpush = window.location.href.replace(new RegExp(`(\\?alert=${alertValue})`), '');
		window.history.pushState(null, null, newURLpush);
		CreateFLAlert("Without updates!","No updates available\n\n **Join our support server:** [![Geometry Dash](https://invidget.switchblade.xyz/EbYKSHh95B)](https://discord.gg/EbYKSHh95B)");
	}
	else if (alertValue == "failedinstall"){
		let newURLpush = window.location.href.replace(new RegExp(`(\\?alert=${alertValue})`), '');
		window.history.pushState(null, null, newURLpush);
		CreateFLAlert("Failed Installing!","Report in the Discord Support Server or Github!\n\n **Join our support server:** [![Geometry Dash](https://invidget.switchblade.xyz/EbYKSHh95B)](https://discord.gg/EbYKSHh95B)");
	}

	function showCredits() {
		$creditsDesc = "# `g0 ** Developers ** ` \n- **MigMatos:** Developer of ObeyGDBrowser \n- **GD Colon:** Original developer of GDBrowser \n\n# `g0 ** Special Thanks ** ` \n- **Robtop:** Developer for Geometry dash! \n\n# `g0 ** Bug Finders ** ` \n- Unix \n- NitroRMX \n- Karmagmr0\n- LostShadowGD"
		CreateFLAlert("Credits!",$creditsDesc);
	}

	

</script>


<script>

let page = 1
<?php if (isset($gdps_settings["disable_colored_texture_level_browser"]) && $gdps_settings["disable_colored_texture_level_browser"] == 1): ?>
    $('#browserlogo').css('filter', `hue-rotate(${Math.floor(Math.random() * (330 - 60)) + 60}deg) saturate(${Math.floor(Math.random() * (150 - 100)) + 100}%)`);
<?php endif; ?>
let xButtonPos = '43%'
let lastPage

let noDaily = (window.location.search == "?daily=1")
let noWeekly = (window.location.search == "?daily=2")


if (noDaily || noWeekly) {
	if (noWeekly) $('#noLevel').html("weekly")
	$('#noDaily').fadeIn(200).delay(500).fadeOut(500)
	let newURLpush = window.location.href.replace(/(\?daily=1|\?daily=2)/g, '');
	window.history.pushState(null, null, newURLpush);
}





</script>
