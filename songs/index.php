<?php include("../_init_.php"); ?>

<head>
	<title id="tabTitle">Song Search</title>
	<meta charset="utf-8">
	<link href="../assets/css/browser.css?v=1" type="text/css" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135255146-3"></script><script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-135255146-3');</script>
	<link rel="icon" href="../assets/song/disc.png">
	<meta id="meta-title" property="og:title" content="Song Search">
	<meta id="meta-desc" property="og:description" content="Search for Geometry Dash levels, and filter by length, difficulty, song + more!">
	<meta id="meta-image" name="og:image" itemprop="image" content="../assets/song/disc.png">
	<meta name="twitter:card" content="summary">

</head>

<body class="levelBG" onbeforeunload="saveUrl()">

<div id="everything" style="overflow: auto;">

	<div class="popup" id="pageDiv">
		<div class="brownbox bounce center supercenter" style="width: 60vh; height: 34%">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Jump to Page</h2>
			<input type="number" id="pageSelect" placeholder="1"><br>
			<img src="../assets/ok.png" height=20%; id="pageJump" class="gdButton center closeWindow">
			<img class="closeWindow gdButton" src="../assets/close.png" height="25%" style="position: absolute; top: -13.5%; left: -6vh">

			<div class="supercenter" style="left: 25%; top: 43%; height: 10%;">
				<img class="gdButton" src="../assets/whitearrow-left.png" height="160%" onclick="$('#pageSelect').val(parseInt($('#pageSelect').val() || 0) - 1); $('#pageSelect').trigger('input');">
			</div>
		
			<div class="supercenter" style="left: 75%; top: 43%; height: 10%;">
				<img class="gdButton" src="../assets/whitearrow-right.png" height="160%" onclick="$('#pageSelect').val(parseInt($('#pageSelect').val() || 0) + 1); $('#pageSelect').trigger('input');">
			</div>
		</div>
	</div>


	<div class="popup" id="searchDiv">
		<div class="brownbox bounce center supercenter" style="width: 60vh; height: 34%">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Search Song</h2>
			<input type="text" id="searchSong" placeholder="Search!" style="width:85%; margin: 8% 0% 8% 0%; height: 25%; text-align: center;"><br>
			<img src="../assets/ok.png" height=20%; id="searchSongBtn" class="gdButton center closeWindow">
			<img class="closeWindow gdButton" src="../assets/close.png" height="25%" style="position: absolute; top: -13.5%; left: -6vh">
		</div>
	</div>

	<div class="popup" id="songInfo">
		<div class="brownbox bounce center supercenter" style="width: 60vh; height: 34%">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%" id="songName">?</h2>
			
			<div class="supercenter" style="top: 43%; height: 10%;">
			<audio controls src="" id="songLink"></audio>
			</div>

			<!-- <div style="left: 25%; top: 80%; height: 100%;">
				<h2 class="smaller" id="songCount">level(s) </h2> <img title="level(s) using this song" src="../assets/song/views.png" height="10%">
			</div> -->


			
			<img class="closeWindow gdButton" src="../assets/close.png" height="25%" style="position: absolute; top: -13.5%; left: -6vh">

			
		
		</div>
	</div>


	<div class="popup" id="purgeDiv">
		<div class="fancybox bounce center supercenter" style="width: 35%; height: 28%">
			<h2 class="smaller center" style="font-size: 5.5vh">Delete All</h2>
			<p class="bigger center" style="line-height: 5vh; margin-top: 1.5vh;">
				Delete all saved online levels?<br><cy>Levels will be cleared from your browser.</cy>
			</p>
			<img src="../assets/btn-cancel-green.png" height=25%; class="gdButton center closeWindow">
			<img src="../assets/btn-delete.png" height=25%; id="purgeSaved" class="gdButton center sideSpaceB">
		</div>
	</div>

	<div class="popup" id="shuffleDiv">
		<div class="fancybox bounce center supercenter">
			<h2 class="smaller center" style="font-size: 5.5vh">Random Level</h2>
			<p class="bigger center" id="levelInfo" style="line-height: 5vh; margin-top: 1.5vh;">
				A random level cannot be picked with your current <cy>search filters!</cy>
				This is because there is no way to tell how many results were found, due to the GD servers inaccurately saying there's <cg>9999</cg>.
			</p>
			<img src="../assets/ok.png" width=20%; class="gdButton center closeWindow">
		</div>
	</div>

	<div style="position:absolute; bottom: 0%; left: 0%; width: 100%">
		<img class="cornerPiece" src="../assets/corner.png" width=7%;>
	</div>

	<div style="position:absolute; bottom: 0%; right: 0%; width: 100%; text-align: right;">
		<img class="cornerPiece" src="../assets/corner.png" width=7%; style="transform: scaleX(-1)">
	</div>

	<div id="searchBox" class="supercenter dragscroll">
		<div style="height: 4.5%"></div>
	</div>
	
	<div class="epicbox supercenter gs" style="width: 120vh; height: 80%; pointer-events: none;"></div>

	<div class="center" style="position:absolute; top: 8%; left: 0%; right: 0%">
		<h1 id="header"></h1>
	</div>

	<div style="text-align: right; position:absolute; top: 1%; right: 2%">
		<h2 class="smaller" style="font-size: 4.5vh" id="pagenum"></h2>
	</div>

	<div title="Search Song" style="text-align: right; position:absolute; top: 7.5%; right: 2%; height: 12%;">
		<img src="../assets/magnify.png" height="60%" class="gdButton" style="margin-top: 5%" onclick="$('#searchDiv').show();">
	</div>

	<div title="Jump to page" style="text-align: right; position:absolute; top: 15.5%; right: 1.5%; height: 11%;">
		<img src="../assets/double-arrow.png" height="60%" class="gdButton" style="margin-top: 5%" onclick="$('#pageDiv').show(); $('#pageSelect').focus().select()">
	</div>

	<div style="position:absolute; top: 2%; left: 1.5%; width: 10%; height: 25%; pointer-events: none">
		<img class="gdButton yesClick" id="backButton" src="../assets/back.png" height="30%" onclick="backButton()">
	</div>

	<div id="purge" style="position:absolute; bottom: 1%; right: -3%; width: 10%; display:none;">
		<img class="gdButton" src="../assets/delete.png" width="60%" onclick="$('#purgeDiv').show()">
	</div>

	<div style="position:absolute; bottom: 2%; right: 1%; text-align: right; width: 15%;">
		<img class="gdButton" src="../assets/refresh.png" width="40%" id="refreshPage"></a>
	</div>

	<div style="position:absolute; bottom: 2%; right: 8.5%; text-align: right; width: 15%; display: none" id="gdWorld">
		<a title="Geometry Dash World" href="/search/*?type=gdw"><img class="gdButton" src="../assets/gdw_circle.png" width="40%"></a>
	</div>

	<div style="position:absolute; bottom: 2%; right: 8.5%; text-align: right; width: 15%; display: none" id="normalGD">
		<a title="Back to Geometry Dash" href="/search/*?type=featured"><img class="gdButton" src="../assets/gd_circle.png" width="40%"></a>
	</div>

	<div style="position: absolute; left: 7%; top: 45%; height: 10%;">
		<img class="gdButton" id="pageDown" style="display: none"; src="../assets/arrow-left.png" height="90%">
	</div>

	<div style="position: absolute; right: 7%; top: 45%; height: 10%;">
		<img class="gdButton" id="pageUp" style="display: none"; src="../assets/arrow-right.png" height="90%">
	</div>

	<div class="supercenter" id="loading" style="height: 10%; top: 47%; display: none;">
		<img class="spin noSelect" src="../assets/loading.png" height="105%">
	</div>

