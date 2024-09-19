<?php include("../_init_.php"); ?>

<head>
	<title>Gauntlets</title>
	<meta charset="utf-8">
	<link href="../assets/css/browser.css" type="text/css" rel="stylesheet">
	<link rel="icon" href="../assets/gauntlet.png">
	<meta id="meta-title" property="og:title" content="Gauntlets">
	<meta id="meta-desc" property="og:description" content="Because RobTop wanted to leave behind the monstrosity that is Map Packs.">
	<meta id="meta-image" name="og:image" itemprop="image" content="https://gdbrowser.com/assets/gauntlet.png">
	<meta name="twitter:card" content="summary">
</head>

<body class="levelBG darkBG" style="overflow-y:auto;" onbeforeunload="saveUrl()">

<div id="everything" class="center" style="width: 100%; height: 100%;">

	<div style="position:absolute; top: 2%; left: -1.95%; width: 10%; height: 25%; pointer-events: none">
		<img class="gdButton yesClick" id="backButton" src="../assets/back.png" height="30%" onclick="backButton()">
	</div>

	<div class="center" width="100%" style="margin-top: 2.5%; margin-bottom: 1%;">
		<img src="../assets/gauntlets.png" width="50%">
	</div>

	<img id="loading" style="margin-top: 1%" class="spin noSelect" src="../assets/loading.png" height="12%">

	<div id="gauntletList" style="    flex-wrap: wrap;">
		<br>
	</div>

	<br>
	
</div>
</body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="../misc/global.js"></script>
<script type="text/javascript" src="../misc/tintheximg.js"></script>

<script>

fetch('../api/gauntlets.php').then(res => res.json()).then(gauntlets => {
	
	$('#loading').hide()

	// $('#gauntletList').append('<div class="gauntlet-page"></div>') 
	
	gauntlets.forEach((x, y) => {


		$('#gauntletList').append(`

			<a onclick="redirectGauntlet('${x.levels}','${x.gauntlet.name}')">
	
			<div class="gauntlet invisibleBox" style="color: ${x.gauntlet.textColor ? x.gauntlet.textColor : '#ffffff'}; background-color: ${x.gauntlet.bgColor ? x.gauntlet.bgColor : '#c8c8c8'};">
			
			
			

			<h3 class="gauntletTitle">${x.gauntlet.name}<br>Gauntlet</h3><br>

			<img class="gauntlet icon" src="../assets/gauntlets/${x.id}.png"><br>
			
			</div></a>`)
		

	})

	// applyHexImgTint()
});


let serverType = "<?php print_r($serverType); ?>";

function redirectGauntlet(url, header) {
	var queryLvl = "";
    if (serverType == "legacy") {
		queryLvl = "/search/search.html?s=" + (url || "0") + "&list"
	} else {
		queryLvl = "/search/" + (url || "0") + "?list"
	}
    if (queryLvl) window.location.href = ".." + queryLvl + "&header=" + header + "%20Gauntlet levels";
}




</script>