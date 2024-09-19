<?php include("../_init_.php"); ?>

<head>
	<title>Mods</title>
	<meta charset="utf-8">
	<link href="../assets/css/browser.css" type="text/css" rel="stylesheet">
	<link rel="icon" href="../assets/mods.png">
	<meta id="meta-title" property="og:title" content="Mods">
	<meta id="meta-desc" property="og:description" content="Browse through the available mods.">
	<meta id="meta-image" name="og:image" itemprop="image" content="https://gdbrowser.com/assets/mods.png">
	<meta name="twitter:card" content="summary">
	<style>
		/* Estilos CSS proporcionados */
		body {
			background: #181818;
			color: #fff;
			font-family: Arial, sans-serif;
		}
		.levelBG {
			background: #2d2d2d;
		}
		.darkBG {
			background: #1e1e1e;
		}
		.center {
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.gdButton {
			cursor: pointer;
		}
		.noSelect {
			user-select: none;
		}
		.spin {
			animation: spin 1s infinite linear;
		}
		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
		.modItem {
			color: #fff;
			text-decoration: none;
			font-size: 18px;
			border-bottom: 1px solid #555;
			padding: 10px 0;
		}
		.modItem:hover {
			background-color: #333;
		}
	</style>
</head>

<body class="levelBG darkBG" style="overflow-y:auto;" onbeforeunload="saveUrl()">

<div id="everything" class="center" style="width: 100%; height: 100%; flex-direction: column;">

	<div style="position:absolute; top: 2%; left: -1.95%; width: 10%; height: 25%; pointer-events: none">
		<img class="gdButton yesClick" id="backButton" src="../assets/back.png" height="30%" onclick="backButton()">
	</div>

	<div class="center" width="100%" style="margin-top: 2.5%; margin-bottom: 1%;">
		<h1>Available Roles</h1>
	</div>

	<img id="loading" style="margin-top: 1%" class="spin noSelect" src="../assets/loading.png" height="12%">

	<div id="modsList" style="width: 50%; margin: 20px auto 0 auto; text-align: center;">
		<br>
	</div>

	<br>

</div>
</body>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="../misc/global.js"></script>
<script>

// Fetch the mods from mods.php API
fetch('../api/mods.php').then(res => res.json()).then(mods => {
	$('#loading').hide();
	mods.forEach((mod, index) => {
		$('#modsList').append(`
			<div class="modItem" style="padding: 10px 0; border-bottom: 1px solid #555;">
				<a onclick="redirectMod('${mod.roleID}', '${mod.roleName}')" style="color: #fff; text-decoration: none; font-size: 18px;">
					${index + 1}. ${mod.roleName}
				</a>
			</div>
		`);
	});
});

let serverType = "<?php print_r($serverType); ?>";

function redirectMod(roleID, roleName) {
	var queryMod = "";
	if (serverType == "legacy") {
		queryMod = "/search/search.html?role=" + (roleID || "0") + "&list";
	} else {
		queryMod = "/search/" + (roleID || "0") + "?list";
	}
	if (queryMod) window.location.href = ".." + queryMod + "&header=" + roleName + "%20Mod";
}

</script>