</div>

</body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="../misc/global.js"></script>
<script type="text/javascript" src="../misc/dragscroll.js"></script>
<script>

$('#pageDown').hide()
$('#pageUp').hide()




let accID;
const urlParams = new URLSearchParams(window.location.search);
let url = new URL(window.location.href)

var path = urlParams.get('s');


var legacyServer = true;

if (path == null) {
	path = "" + window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);
	
	<?php if ($serverType != "legacy") { ?>
	legacyServer = false;
	<?php } ?>
}
// if (!path || path.trim() === '') window.location.href = './search.php';
// if (path == "0") path = "*"

function profileRedirect(url) {
	var queryProfile = "";
    if (legacyServer == true) {
		queryProfile = "../profile/?u=" + (encodeURIComponent(url).replace(/%2F/gi, "") || "");
	} else {
		queryProfile = "../profile/" + (encodeURIComponent(url).replace(/%2F/gi, "") || "") 
	}
    if (queryProfile) window.location.href = "./u/" + queryProfile
}

function levelRedirect(url) {
	var queryLvl = "";
    if (legacyServer == true) {
		queryLvl = "/level/?id=" + (encodeURIComponent(url) || "0")
	} else {
		queryLvl = "/level/" + (encodeURIComponent(url) || "0")
	}
    if (queryLvl) window.location.href = ".." + queryLvl
}

