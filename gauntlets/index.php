<?php include("../_init_.php"); ?>

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

	<div class="popup" id="editGauntletPopup">
		<div class="brownbox bounce center supercenter" style="width: 85vh; height: 35%;">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%; display: block;">Edit Gauntlet #<span id="editgID"></span></h2>
			<form id="formEditGauntlet">
			<input type="text" name="act" value="edit" hidden>
			<input type="text" id="editgID2" name="id" value="0" hidden>
			<div class="transparentbox" style="display: contents;">
				
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 25%;"><img src="../assets/gauntlets/6.png" style="filter:grayscale(1);" class="smallMapDivIcon">Gauntlet: <div onclick="CreateFLAlertGauntletsAPI(this,'5')" style="width: 60%;"><select class="gdsInput select" size="1" style="margin-left: 3vh;" id="editGauntletID" name="newid" min-options="1" max-options="1" api-url="../api/gauntlets.php" required>
				</select></div></h3>

				
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 25%;"><img src="../assets/play.png" class="smallMapDivIcon">Levels:<div onclick="CreateFLAlertSearchAPI(this,'10')" style="width: 71%;"><select class="gdsInput select" size="1" style="margin-left: 3vh;" id="editGauntletLevels" name="levels[]" min-options="5" max-options="5" api-url="../api/search.php" required multiple>
				</select></div></h3>

			
			</div>
			<img onclick="submitsGauntlet('formEditGauntlet','edit')" src="../assets/btn-submit.png" style="margin-top: 2vh;" height=15%;>
			<img class="gdButton center closeWindow" src="../assets/close.png" height="25%" style="position: absolute; top: -15.5%; left: -6vh">
			</form>
		</div>
	</div>

	<div class="popup" id="createGauntletPopup">
		<div class="brownbox bounce center supercenter" style="width: 85vh; height: 35%;">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%; display: block;">Create Gauntlet</h2>
			<form id="formAddGauntlet">
			<input type="text" name="act" value="create" hidden>
			<div class="transparentbox" style="display: contents;">
				
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 25%;"><img src="../assets/gauntlets/6.png" style="filter:grayscale(1);" class="smallMapDivIcon">Gauntlet: <div onclick="CreateFLAlertGauntletsAPI(this,'5')" style="width: 60%;"><select class="gdsInput select" size="1" style="margin-left: 3vh;" id="createGauntletID" name="id" min-options="1" max-options="1" api-url="../api/gauntlets.php" required>
				</select></div></h3>

				
				<h3 style="display: flex;justify-content: center; align-items: center; margin-left: 3vh; height: 25%;"><img src="../assets/play.png" class="smallMapDivIcon">Levels:<div onclick="CreateFLAlertSearchAPI(this,'10')" style="width: 71%;"><select class="gdsInput select" size="1" style="margin-left: 3vh;" id="createGauntletLevels" name="levels[]" min-options="5" max-options="5" api-url="../api/search.php" required multiple>
				</select></div></h3>

			
			</div>
			<img onclick="submitsGauntlet('formAddGauntlet','create')" src="../assets/btn-submit.png" style="margin-top: 2vh;" height=15%;>
			<img class="gdButton center closeWindow" src="../assets/close.png" height="25%" style="position: absolute; top: -15.5%; left: -6vh">
			</form>
		</div>
	</div>

	<div class="popup" id="deleteGauntletPopup">
		<div class="brownbox bounce center supercenter" style="width: 75vh; height: 45%;">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%; display: block;">Delete Gauntlet #<span id="delgID"></span></h2>
			<form id="formDelGauntlet">
				<input type="text" name="act" value="delete" hidden>
				<img id="delgauntletImage" onerror="gauntletErrorImg(this)" style="margin-top: 1.5vh; width: 10vh;" src="../assets/gauntlets/0.png">
				<p class="bigger center" style="line-height: 5vh; margin-top: 1vh;">
					Are you sure to delete this Gauntlet?<br><cr>This action cannot be reversed.</cr>
				</p>
				<input type="number" id="delgID2" name="id" value="0" hidden>
				<img class="gdButton center closeWindow" src="../assets/btn-no.png" height=14.5%;>
				<img onclick="submitsGauntlet('formDelGauntlet','delete')" src="../assets/btn-yes.png"  height=14.5%;>
			</form>
		</div>
	</div>

	<div onclick="createGauntlet()" title="Create new mappack" class="checkperm-gauntlets" style="position:absolute; bottom: 2.5%; right: 2.5%; width: 15%; text-align: right;">
		<h3 style="transform: translate(-9%, -5%);">Mod</h3>
		<img class="gdButton" src="../assets/newBtn.png" width="40%" id="createMapPack"></a>
	</div>

	<div onclick="helpGauntlet()" title="help" style="cursor: pointer; position:absolute; top: 2.5%; right: 2.5%; width: 15%; text-align: right;">
		<img class="gdButton" src="../assets/help.png" width="40%"></a>
	</div>

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

