<?php

	include("../_init_.php");

?>


<head>
	<?php include("../customEmbed.php"); ?>
	<meta charset="utf-8">
	<link href="../assets/css/browser.css?v=6" type="text/css" rel="stylesheet">
    <!-- <link href="https://migmatos.alwaysdata.net/legacy/cdn/css/dashboard.css?v=14" rel="stylesheet"> -->	
	<?php
		
		include("../assets/htmlext/flayeralert.php");
		include("../assets/htmlext/loadingalert.php");

    ?>

</head>
<style>
	.gdButtonBrowser {
		cursor: pointer;
	}

</style>

<body class="levelBG" style="background: linear-gradient(to bottom, #76153f, #370016)" onbeforeunload="saveUrl()">

<div id="everything" >

	<div class="popup" id="credits">
	</div>

	<div style="position:absolute; bottom: 0%; left: 0%; width: 100%; pointer-events: none;     filter: hue-rotate(103deg) brightness(0.2)">
		<img class="cornerPiece" src="../assets/corner.png" width=7%;>
	</div>

	<div style="position:absolute; top: 0%; left: 0%; width: 100%; pointer-events: none;     filter: hue-rotate(103deg) brightness(0.2)">
		<img class="cornerPiece" src="../assets/corner.png" width=7%; style="transform: scaleY(-1)">
	</div>

	<div style="position:absolute; top: 2%; left: 1.5%; width: 10%; height: 25%; pointer-events: none">
		<img class="gdButton yesClick" id="backButton" src="../assets/back.png" height="30%" onclick="backButton()">
	</div>
	
	

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
						
						
						<td><a tabindex="1" onclick="locked()"><img class="menubutton menu-roles" src="../assets/mod-roles.png" title="Create mod roles!"></a></td>
						<td><a tabindex="1" onclick="locked()"><img class="menubutton menu-webhooks" src="../assets/mod-webhooks.png" title="Create webhooks!"></a></td>
						<td><a tabindex="1" onclick="urlRedirect('./devapps/')"><img class="menubutton menu-developerapps" src="../assets/mod-devapps.png" title="Add developer apps!"></a></td>
						<td><a tabindex="1" onclick="urlRedirect('./vaultcodes/')"><img class="menubutton menu-vaultcodes" src="../assets/mod-vaultcodes.png" title="Add vault codes!"></a></td>
						

					</tr>
					<tr class="menuButtonList">
						<img src="../assets/exclamation.png" style="position: absolute; height: 18%; left: 3.5%; bottom: 23%; pointer-events: none; z-index: 50;">
						
						<td><a style="filter: hue-rotate(120deg);" tabindex="1" onclick="urlRedirect('../search/search.php?s=*&filter=magic&noStar=1&header=Rate%20Levels!&modreq')"><img class="menubutton menu-search" src="../assets/category-search.png" title="Search"></a></td>
					</tr>
			</table>



	</div>

	<!-- <div style="position:absolute; bottom: 17%; right: 7%; width: 9%; text-align: right; pointer-events: none">
		<img src="assets/privateservers.png" width=85%;">
	</div>

	<div style="position:absolute; bottom: 2.5%; right: 1.5%; text-align: right; width: 18%;">
		<a href="../gdps" title="GD Private Servers"><img class="gdButton" src="assets/basement.png" width="40%"></a>
	</div>

	 -->

	
  

	<div class="center" width="100%" style="margin-top: 2%">
    	<img src="../assets/logomoderator.png" height="11.5%"><br>
    	<img id="browserlogo" src="../<?php echo isset($gdps_settings["gdps_level_browser_logo_url"]) ? $gdps_settings["gdps_level_browser_logo_url"] : 'assets/browser.png'; ?>" height="7%" style="margin: 0.5% 0% 0% 30%">
	</div>



</div>

</body>
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="../misc/global.js"></script>
<script type="text/javascript" src="../misc/updater.js"></script>
<script type="text/javascript" src="../misc/gdcustomframe.js"></script>

<script>
let userNameUser = "<?php echo $userName; ?>"
let isLoggedUser = "<?php echo $logged; ?>"
let accountID = "<?php echo $accountID ?>" ;

function openProfle() {
	
	if(isLoggedUser == "1") {
		openGdCustomFrame("./profile/?u="+accountID+"&gdframe");
	} else {
		openGdCustomFrame('./account/checkLogin.php');
	}
}

</script>

<script>

let gdpsVersion = <?php echo $gdpsVersion; ?>;
let legacyServer = true;
let isAdmin = false;

<?php if ($logged && $isAdmin) {

	echo "isAdmin = true;";

} ?>





function locked() {
	CreateFLAlert("Wait!!!","# This feature will be **available on January 28.**\nWe're making sure `a0 **this feature works perfectly**` `r0 (and without bugs)` before its big launch! ✨\n\n**Join our support server and get news!** [![Geometry Dash](https://invidget.switchblade.xyz/EbYKSHh95B)](https://discord.gg/EbYKSHh95B)");
}


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
		queryLvl = "/search/search.php?s=" + (encodeURIComponent(url) || "0")
		if (type != null) queryLvl = queryLvl + "&filter=" + type
	} else {
		queryLvl = "/search/" + (encodeURIComponent(url) || "0")
		if (type != null) queryLvl = queryLvl + "?filter=" + type
	}

	console.log(queryLvl);

	if (queryLvl) urlRedirect("." + queryLvl);
}


	$("#loading-main").hide();


	/* Legacy code for 0.27.1 */

	let alertValue = (new URLSearchParams(window.location.search)).get("alert");
	if (alertValue == "installed"){
		let newURLpush = window.location.href.replace(new RegExp(`(\\?alert=${alertValue})`), '');
		window.history.pushState(null, null, newURLpush);
		CreateFLAlert("ObeyGDBrowser 1.0","# Update installed successfully! \n## `r0 If you are a GDPSFH user, you must wait up to **one hour to see the changes** from the update.`\n")
	}

</script>


<script>

let page = 1
<?php if (isset($gdps_settings["disable_colored_texture_level_browser"]) && $gdps_settings["disable_colored_texture_level_browser"] == 1): ?>
    $('#browserlogo').css('filter', `hue-rotate(${Math.floor(Math.random() * (330 - 60)) + 60}deg) saturate(${Math.floor(Math.random() * (150 - 100)) + 100}%)`);
<?php endif; ?>
let xButtonPos = '43%'
let lastPage


</script>
<script type="text/javascript" src="../misc/versionadapter.js"></script>