//if (!path || path.trim() === '') path = '*';

let type = url.searchParams.get('type')
let header = url.searchParams.get('header')

let loading = false;

let page = Math.max(1, url.searchParams.get('page')) - 1
let pages = 0
let results = 0
let legalPages = true
let gdwMode = false
let superSearch = ['*', '*?type=mostliked', '*?type=mostdownloaded', '*?type=recent'].includes(window.location.href.split('/')[4].toLowerCase())
let pageCache = {}



var searchFilters = `../api/songs.php?str=` + path + "&page=[PAGE]";

function clean(text) {return (text || "").toString().replace(/&/g, "&#38;").replace(/</g, "&#60;").replace(/>/g, "&#62;").replace(/=/g, "&#61;").replace(/"/g, "&#34;").replace(/'/g, "&#39;")}

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
		pages = res[0].pages
		results = res[0].results
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




	res.forEach((x, y) => {


		$('#searchBox').append(`<div class="searchresult" style="height:25%;" title="${clean(x.name)}">
			<h1 title="${x.name} by ${!x.authorName || x.authorName == "-" ? "some nerd" : x.authorName}" style="width: fit-content; padding-right: 1%; font-size: 5.5vh;">${clean((x.name.length > 20 ? x.name.slice(0, 20) + '...' : x.name) || " ")}</h1>
			<h2 class="pre smaller inline gdButton help" title="AuthorID: ${x.authorID}" style="margin-bottom: 2%; font-size: 3.9vh;"><a  onclick="profileRedirect('${x.authorName}')" >by ${x.authorName}</a></h2>
			<h3 class="lessSpaced" style="width: fit-content;margin-bottom: 0.1%; font-size: 3vh;" title="${x.levelsCount} level(s) using this song">
				<img class="help valign rightSpace" title="${x.levelsCount} level(s) using this song" src="../assets/song/views.png" height="10%">${x.levelsCount} level(s)
				<br><img class="help valign rightSpace" title="Length" src="../assets/smallinfo.png" height="13%">${x.size} MB
			</h3>
		
			<div class="center" style="position:absolute; top: ${9 + (y * 26.5)}%; left: 4.4%; transform:scale(0.82); height: 10%; width: 12.5%;">


				<div class="difficultyBox">
					<img class="help" id="dFace" title="${clean(x.name)}" src="../assets/song/disc.png" style="height:125%">
				</div>
			</div>

			<div class="center" style="position:absolute; right: 7%; transform:translateY(-13vh); height: 10%">
				<a title="View level" onclick=showSong('${encodeURIComponent(x.name)}','${encodeURIComponent(x.downloadLink)}') ><img style="margin-bottom: 4.5%" class="valign gdButton" src="../assets/view.png" height="105%"></a>
			</div>

		</div>`)
	})

	$('#searchBox').append('<div style="height: 4.5%"></div>').scrollTop(0)
	$('#loading').hide()
	loading = false;
	}
}