<script type="text/javascript" src="../misc/gdcustomalerts.js"></script>
<script type="text/javascript" src="../misc/customselects.js"></script>
<script type="text/javascript" src="../misc/global.js"></script>
<script type="text/javascript" src="../misc/tintheximg.js"></script>

<script>
	$('#loading-main').hide();
</script>
<script>

let pages = 0;
let page = 1;
let loading = true;
let pageCache = null;


function helpGauntlet() {
	CreateFLAlert("Help!","`g0 You can't see your gauntlets?`\n\n\n- You need to have at least 3 gauntlets for **proper display.**\n- Restart the game.\n- Check that your _internet connection_ is working.");
}


function submitsGauntlet(objectform,type) {
	document.dispatchEvent(new Event('initLoadingAlert'));

    let form = document.getElementById(objectform);
	form.dispatchEvent(new Event('submit'));
    if (form.checkValidity()) {
        var formData = new FormData(form);
		
        fetch('../api/gauntlets.php', {
            method: 'POST',
            body: formData,
			credentials: 'include'
        })
        .then(response => response.json())
        .then(data => {


			if(data.success == "true") {
				if(type == "create") changeLoadingAlert("Gauntlet created!","done");
				else if (type == "edit") changeLoadingAlert("Gauntlet edited!","done");
				else if (type == "delete") changeLoadingAlert("Gauntlet deleted!","done");
				else changeLoadingAlert("Gauntlet done unknown action!","done");
			}
			else {
				if(type == "create") changeLoadingAlert("Error creating Gauntlet!","error");
				else if (type == "edit") changeLoadingAlert("Error editing Gauntlet!","error");
				else if (type == "delete") changeLoadingAlert("Error deleting Gauntlet!","error");
				else changeLoadingAlert("Unknown error Gauntlet action!","error");
			}
			console.log(data);
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
			loadingGauntlet();
        })
        .catch(error => {
			if(type == "create") changeLoadingAlert("Error creating Gauntlet!","error");
			else if (type == "edit") changeLoadingAlert("Error editing Gauntlet!","error");
			else if (type == "delete") changeLoadingAlert("Error deleting Gauntlet!","error");
			else changeLoadingAlert("Unknown error Gauntlet action!","error");
            console.error('Error:', error);
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
        });
		$(`#${type}GauntletPopup`).hide();
		
    } else {
		changeLoadingAlert("Data not completed!","error");
        form.reportValidity();
		setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
    }
}

