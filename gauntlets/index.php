<?php include("../_init_.php"); ?>
<!doctype html>
<html>
<head>
	<title>Gauntlets</title>
	<meta charset="utf-8">
	<link href="../assets/css/browser.css" type="text/css" rel="stylesheet">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<link rel="icon" href="../assets/gauntlet.png">
	<meta id="meta-title" property="og:title" content="Gauntlets">
	<meta id="meta-desc" property="og:description" content="Because RobTop wanted to leave behind the monstrosity that is Map Packs.">
	<meta id="meta-image" name="og:image" itemprop="image" content="https://gdbrowser.com/assets/gauntlet.png">
	<meta name="twitter:card" content="summary">

	<script>
		function gauntletErrorImg(img) {
			img.src = "../assets/gauntlets/1.png";
			img.style.filter = 'grayscale(100%)';
		}
	</script>
</head>

<?php include("../assets/htmlext/flayeralert.php"); ?>
<?php include("../assets/htmlext/loadingalert.php"); ?>

<style>
	input.inputmaps {
		margin-left: 3vh;
		height: 8.5%;
		font-size: 3vh;
	}

	.loading-main {
		display: none;
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

	.smallMapDivIcon {
		width: 3vh;
		margin-right: 1vh;
	}

</style>

<body class="levelBG darkBG" onbeforeunload="saveUrl()">

<div id="everything" class="center" style="width: 100%; height: 100%;">

	<div class="center" width="100%" style="margin-top: 1.2%; margin-bottom: 1%;">
		<img src="../assets/gauntlets.png" width="50%">
	</div>

	<br>
	
</div>
</body>
<script type="text/javascript" src="../misc/gdcustomframe.js"></script>

<script>

let pages = 0;
let page = 1;
let loading = true;
let pageCache = null;


function viewGauntlets() {
	openGdCustomFrame(`./viewer.php`,true);
}

// Loading gauntlets;
viewGauntlets();


// function checkPage(toggle) {

// 	if (page <= 1) $('#pageDown').hide()
// 	else $('#pageDown').show()

// 	console.log("page", page, "  -  pages", pages);

// 	if (page >= pages) $('#pageUp').hide()
// 	else $('#pageUp').show()

// 	$(`#gauntletPage-${page}`).addClass("show");
// 	$(`#gauntletPage-${page}`).removeClass("hide");
	

// 	if(toggle){ 
// 		$(`#gauntletPage-${page+1}`).toggleClass("show"); 
// 		$(`#gauntletPage-${page+1}`).toggleClass("hide"); 
// 	}
// 	else {
// 		$(`#gauntletPage-${page-1}`).toggleClass("show");
// 		$(`#gauntletPage-${page-1}`).toggleClass("hide");
// 	}
	
// }

// $(document).keydown(function(k) {
// 	if (loading) return;

// 	// if ($('#pageDiv').is(':visible')) {
// 	// 	if (k.which == 13) $('#pageJump').trigger('click') //enter 
// 	// 	else return;
// 	// }

//     // if (k.which == 37 && $('#pageDown').is(":visible")) $('#pageDown').trigger('click')   // left
// 	// if (k.which == 39 && $('#pageUp').is(":visible")) $('#pageUp').trigger('click')       // right

// });


</script>
</html>