function showSong(name,link) {

	document.getElementById("songLink").src = decodeURIComponent(decodeURIComponent(link));
	document.getElementById("songName").textContent = decodeURIComponent(name);

	$('#songInfo').show();
	
}

Append(true)


$('#pageUp').click(function() {page += 1; if (!loading) Append(false,true)})
$('#pageDown').click(function() {page -= 1; if (!loading) Append(false,true)})
$('#lastPage').click(function() {page = (pages - 1); if (!loading) Append()})
$('#pageJump').click(function() {if (loading) return; page = parseInt(($('#pageSelect').val() || 1) - 1); Append()})
$('#refreshPage').click(function() { Append(false, true) } )

$('#searchSongBtn').click(function() { 
	
	path = "" + document.getElementById("searchSong").value;
	page = 0;
	searchFilters = `../api/songs.php?str=` + path + "&page=0";
	$('#header').text(decodeURIComponent(path))
	Append(false, true) 
	} 
)

if (header) {
	header = header.slice(0, 32) || "Level Search"
	$('#header').text(header)
	document.title = header
}



if (type == 'saved') {
	$('#header').text("Saved Levels")
	$('#purge').show()
	document.title = "Saved Levels"
	$('#meta-title').attr('content', `Saved Levels`)
	$('#meta-desc').attr('content',  `View your collection of saved Geometry Dash levels!`)
}


if (true) {
	$('body').addClass('darkBG')
	$('.cornerPiece').addClass('grayscale')
}

if (!$('#header').text()) {
	if (path != "*") {
		$('#header').text(decodeURIComponent(path))
		$('#tabTitle').text(decodeURIComponent(path) + " - Level Search")
	} else
		$('#header').text("Online Levels")
}


$('.closeWindow').click(function() {$(".popup").attr('style', 'display: none;')})

$('#purgeSaved').click(function() {
	localStorage.removeItem('saved');
	location.reload()
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

$('#shuffle').click(function() {
	if (superSearch) {
		$('#searchBox').html('<div style="height: 4.5%"></div>')
		$('#loading').show()
		fetch("../api/search.php?levelName=*?page=0&type=recent").then(res => res.json()).then(recent => {
			let mostRecent = recent[0].id
			function fetchRandom() {
				fetch(`../api/level/${Math.floor(Math.random() * (mostRecent)) + 1}`).then(res => res.json()).then(res => {
					if (res == "-1" || !res.id) return fetchRandom()
					else window.location.href = "../" + res.id
				})
			}
			fetchRandom()
		})
	}
	else if (pages) {
		let random = {}
		let pageCount = +count || 10
		randomResult = Math.floor(Math.random() * (results)) + 1
		randomPage = Math.ceil(randomResult / pageCount)
		randomIndex = randomResult % pageCount
		if (randomIndex == 0) randomIndex = pageCount
		$('#searchBox').html('<div style="height: 4.5%"></div>')
		$('#loading').show()
		fetch(searchFilters.replace('[PAGE]', randomPage-1)).then(res => res.json()).then(res => {
			window.location.href = "../" + res[randomIndex-1].id
		})
	}
	else return $('#shuffleDiv').show()
})

$(document).keydown(function(k) {
	if (loading) return;

	if ($('#pageDiv').is(':visible')) {
		if (k.which == 13) $('#pageJump').trigger('click') //enter 
		else return;
	}

    if (k.which == 37 && $('#pageDown').is(":visible")) $('#pageDown').trigger('click')   // left
	if (k.which == 39 && $('#pageUp').is(":visible")) $('#pageUp').trigger('click')       // right

});

</script>