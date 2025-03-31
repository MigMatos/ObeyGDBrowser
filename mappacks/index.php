<?php include("../_init_.php"); ?>

<head>
	<title id="tabTitle">Level Search</title>
	<meta charset="utf-8">
	<link href="../assets/css/browser.css?v=1" type="text/css" rel="stylesheet">
    
	<link rel="icon" href="../assets/coin.png">
	<meta id="meta-title" property="og:title" content="Level Search">
	<meta id="meta-desc" property="og:description" content="Search for Geometry Dash levels, and filter by length, difficulty, song + more!">
	<meta id="meta-image" name="og:image" itemprop="image" content="../coin.png">
	<meta name="twitter:card" content="summary">

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	

</head>

<?php include("../assets/htmlext/loadingalert.php"); ?>
<?php include("../assets/htmlext/flayeralert.php"); ?>

<style>
	input.inputmaps {
		margin-left: 3vh;
		height: 8.5%;
		font-size: 3vh;
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

	<div class="popup" id="deletemapPopup">
		<div class="brownbox bounce center supercenter" style="width: 75vh; height: 30%;">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%; display: block;">Delete MapPack #<span id="delmapID"></span></h2>
			<form id="formDelMap">
				<input type="text" name="act" value="delete" hidden>
				<p class="bigger center" style="line-height: 5vh; margin-top: 1.5vh;">
					Are you sure to delete this map pack?<br><cr>This action cannot be reversed.</cr>
				</p>
				<input type="number" id="delmapID2" name="id" value="0" hidden>
				<img class="gdButton center closeWindow" src="../assets/btn-no.png" height=25%;>
				<img onclick="submitDelMap()" src="../assets/btn-yes.png"  height=25%; >
			</form>
		</div>
	</div>

	<div class="popup" id="editmapPopup">
		<div class="brownbox bounce center supercenter" style="width: 85vh; height: 70%;">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%; display: block;">Edit MapPack #<span id="editmapID"></span></h2>
			<form id="formEditMap">
			<div class="transparentbox" style="display: contents;">
				
				<input type="text" name="act" value="edit" hidden><input type="number" id="editmapID2" name="id" value="0" hidden>

				<h3><img src="../assets/info.png" class="smallMapDivIcon">Name:<input class="inputmaps" type="text" id="editmapName" name="name" maxlength="25" placeholder="My first map :D" required></h3>
				
				<!-- <select api-search-id="2" data-url="../api/search.php" multiple="multiple" required data-min="2" data-max="10"></select> -->

				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 12%;"><img src="../assets/play.png" class="smallMapDivIcon">Levels:<div onclick="CreateFLAlertSearchAPI(this,'10')" style="width: 71%;"><select class="gdsInput select" size="1" style="margin-left: 3vh;" id="editmapLevels" name="levels[]" min-options="2" max-options="10" api-url="../api/search.php" required multiple>
					
				</select></div></h3>

				<!-- <h3>ID Levels:<input class="inputmaps" pattern="^\d+,\d+(,\d+)*$" placeholder="1,2..." type="text" id="editmapLevels" name="levels" maxlength="25" required></h3> -->
				<h3><img src="../assets/star.png" class="smallMapDivIcon">Stars:<input class="inputmaps" type="number" id="editmapStars" name="stars" max="999" required></h3>
				<h3><img src="../assets/coin.png" class="smallMapDivIcon">Coins:<input class="inputmaps" type="number" id="editmapCoins" name="coins" max="999" required></h3>
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 12%;"><img src="../assets/difficulties/unrated.png" class="smallMapDivIcon">Difficulty:<div onclick="CreateFLSelector('editmapDiff','Select Difficulty')"><select class="gdsInput select" size="1" style="margin-left: 3vh;" id="editmapDiff" name="difficulty" required>
					<option value="0" selected>auto</option>
					<option value="1">easy</option>
					<option value="2">normal</option>
					<option value="3">hard</option>
					<option value="4">harder</option>
					<option value="5">insane</option>
					<option value="6">hard demon</option>
					<option value="7">easy demon</option>
					<option value="8">medium demon</option>
					<option value="9">insane demon</option>
					<option value="10">extreme demon</option>
				</select></div></h3>
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 10%;"><img src="../assets/objects/triggers/Color.png" class="smallMapDivIcon">Text Color:<div class="gdColorPicker"><input class="inputmaps" type="color" id="editmaptextcolor" name="rgbcolors"></div></h3>
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 10%;"><img src="../assets/objects/triggers/Color.png" class="smallMapDivIcon">Bar Color:<div class="gdColorPicker"><input class="inputmaps" type="color" id="editmapbarcolor" name="colors2"></div></h3>
				

			
			</div>
			<img onclick="submitEditMap()" src="../assets/ok.png" style="margin-top: 3vh;" height=10%;>
			<img class="gdButton center closeWindow" src="../assets/close.png" height="15%" style="position: absolute; top: -7.5%; left: -7vh">
			</form>
		</div>
	</div>


	<div class="popup" id="createmapPopup">
		<div class="brownbox bounce center supercenter" style="width: 85vh; height: 70%;">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%; display: block;">Create MapPack</h2>
			<form id="formNewMap">
			<div class="transparentbox" style="display: contents;">
				
				<input type="text" name="act" value="create" hidden>
				<h3><img src="../assets/info.png" class="smallMapDivIcon">Name:<input class="inputmaps" type="text" id="mapName" name="name" maxlength="25" placeholder="My first map :D" required></h3>
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 12%;"><img src="../assets/play.png" class="smallMapDivIcon">Levels:<div onclick="CreateFLAlertSearchAPI(this,'10')" style="width: 73%;"><select class="gdsInput select" size="1" style="margin-left: 3vh;" id="mapLevels" name="levels[]" min-options="2" max-options="10" api-url="../api/search.php" required multiple>
					
				</select></div></h3>
				<h3><img src="../assets/star.png" class="smallMapDivIcon">Stars:<input class="inputmaps" type="number" id="mapStars" name="stars" max="999" required></h3>
				<h3><img src="../assets/coin.png" class="smallMapDivIcon">Coins:<input class="inputmaps" type="number" id="mapCoins" name="coins" max="999" required></h3>
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 12%;"><img src="../assets/difficulties/unrated.png" class="smallMapDivIcon">Difficulty:<div onclick="CreateFLSelector('mapDiff','Select Difficulty')"><select class="gdsInput select" size="1" style="margin-left: 3vh;" id="mapDiff" name="difficulty" required>
					<option value="0" selected>auto</option>
					<option value="1">easy</option>
					<option value="2">normal</option>
					<option value="3">hard</option>
					<option value="4">harder</option>
					<option value="5">insane</option>
					<option value="6">hard demon</option>
					<option value="7">easy demon</option>
					<option value="8">medium demon</option>
					<option value="9">insane demon</option>
					<option value="10">extreme demon</option>
				</select></div></h3>
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 10%;"><img src="../assets/objects/triggers/Color.png" class="smallMapDivIcon">Text Color:<div class="gdColorPicker"><input class="inputmaps" type="color" id="mapTextcolor" name="rgbcolors"></div></h3>
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 10%;"><img src="../assets/objects/triggers/Color.png" class="smallMapDivIcon">Bar Color:<div class="gdColorPicker"><input class="inputmaps" type="color" id="mapBarcolor" name="colors2"></div></h3>
				

			
			</div>
			<img onclick="submitNewMap()" src="../assets/ok.png" style="margin-top: 3vh;" height=10%;>
			<img class="gdButton center closeWindow" src="../assets/close.png" height="15%" style="position: absolute; top: -7.5%; left: -7vh">
			</form>
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

	<div title="Jump to page" style="text-align: right; position:absolute; top: 7.5%; right: 2%; height: 12%;">
		<img src="../assets/magnify.png" height="60%" class="gdButton" style="margin-top: 5%" onclick="$('#pageDiv').show(); $('#pageSelect').focus().select()">
	</div>

	<!-- <div id="shuffle" title="Random level" style="display: none; text-align: right; position:absolute; top: 7.5%; right: 6.5%; height: 12%;">
		<img src="../assets/random.png" height="60%" class="gdButton" style="margin-top: 5%">
	</div> -->

	<div id="lastPage" title="Last page" style="display: none; text-align: right; position:absolute; top: 7.5%; right: 11%; height: 11%;">
		<img src="../assets/double-arrow.png" height="60%" class="gdButton" style="margin-top: 5%">
	</div>

	<div style="position:absolute; top: 2%; left: 1.5%; width: 10%; height: 25%; pointer-events: none">
		<img class="gdButton yesClick" id="backButton" src="../assets/back.png" height="30%" onclick="backButton()">
	</div>

	<div id="purge" style="position:absolute; bottom: 1%; right: -3%; width: 10%; display:none;">
		<img class="gdButton" src="../assets/delete.png" width="60%" onclick="$('#purgeDiv').show()">
	</div>

	<div onclick="createMap()" title="Create new mappack" class="checkperm-mappacks" style="position:absolute; bottom: 15.5%; right: 1%; width: 15%; text-align: right;">
		<h3 style="transform: translate(-9%, -5%);">Mod</h3>
		<img class="gdButton" src="../assets/newBtn.png" width="40%" id="createMapPack"></a>
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
<script type="text/javascript" src="../misc/gdcustomalerts.js"></script>

<script type="text/javascript" src="../misc/customselects.js"></script>

<script type="text/javascript" src="../misc/global.js"></script>
<script type="text/javascript" src="../misc/dragscroll.js"></script>

<script>
$("#loading-main").hide();

function editMap(page,idarray){
	dataMap = pageCache[page][idarray];	

	$('#editmapID').text(dataMap.packID);
	$('#editmapID2').val(dataMap.packID);
	$('#editmapName').val(dataMap.packName);
	// idk if that works XDXD
	let editmapLevels = $('#editmapLevels').empty();
	
	dataMap.levels.split(',').forEach(level => {
		// I may add in the future that the API returns the names, for now I will add "?"
		editmapLevels.append(`<option title="ID: ${level}" value="${level}" selected>${level}</option>`); 
	});

	$('#editmapStars').val(dataMap.stars);
	$('#editmapCoins').val(dataMap.coins);
	$('#editmapDiff').val(dataMap.difficulty);
	$('#editmaptextcolor').val(dataMap.textColor);
	$('#editmapbarcolor').val(dataMap.barColor);
	
	$('#editmapPopup').show();
}

function createMap() {
	$('#createmapPopup').show();
}

function deleteMap(page,idarray) {
	dataMap = pageCache[page][idarray];	
	$('#deletemapPopup').show();
	$('#delmapID').text(dataMap.packID);
	$('#delmapID2').val(dataMap.packID);
}

function submitNewMap() {
	document.dispatchEvent(new Event('initLoadingAlert'));
    let form = document.getElementById('formNewMap');
	// form.dispatchEvent(new Event('submit'));
    if (form.checkValidity()) {
        var formData = new FormData(form);
		
        fetch('../api/mappacks.php', {
            method: 'POST',
            body: formData,
			credentials: 'include'
        })
        .then(response => response.json())
        .then(data => {


			if(data.success == "true") changeLoadingAlert("Map Pack created!","done");
			else changeLoadingAlert("Error creating Map Pack!","error");
			console.log(data);
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
			Append(true, true);
        })
        .catch(error => {
			changeLoadingAlert("An error occurred while creating Map Pack...","error");
            console.error('Error:', error);
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
        });
		$('#createmapPopup').hide();
		
    } else {
		changeLoadingAlert("Data not completed!","error");
        form.reportValidity();
		setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
    }
}

function submitDelMap() {
	document.dispatchEvent(new Event('initLoadingAlert'));
    let form = document.getElementById('formDelMap');
	// form.dispatchEvent(new Event('submit'));
	
    if (form.checkValidity()) {
        var formData = new FormData(form);
		
        fetch('../api/mappacks.php', {
            method: 'POST',
            body: formData,
			credentials: 'include'
        })
        .then(response => response.json())
        .then(data => {
			if(data.success == "true") changeLoadingAlert("Map Pack deleted!","done");
			else changeLoadingAlert("Error deleting Map Pack!","error");
			console.log(data);
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
			Append(true, true);
        })
        .catch(error => {
			changeLoadingAlert("An error occurred while deleting Map Pack...","error");
            console.error('Error:', error);
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
        });
		$('#deletemapPopup').hide();
		
    } else {
		changeLoadingAlert("Data not completed!","error");
        form.reportValidity();
		setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
    }
}

function submitEditMap() {
	document.dispatchEvent(new Event('initLoadingAlert'));
    let form = document.getElementById('formEditMap');
	// form.dispatchEvent(new Event('submit'));
	form = document.getElementById('formEditMap');
    if (form.checkValidity()) {
        var formData = new FormData(form);
		
        fetch('../api/mappacks.php', {
            method: 'POST',
            body: formData,
			credentials: 'include'
        })
        .then(response => response.json())
        .then(data => {
			if(data.success == "true") changeLoadingAlert("Map Pack edited!","done");
			else changeLoadingAlert("Error editing Map Pack!","error");
			console.log(data);
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
			Append(true, true);
        })
        .catch(error => {
			changeLoadingAlert("An error occurred while editing Map Pack...","error");
            console.error('Error:', error);
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
        });
		$('#editmapPopup').hide();
		
    } else {
		changeLoadingAlert("Data not completed!","error");
        form.reportValidity();
		setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
    }
}

</script>

<script>



$('#pageDown').hide()
$('#pageUp').hide()

let accID;
const urlParams = new URLSearchParams(window.location.search);
let url_browser = new URL(window.location.href)

var path = urlParams.get('s');
let serverType = "<?php print_r($serverType); ?>";
//if (!path || path.trim() === '') window.location.href = './search.php';
if (path == "0") path = "*"


function searchRedirect(url, header) {
	var queryLvl = "";
    if (serverType == "legacy") {
		queryLvl = "/search/search.php?s=" + (url || "0") + "&list"
	} else {
		queryLvl = "/search/" + (url || "0") + "?list"
	}
    if (queryLvl) window.location.href = ".." + queryLvl + "&header=" + header;
}

let loading = false;
let count = url_browser.searchParams.get('count')
let page = Math.max(1, url_browser.searchParams.get('page')) - 1
let pages = 0
let results = 0
let legalPages = true
let gdwMode = false
let superSearch = ['*', '*?type=mostliked', '*?type=mostdownloaded', '*?type=recent'].includes(window.location.href.split('/')[4].toLowerCase())
let pageCache = {}


let searchFilters = `../api/mappacks.php?page=[PAGE]${count ? "" : "&count=10"}${window.location.search.replace(/\?/g, "&").replace("page", "nope")}`

function clean(text) {return (text || "").toString().replace(/&/g, "&#38;").replace(/</g, "&#60;").replace(/>/g, "&#62;").replace(/=/g, "&#61;").replace(/"/g, "&#34;").replace(/'/g, "&#39;")}


let hostMatch = window.location.host.match(/\./g)


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
		$('#searchBox').append(`<div class="searchresult" title="${clean(x.packName)}">

			<div style="position: relative; height: 100%; align-content: center;">
			<h1 class="lessspaced pre" title="${x.packName}" id="titlePackName" style="white-space: collapse; text-wrap: wrap; width: 75%; text-align: center; color: ${x.textColor}">${clean(x.packName || " ")}</h1>

			<div style="border-radius: 3vh; background-color: #0000007d; width: 50%; transform: translate(22.5%, 0px); padding: 0.2%;"><h3 class="lessspaced pre" style="text-align: center; color: ${x.barColor};">${x.levelsCount} Levels</h1></div>
			
			<h3 class="lessSpaced" style="width: 100%; position: relative; transform: translate(-22%, 22.2%); left: 50%;" title="">
				${x.stars} <img class="help valign rightSpace" title="Stars" src="../assets/star.png" height="13%">
				${x.coins} <img class="help valign rightSpace" title="StarCoins" src="../assets/coin.png" height="14%">
			</h3>
			</div>

			<div class="center" style="position:absolute; top: ${11.5 + (y * 33.5)}%; left: 4.4%; transform:scale(0.82); height: 10%; width: 12.5%;">
				
				<div class="difficultyBox">
					<img class="help" id="dFace" title="Difficulty: ${x.difficultyText}" src="../assets/difficulties/${x.difficultyFace}.png">
				</div>
				<h3 title="">${x.difficultyText.includes('demon') ? "demon" : x.difficultyText}</h3>


			</div>

			<div class="center" style="position:absolute; right: 7%; transform: translate(0.5vh, -16.25vh); height: 10%">
				<div class="checkperm-mappacks modActionBox">
				<h3 class="lessSpaced" style="cursor: default;">Mod actions</h3>
					<img onclick="editMap(${page},${y})" title="Edit Map Pack" class="valign gdButton editMap" src="../assets/editBtn.png" height="105%">
					<img onclick="deleteMap(${page},${y})" title="Delete Map Pack" class="valign gdButton delMap" src="../assets/trash.png" height="105%">
				</div>
				<a title="View levels" onclick=searchRedirect('${encodeURI(x.levels)}','${encodeURIComponent(clean(x.packName || " ? "))}') "><img class="valign gdButton" src="../assets/view.png" height="105%"></a>
			</div>


		</div>`)
	})

	$('#searchBox').append('<div style="height: 4.5%"></div>').scrollTop(0)
	$('#loading').hide()
	loading = false;
	runCheckPerms();
	}
}

Append(true)

$('#pageUp').click(function() {page += 1; if (!loading) Append()})
$('#pageDown').click(function() {page -= 1; if (!loading) Append()})
$('#lastPage').click(function() {page = (pages - 1); if (!loading) Append()})
$('#pageJump').click(function() {if (loading) return; page = parseInt(($('#pageSelect').val() || 1) - 1); Append()})
$('#refreshPage').click(function() { Append(false, true) } )


header = "Map Packs"
$('#header').text(header)
document.title = header

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

<script>let userPermissions = <?php echo $userPermissionsJSON; ?>;</script>
<script type="text/javascript" src="../misc/checkperms.js"></script>
