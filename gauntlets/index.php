<?php include("../_init_.php"); ?>

<head>
	<title>Gauntlets</title>
	<meta charset="utf-8">
	<link href="../assets/css/browser.css" type="text/css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../assets/gauntlet.png">
	<meta id="meta-title" property="og:title" content="Gauntlets">
	<meta id="meta-desc" property="og:description" content="Because RobTop wanted to leave behind the monstrosity that is Map Packs.">
	<meta id="meta-image" name="og:image" itemprop="image" content="https://gdbrowser.com/assets/gauntlet.png">
	<meta name="twitter:card" content="summary">
</head>

<body class="levelBG darkBG" onbeforeunload="saveUrl()">

<div id="everything" class="center" style="width: 100%; height: 100%;">

	<div style="position:absolute; top: 2%; left: -1.95%; width: 10%; height: 25%; pointer-events: none">
		<img class="gdButton yesClick" id="backButton" src="../assets/back.png" height="30%" onclick="backButton()">
	</div>

	<div class="center" width="100%" style="margin-top: 1.2%; margin-bottom: 1%;">
		<img src="../assets/gauntlets.png" width="50%">
	</div>

	<img id="loading" style="margin-top: 1%" class="spin noSelect" src="../assets/loading.png" height="12%">

	<div style="position: absolute; left: 2%; top: 45%; height: 10%;">
		<img class="gdButton" id="pageDown" style="display: none" src="../assets/whitearrow-left.png" height="90%">
	</div>

	<div style="position: absolute; right: 2%; top: 45%; height: 10%;">
		<img class="gdButton" id="pageUp" style="display: none" src="../assets/whitearrow-right.png" height="90%">
	</div>

	<div class="supercenter">
		<div id="gauntletList">
			<br>
		</div>
	</div>
	<br>
	
</div>
</body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="../misc/global.js"></script>
<script type="text/javascript" src="../misc/tintheximg.js"></script>

<script>

let pages = 0;
let page = 1;
let loading = true;
fetch('../api/gauntlets.php').then(res => res.json()).then(gauntlets => {
	
	$('#loading').hide()

	let gCounter = 0;
	pages = gauntlets[0].pages ?? 0;

	

	console.log(pages);
	// $('#gauntletList').append('<div class="gauntlet-page"></div>') 
	
	gauntlets.forEach((x, y) => {

		console.log(y);

		if ((y) % 3 === 0 || y == 0) {
			console.log(`Ciclo: ${y + 1}`);
			gCounter += 1;
			$('<div>', { id: `gauntletPage-${gCounter}`, class: "gauntletPage" }).appendTo('#gauntletList');
			
		}


		console.log(`#gauntletPage-${gCounter}`);

		$(`#gauntletPage-${gCounter}`).append(`

			<a onclick="redirectGauntlet('${x.levels}','${x.gauntlet.name}')">
	
			<div class="gauntlet invisibleBox" style="color: ${x.gauntlet.textColor ? x.gauntlet.textColor : '#ffffff'}; background-color: ${x.gauntlet.bgColor ? x.gauntlet.bgColor : '#c8c8c8'};">
			
			<h3 class="gauntletTitle">${x.gauntlet.name}<br>Gauntlet</h3><br>

			<img class="gauntlet icon" onerror="gauntletErrorImg(this)" src="../assets/gauntlets/${x.id}.png"><br>
			
			</div></a>`)
	})

	if(pages > 0) {
		$("#pageUp").show();
		$("#gauntletPage-1").addClass("show");
	}
	$('#loading').hide()
	loading = false;
});

$('#pageUp').click(function() {
	page += 1;
	checkPage(false);
});

$('#pageDown').click(function() {
	page -= 1;
	checkPage(true);
});

function checkPage(toggle) {
	console.log(page);
	if (page <= 1) $('#pageDown').hide()
	else $('#pageDown').show()
	if (page+1 >= pages) $('#pageUp').hide()
	else $('#pageUp').show()

	$(`#gauntletPage-${page}`).addClass("show");
	$(`#gauntletPage-${page}`).removeClass("hide");
	

	if(toggle){ 
		$(`#gauntletPage-${page+1}`).toggleClass("show"); 
		$(`#gauntletPage-${page+1}`).toggleClass("hide"); 
	}
	else {
		$(`#gauntletPage-${page-1}`).toggleClass("show");
		$(`#gauntletPage-${page-1}`).toggleClass("hide");
	}
	
}

$(document).keydown(function(k) {
	if (loading) return;

	console.log(page);
	// if ($('#pageDiv').is(':visible')) {
	// 	if (k.which == 13) $('#pageJump').trigger('click') //enter 
	// 	else return;
	// }

    if (k.which == 37 && $('#pageDown').is(":visible")) $('#pageDown').trigger('click')   // left
	if (k.which == 39 && $('#pageUp').is(":visible")) $('#pageUp').trigger('click')       // right

});

let serverType = "<?php print_r($serverType); ?>";

function redirectGauntlet(url, header) {
	var queryLvl = "";
    if (serverType == "legacy") {
		queryLvl = "/search/search.html?s=" + (url || "0") + "&list"
	} else {
		queryLvl = "/search/" + (url || "0") + "?list"
	}
    if (queryLvl) window.location.href = ".." + queryLvl + "&header=" + header + "%20Gauntlet%20levels";
}

function gauntletErrorImg(img) {
	img.src = "../assets/gauntlets/1.png";
	img.style.filter = 'grayscale(100%)';
}

</script>