function loadingGauntlet() {
$('#gauntletList').empty();
page = 1;
pages = 0;
fetch('../api/gauntlets.php').then(res => res.json()).then(gauntlets => {
	
	

	let gCounter = 0;
	pages = gauntlets[0].pages ?? 0;

	pageCache = gauntlets;
	
	gauntlets.forEach((x, y) => {

		if ((y) % 3 === 0 || y == 0) {
			gCounter += 1;
			$('<div>', { id: `gauntletPage-${gCounter}`, class: "gauntletPage" }).appendTo('#gauntletList');
		}

		$(`#gauntletPage-${gCounter}`).append(`

			<a onclick="redirectGauntlet('${x.levels}','${x.gauntlet.name}')">
	
			<div class="gauntlet invisibleBox" style="background-color: ${x.gauntlet.bgColor ? x.gauntlet.bgColor : '#c8c8c8'};">
			
			<h3 class="gauntletTitle" style="color: ${x.gauntlet.textColor ? x.gauntlet.textColor : '#ffffff'};">${x.gauntlet.name}<br>Gauntlet</h3><br>

			<img class="gauntlet icon" onerror="gauntletErrorImg(this)" src="../assets/gauntlets/${x.id}.png"><br>
			
			<div class="checkperm-gauntlets" onclick="event.stopPropagation();" style="pointer-events: unset; cursor: default; background-color: #0000007d; border-radius: 2vh; padding: 0.5vh; top: 7.5%; position: relative;">
				<h3 class="lessSpaced">Mod actions</h3>
					<img onclick="editGauntlet(${y})" title="Edit Gauntlet" class="valign gdButton editGauntlet" src="../assets/editBtn.png" height="10%">
					<img onclick="deleteGauntlet(${y})" title="Delete Gauntlet" class="valign gdButton delGauntlet" src="../assets/trash.png" height="10%">
			</div>

			</div></a>`)
	})

	if(pages > 0) {
		$("#pageUp").show();
		$("#gauntletPage-1").addClass("show");
	}
	$('#loading').hide()
	loading = false;
	document.dispatchEvent(new Event('DOMContentLoaded'));
});
}

// Loading gauntlets;
loadingGauntlet();

function createGauntlet() {
	$("#createGauntletPopup").show();
}

function editGauntlet(id) {
	$("#editGauntletPopup").show();

	dataGauntlet = pageCache[id];

	let editGauntlet = $('#editGauntletID').empty();

	console.log(dataGauntlet);
	$('#editgID2').val(`${dataGauntlet.id}`);
	$('#editgID').text(`${dataGauntlet.id}`);
	
	editGauntlet.append(`<option html="${dataGauntlet.gauntlet.name} Gauntlet" value="${dataGauntlet.id}" selected>${dataGauntlet.gauntlet.name} Gauntlet</option>`); 


	let editgLevels = $('#editGauntletLevels').empty();
	
	dataGauntlet.levels.split(',').forEach(level => {
		// I may add in the future that the API returns the names, for now I will add "?"
		editgLevels.append(`<option title="ID: ${level}" value="${level}" selected>${level}</option>`); 
	});
}

function deleteGauntlet(id) {
	$("#deleteGauntletPopup").show();

	dataGauntlet = pageCache[id];

	let editGauntlet = $('#editGauntletID').empty();
	$('#delgauntletImage').attr('src',`../assets/gauntlets/${dataGauntlet.id}.png`)
	$('#delgauntletImage').css("filter", "unset");
	$('#delgID').text(`${dataGauntlet.id}`);
	$('#delgID2').val(`${dataGauntlet.id}`);
	
}

$('#pageUp').click(function() {
	page += 1;
	checkPage(false);
});

$('#pageDown').click(function() {
	page -= 1;
	checkPage(true);
});

$('.closeWindow').click(function() {$(".popup").attr('style', 'display: none;')})

function checkPage(toggle) {

	if (page <= 1) $('#pageDown').hide()
	else $('#pageDown').show()

	console.log("page", page, "  -  pages", pages);

	if (page >= pages) $('#pageUp').hide()
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
		queryLvl = "/search/search.php?s=" + (url || "0") + "&list"
	} else {
		queryLvl = "/search/" + (url || "0") + "?list"
	}
    if (queryLvl) window.location.href = ".." + queryLvl + "&gauntlet=" + header;
}




</script>
<script>let userPermissions = <?php echo $userPermissionsJSON; ?>;</script>
<script type="text/javascript" src="../misc/checkperms.js"></script>