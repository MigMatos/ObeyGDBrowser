<?php

	include("_init_.php");

?>


<head>
	<?php include("customEmbed.php"); ?>
	<meta charset="utf-8">
	<link href="assets/css/browser.css?v=6" type="text/css" rel="stylesheet">
    <!-- <link href="https://cdn.obeygdbot.xyz/css/dashboard.css?v=14" rel="stylesheet"> -->	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
	<?php
		
		include("./assets/htmlext/flayeralert.php");
		include("./assets/htmlext/loadingalert.php");

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

	<?php if($logged && $isAdmin) { ?> 
		<div style="position:absolute; bottom: 2%; right: 1%; text-align: right; width: 15%; display: flex;
		justify-content: center;
		flex-direction: column;
		align-items: center;">
			<p style="text-align: center;" id="updateText">OGDW Updater</p>
			<img class="gdButtonBrowser" id="updateButtonImg" src="assets/replay.png" width="40%" onclick="updateCoreWebButton()"></a>
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
		<a href="./iconkit"><img class="iconRope" src="assets/iconrope.png" width="40%"></a>
	</div> -->
	
	<div class="supercenter center" id="menuButtons" style="bottom: 5%;">
			<table>
					<tr class="menuButtonList">
						<!-- <td><a tabindex="1" href="./search/*?type=saved"><img class="menubutton menu-saved" src="assets/category-saved.png" title="Saved Levels"></a></td> -->
						
						
						<td id="gdItem21"><a tabindex="1" onclick="levelRedirect('!daily')"><img class="menubutton menu-daily" src="assets/category-daily.png" title="Daily Level"></a></td>
						<td id="gdItem21"><a tabindex="1" onclick="levelRedirect('!weekly')"><img class="menubutton menu-weekly" src="assets/category-weekly.png" title="Weekly Demon"></a></td>
						
						
						<td id="gdItem19"><a tabindex="1" onclick="urlRedirect('./songs/?')"><img class="menubutton menu-daily" src="assets/category-songs.png" title="Songs"></a></td>

						<td id="gdItem21"><a tabindex="1" onclick="urlRedirect('./gauntlets')"><img class="menubutton menu-gauntlets" src="assets/category-gauntlets.png" title="Gauntlets"></a></td>
						<!-- <td><a tabindex="1" href="./leaderboard"><img class="menubutton menu-leaderboard" src="assets/category-scores.png" title="Scores"></a></td> -->
						<?php if($logged && $isAdmin) { ?> 

						<td><a tabindex="1" onclick="urlRedirect('./moderation')"><img class="menubutton menu-daily" src="assets/category-songs.png" title="Songs" style="filter: hue-rotate(230deg);"></a></td>
						
						<?php } ?>
					</tr>
					<tr class="menuButtonList">

						<td style="display: block" id="menu_featured"><a tabindex="1" onclick="searchRedirect('0','featured')"><img class="menubutton menu-featured" src="assets/category-featured.png" title="Featured"></a></td>
						
						
						<!-- <img src="./assets/exclamation.png" style="position: absolute; height: 18%; left: 3.5%; bottom: 23%; pointer-events: none; z-index: 50;"> -->
						
						<td id="gdItem21"><a tabindex="1" onclick="searchRedirect('0','hof')"><img class="menubutton menu-hof" src="assets/category-hof.png" title="Hall Of Fame"></a></td>
						
						<td id="gdItem16"><a tabindex="1" onclick="urlRedirect('./mappacks')"><img class="menubutton menu-mappacks" src="assets/category-packs.png" title="Map Packs"></a></td>
						<td><a tabindex="1" onclick="urlRedirect('./search')"><img class="menubutton menu-search" src="assets/category-search.png" title="Search"></a></td>
					</tr>
			</table>


			<p style="color: #ffffff1f; font-size: 2.5vh;">Development in alpha, this may contain unwanted bugs.</p>
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
<script type="text/javascript" src="./misc/global.js"></script>
<script type="text/javascript" src="./misc/updater.js"></script>


<script>

let gdpsVersion = <?php echo $gdpsVersion; ?>;
let legacyServer = true;
let isAdmin = false;

<?php if ($logged && $isAdmin) {

	echo "isAdmin = true;";

} ?>



if (isAdmin) {
        setTimeout(function () {
            const event = new Event('initLoadingAlert');
            document.dispatchEvent(event);
            changeLoadingAlert(`Checking updates...`);
            checkCoreBrowser();
        }, 700);
}

function darknessPage(){
	const overlay = document.createElement('div');
    overlay.id = 'overlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'black';
    overlay.style.opacity = '0';
    overlay.style.transition = 'opacity 0.3s ease-in-out';
    overlay.style.pointerEvents = 'none';
    document.body.appendChild(overlay);
	setTimeout(function () {
    	overlay.style.opacity = '1';
	}, 100);  
}

// Check if page is cached (SAFARI ISSUE)
window.onpageshow = function(event) {
    if (event.persisted) {
		let overlayCache = document.getElementById("overlay");
        overlayCache.style.opacity = '0';
    }
};

function getAbsoluteUrl(relativeUrl) {
	if (relativeUrl.startsWith('http://') || relativeUrl.startsWith('https://')) {
        return relativeUrl;
    }
   	// const baseUrl = window.location.origin; 
    return new URL(relativeUrl, window.location.href).href; 
}


function urlRedirect(url) {
	const event = new Event('initLoadingAlert');
    document.dispatchEvent(event);

	url = getAbsoluteUrl(url)
	
	if (window.location.protocol === 'https:') { 
		url = url.replace('http:', 'https:')
	}


	fetch(url, { method: 'HEAD' })
    .then(response => {
    	if (response.ok) {
			darknessPage();
			const event = new Event('finishLoadingAlert');
			document.dispatchEvent(event);
			setTimeout(function () {
            	window.location.href = url;
			}, 500);
        } else {
			changeLoadingAlert(`Browser error code: ${response.status}`)
			setTimeout(function () {
				const event = new Event('finishLoadingAlert');
				document.dispatchEvent(event);
			}, 500);
        }
    })
    .catch(error => {
		if (window.location.protocol === 'https:' && error == "TypeError: Failed to fetch") { //FALSE HTTPS 
			changeLoadingAlert(`Warning: Redirecting with HTTP due Web host errors`);
			darknessPage();
			setTimeout(function () {
					const event = new Event('finishLoadingAlert');
					document.dispatchEvent(event);
					setTimeout(function () {
						url = url.replace('https:', 'http:')
						window.location.href = url;
					}, 500);
			}, 500);
		} else {
			changeLoadingAlert(`Browser fatal error`);
			setTimeout(function () {
					const event = new Event('finishLoadingAlert');
					document.dispatchEvent(event);
					CreateFLAlert("Fatal error in browser!","**Join our support server and report:** [![Geometry Dash](https://invidget.switchblade.xyz/EbYKSHh95B)](https://discord.gg/EbYKSHh95B) \n\n Log Error: `"+error+"`");
			}, 500);
		}
    });
}

function profileRedirect(url) {
	var queryProfile = "";
    if (legacyServer == true) {
		queryProfile = "../../profile/?u=" + (encodeURIComponent(url).replace(/%2F/gi, "") || "");
	} else {
		queryProfile = "../../profile/" + (encodeURIComponent(url).replace(/%2F/gi, "") || "") 
	}
    if (queryProfile) urlRedirect("./u/" + queryProfile);
}

function levelRedirect(url,type) {
	var queryLvl = "";


    if (legacyServer == true) {
		queryLvl = "/level/?id=" + (encodeURIComponent(url) || "0")
	} else {
		queryLvl = "/level/" + (encodeURIComponent(url) || "0")
	}

	console.log(queryLvl);

    if (queryLvl) urlRedirect("." + queryLvl);
}

function searchRedirect(url,type) {
	var queryLvl = "";

	if (legacyServer == true) {
		queryLvl = "/search/search.html?s=" + (encodeURIComponent(url) || "0")
		if (type != null) queryLvl = queryLvl + "&filter=" + type
	} else {
		queryLvl = "/search/" + (encodeURIComponent(url) || "0")
		if (type != null) queryLvl = queryLvl + "?filter=" + type
	}

	console.log(queryLvl);

	if (queryLvl) urlRedirect("." + queryLvl);
}


	$("#loading-main").hide();
	function updateCoreWebButton(){
		$("#loading-main").show();
		const event = new Event('initLoadingAlert');
		document.dispatchEvent(event);
		changeLoadingAlert("Opening updater...");
		window.location.href = "./update";
	}

	function openGDPSSettings(){
		$("#loading-main").show();
		const event = new Event('initLoadingAlert');
		document.dispatchEvent(event);
		changeLoadingAlert("Opening settings...");
		window.location.href = "./gdpsettings";
	}

	

	function checkCoreBrowser() {
		let branch = sessionStorage.getItem('branchSelected') || 0;
		if(branch == 0) branch = "latest"
		else if(branch == 1) branch = "prerelease";
		else if(branch == 2) branch = "master"
		else branch = "latest"
		fetchGithubVersion('migmatos', 'ObeyGDBrowser', branch, './update/version.txt')
		.then(result => {
			const event = new Event('finishLoadingAlert');
			document.dispatchEvent(event);
			if (result.data) {
				let element = document.getElementById("updateText");
				let imgElement = document.getElementById("updateButtonImg");
				if (result.currentVersion != result.data.tag_name) {
					imgElement.style.filter = "hue-rotate(320deg)";
					imgElement.style.mixBlendMode = "unset";
					imgElement.classList.add("spin");
					element.innerHTML = "<cg><b>NEW UPDATE AVAILABLE!</b></cg>";
				} else {
					imgElement.style.filter = "unset";
					imgElement.style.mixBlendMode = "";
					imgElement.classList.remove("spin");
					element.innerHTML = "OGDBW Updater";
				}
			}
		});

	}

	function showCredits() {
		$creditsDesc = "# `g0 ** Developers ** ` \n- **MigMatos:** Developer of ObeyGDBrowser \n- **GD Colon:** Original developer of GDBrowser \n\n# `g0 ** Special Thanks ** ` \n- **RobTop:** Developer for Geometry Dash!\n- **OsitaLolita:** Ideas and feedback! <3 \n\n# `g0 ** Dev Helpers **` \n- **gdNoxi**: _Partial Gauntlets API_. \n\n# `g0 ** Bug Finders ** ` \n- Unix \n- NitroRMX \n- Karmagmr0\n- LostShadowGD\n- uproxide\n- M366\n- YeahhColix \n- Janix"
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
<script type="text/javascript" src="./misc/versionadapter.js"></script>