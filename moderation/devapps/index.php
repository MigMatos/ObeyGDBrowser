<?php include("../../_init_.php"); ?>

<head>
	<title id="tabTitle">Developer Apps</title>
	<meta charset="utf-8">
	<link href="../../assets/css/browser.css?v=3" type="text/css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.css" rel="stylesheet">
	<link href="https://unpkg.com/prismjs@1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet">
    
	<link rel="icon" href="../../assets/devapps/defaultDevApp.png">
	<meta id="meta-title" property="og:title" content="Developer Apps">
	<meta id="meta-desc" property="og:description" content="Find songs to use in your levels!">
	<meta id="meta-image" name="og:image" itemprop="image" content="https://cdn.obeygdbot.xyz/icons/disc.png">
	<meta name="twitter:card" content="summary">
	
</head>

<?php include("../../assets/htmlext/loadingalert.php"); ?>
<?php include("../../assets/htmlext/flayeralert.php"); ?>

<style>
	.searchResult {
		background-color: #3737378c;
	}
	.searchResult:nth-child(odd) {
		background-color: #0000007d;
	}

	#searchBox {
		background-color: rgb(0 0 0 / 0%);
	}
	
	.font-helvetica {
		font-size: 2.5vh;
	}

	.font-gold-pusab {
		font-size: 4.5vh;
	}

	.codeFormat {
		font-family: 'HELVETICA';
    	font-size: 2.5vh;
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

	.codeApp-container {
        width: 80%;
        max-width: 800px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
		font-family: aller, helvetica, arial;
		margin-left: auto;
		margin-right: auto;
    }

    .codeApp-tabs {
        display: flex;
        background: #2d3748;
        border-bottom: 2px solid #1a202c;
    }

    .codeApp-tab {
        flex: 1;
        text-align: center;
        padding: 12px 0;
        cursor: pointer;
        color: #a0aec0;
        font-weight: bold;
        transition: background 0.3s, color 0.3s;
    }

    .codeApp-tab.active {
        background: #1a202c;
        color: #edf2f7;
    }
	
    .codeApp-content {
        display: none;
        padding: 16px;
        background: #1a202c;
        color: #edf2f7;
        font-family: "Courier New", Courier, monospace;
        font-size: 14px;
        overflow-x: auto;
        line-height: 1.5;
		text-align: left;
    }

    .codeApp-content.active {
        display: block;
    }

    pre {
        margin: 0 !IMPORTANT;
		padding: 0vh 0vh 0vh 1em !IMPORTANT;
		border-radius: 0 !IMPORTANT;
		height: 14em;
    }

	.token.comment{
		background-color: rgba(0,0,0,0);
	}
	
</style>

<body class="levelBG darkBG" onbeforeunload="saveUrl()">

<div id="everything" style="overflow: auto;">

	

	<div class="popup" id="pageDiv">
		<div class="brownbox bounce center supercenter" style="width: 60vh; height: 34%">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Jump to Page</h2>
			<input type="number" id="pageSelect" placeholder="1"><br>
			<img src="../../assets/ok.png" height=20%; id="pageJump" class="gdButton center closeWindow">
			<img class="closeWindow gdButton" src="../../assets/close.png" height="25%" style="position: absolute; top: -13.5%; left: -6vh">

			<div class="supercenter" style="left: 25%; top: 43%; height: 10%;">
				<img class="gdButton" src="../../assets/whitearrow-left.png" height="160%" onclick="$('#pageSelect').val(parseInt($('#pageSelect').val() || 0) - 1); $('#pageSelect').trigger('input');">
			</div>
		
			<div class="supercenter" style="left: 75%; top: 43%; height: 10%;">
				<img class="gdButton" src="../../assets/whitearrow-right.png" height="160%" onclick="$('#pageSelect').val(parseInt($('#pageSelect').val() || 0) + 1); $('#pageSelect').trigger('input');">
			</div>
		</div>
	</div>


	<div class="popup" id="searchDiv">
		<div class="brownbox bounce center supercenter" style="width: 60vh; height: 34%">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Search Song</h2>
			<input type="text" id="searchSong" placeholder="Search!" style="width:85%; margin: 8% 0% 8% 0%; height: 25%; text-align: center;"><br>
			<img src="../../assets/ok.png" height=20%; id="searchSongBtn" class="gdButton center closeWindow">
			<img class="closeWindow gdButton" src="../../assets/close.png" height="25%" style="position: absolute; top: -13.5%; left: -6vh">
		</div>
	</div>

	<div class="popup" id="settingsDiv">
		<div id="filterStuff" class="brownbox bounce center supercenter" style="width: 101vh; height: 50%; padding-top: 0.3%; padding-bottom: 3.5%; padding-left: 1%">
			<h1 style="margin-bottom: 4%">Advanced Options</h1><br>
			<!-- <input type="text" id="searchSong" placeholder="Search!" style="width:85%; margin: 8% 0% 8% 0%; height: 25%; text-align: center;"><br> -->
			<div style="width: 93%;background-color: #00000065;border-radius: 2.5vh;padding: 1vh 0vh 1vh 5vh;">
				<h3 class="center supercenter" style="top: 23%;margin-bottom: 4%;color: gold;">Disable platforms</h3><br>
				<div><h1><input type="checkbox" id="box-nounknown" url="&amp;nounknown"><label for="box-nounknown" class="gdcheckbox gdButton" tabindex="0"></label>Unknown</h1></div>
				<div><h1><input type="checkbox" id="box-nodiscord" url="&amp;nodiscord"><label for="box-nodiscord" class="gdcheckbox gdButton" tabindex="0"></label>Discord</h1></div>
				<div><h1 style="font-size: 3.6vh;"><input type="checkbox" id="box-nong" url="&amp;nong"><label for="box-nong" class="gdcheckbox gdButton" tabindex="0"></label>Newgrounds</h1></div>
				<br>
				<div><h3><input type="checkbox" id="box-noroblibrary" url="&amp;noroblibrary"><label for="box-noroblibrary" class="gdcheckbox gdButton" tabindex="0"></label>Robtop Library</h3></div>
				<div><h3><input type="checkbox" id="box-noogdlibrary" url="&amp;noogdlibrary"><label for="box-noogdlibrary" class="gdcheckbox gdButton" tabindex="0"></label>OGDMusic Library</h3></div>
				<div><h1><input type="checkbox" id="box-nodropbox" url="&amp;nodropbox"><label for="box-nodropbox" class="gdcheckbox gdButton" tabindex="0"></label>Dropbox</h1></div>
			<!-- <img src="../assets/ok.png" height=20%; id="settingsDivBtn" class="gdButton center closeWindow"> -->
			</div>

			<div style="width: 100%; padding: 3vh 0vh 1vh 5vh;">
				<div><h3><input type="checkbox" id="box-removeunused" url="&amp;removeunused"><label for="box-removeunused" class="gdcheckbox gdButton" tabindex="0"></label>Remove unused</h3></div>
				<div><h3><input type="checkbox" id="box-removethumbs" url="&amp;removethumbs"><label for="box-removethumbs" class="gdcheckbox gdButton" tabindex="0"></label>Remove thumbnails</h3></div>
			</div>

			<img id="searchAdvSong" src="../../assets/btn-submit.png" height=13%; style="padding-top: 2vh;" id="settingsDivBtn" class="gdButton center closeWindow">
			<img class="closeWindow gdButton" src="../../assets/close.png" height="15%" style="position: absolute; top: -11.5%; left: -6vh">
		</div>
	</div>

	<div class="popup" id="devAppInfo">
		
		<div class="invisiblebox bounce center supercenter" id="devAppInfoBox" style="width: 130vh; height: 80%; background-color: #282737;">
			<div style="position: absolute; left: 0%; width: 133.4vh; left: -1.5%; top: -2.3%; border-top-right-radius: 2.2vh; border-top-left-radius: 2.2vh; overflow: hidden;"><img class="valign rightSpace dAlbum" src="data:image/svg+xml;charset=utf-8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100'><rect width='100%' height='100%' fill='rgba(0,0,0,0)'/></svg>" id="appImageBG" style="object-fit: cover; width: 135vh; height: 22.5vh; object-position: 0% 47%; background-color: #00000085;"></div>
			

			

			<h1 class="lessSpaced" style="font-size: 5.8vh; margin-top: 8.5%; margin-bottom: 4%; width: 90vh; "><img class="valign rightSpace dAlbum" src="../../assets/devapps/defaultDevApp.png" onerror="this.onerror=null; this.src='../../assets/devapps/defaultDevApp.png';" style="transform: translate(-160%, 0%); height: 23%;" id="devAppImage"><span style="position: absolute; transform: translate(-31%, 0%); width: 103vh; top: 17.6%; text-align: left; overflow: hidden;" id="appName">?</span></h1>
			
			<h3 class="lessSpaced" style="font-size: 3vh;margin-top: 0%;position: absolute;top: 95%;text-align: left;left: 8.5%;" id="songWarning"><img class="valign rightSpace" src="../../assets/exclamation.png" style="height: 4vh;"><cr>Warning:</cr> Songs uploaded from this platform may be unavailable.</h3>


			<h3 class="closeWindow lessSpaced" style="font-size: 4.6vh; margin-top: 1%; color: #ffbc3d;" title="Search songs from that artist"><span style="position: absolute; transform: translate(-39.5%, 0%); width: 103vh; top: 27.8%; text-align: left; pointer-events: none;"><span class="pre smaller inline gdButton help" id="appAuthor">?</span></span></h3>
			
			<div class="supercenter" style="top: 70%;height: 43%;padding-top: 2%;width: 70%;border: 0.7vh solid #00000075;background-color: #0000003b;border-radius: 5%;">
			
			
			<h3 class="lessSpaced" style="font-size: 3.5vh; margin-top: 1%;"><img class="valign rightSpace" src="../../assets/song/note.png" height="10%">SongID: <cg1 style="color:#ff75ff;"><span id="songID">0</span></cg1></h3>
			<h3 class="lessSpaced" style="font-size: 3.5vh; margin-top: 1%;"><img class="valign rightSpace" src="../../assets/smallinfo.png" height="10%">Size: <cg1 style="color:#ff75ff;"><span id="songID">0</span> MB</cg1></h3>
			<h3 class="lessSpaced" style="font-size: 3.5vh; margin-top: 1%;"><img class="valign rightSpace" src="../../assets/song/views.png" height="7%">Level(s) count: <cg1 style="color:#ff75ff;"><span id="songCount">0</span></cg1></h3>
			<h3 class="lessSpaced" style="font-size: 3.5vh; margin-top: 1%;"><img class="valign rightSpace" src="../../assets/site.png" height="10%">Platform: <cg1 style="color:#ff75ff;"><span id="songPlatform">?</span></cg1></h3>
			
				
			</div>

			<div class="supercenter" style="top: 85%; height: 5%; display: inline-flex; align-items: center;">
				<div class="gdsButton" onclick="playSong(this.getAttribute('src'))" src="none" id="songLink" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 3vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/song/playButton.png" height="80%">Play song</h3></div>
				<div class="gdsButton" onclick="copySongID(this.getAttribute('idSong'))" id="songCopyID" idSong="0" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 3vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/iconkitbuttons/copy.png" height="80%">Copy songID</h3></div>
				<div class="gdsButton" onclick="searchLevelSong(this.getAttribute('idSong'))" id="songLevelID" idSong="0" style="padding-left:1.5vh;padding-right:1.5vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/iconkitbuttons/copy.png" height="80%">Levels</h3></div>
			</div>

			
			<img class="closeWindow gdButton" src="../../assets/close.png" onclick="closeMessageCustomFrame()" height="15%" style="position: absolute; top: -10.5%; left: -6vh">

			
		
		</div>
	</div>


	<div class="popup" id="createApp">
		<form autocomplete="off" id="createAppForm" class="purplebox bounce center supercenter" style="width: 80vh; height: 42%">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Add a developer app</h2>
			<input type="text" name="act" value="create" hidden>
			<input type="text" name="token" id="partialCreateApptoken" value="" hidden>
			<input type="text" name="accountID" value="<?php echo isset($_SESSION['accountID']) ? $_SESSION['accountID'] : 0; ?>" hidden id="accountIDCreateApp">

			<h3 class="smaller" style="font-size: 5.5vh; margin-top: 1%">App name</h3>
			<input type="text" name="nameApp" required style="width:85%; margin: 1% 0% 1% 0%; height: 14%; text-align: center;"><br>

			<h3 class="smaller" style="font-size: 5.5vh; margin-top: 1%">App expiration
				<div onclick="CreateFLSelector('appExpdev','Select Difficulty')"><select class="gdsInput select" size="1" style="width:85%; height: 14%; text-align: center; margin-left: 5.5vh;" id="appExpdev" name="expireDate" required>
					<option value="-1" selected>Never</option>
					<option value="43200">12 hours</option> 
					<option value="86400">1 day</option> 
					<option value="604800">1 week</option>  
					<option value="3628800">6 weeks</option> 
					<option value="31536000">1 year</option> 
			</select></div></h3>

			<img style="margin-top: 2.8vh;" src="../../assets/btn-submit.png" height=13%; id="" class="gdButton center submitForm">

			<img class="closeWindow gdButton" src="../../assets/close.png" height="23%" style="position: absolute; top: -12.5%; left: -6vh">
		</form>
	</div>

	<div class="popup" id="activateApp">
		<form autocomplete="off" id="activateAppForm" class="bluebox bounce center supercenter" style="width: 75%; height: 88%; overflow-y: auto;">
			<h2 class="smaller center" style="font-size: 5.5vh; margin-top: 1%">Activate app</h2>
			<p>Developer apps will have <cg>permissions</cg> based on the <cy>moderator</cy> who added the app.</p>
			<p>You must send a <cg>POST</cg> request with the corresponding data in the <cg>HEADERS</cg> and <cg>BODY</cg>.</p>
			<p>Here are some code examples:</p>

			<input type="text" name="act" value="regenerate" hidden id="activateAppAct">
			<input type="number" name="id" value="0" hidden id="activateAppID">
			<input type="text" name="token" value="" hidden id="activateAppToken">

			<div class="codeApp-container">
				<div class="codeApp-tabs">
					<div class="codeApp-tab active" data-tab="php">PHP</div>
					<div class="codeApp-tab" data-tab="python">Python</div>
					<div class="codeApp-tab" data-tab="ruby">Ruby</div>
					<div class="codeApp-tab" data-tab="javascript">JavaScript</div>
					<div class="codeApp-tab" data-tab="java">JAVA</div>
				</div>
				<div class="codeApp-content active" id="php">
					<pre><code class="language-php line-numbers">
&lt;?php
	$headers = [
		"OGDW_APPTOKEN: YOUR_APP_TOKEN",
		"OGDW_APPNAME: YOUR_APP_NAME"
	];
	$data = [
		"activate" => "1", // Required
		"developerName" => "YOUR_DEV_NAME", // Required
		// "imageURLApp" => "YOUR_APP_IMAGE", // Optional
		// "nameApp" => "YOUR APP REAL NAME" // Optional
	];

	// Send request

	$ch = curl_init("https://yourdomain.com/browser/api/tokenApps.php");
	curl_setopt_array($ch, [
		CURLOPT_POST => true, CURLOPT_POSTFIELDS => $data,
		CURLOPT_HTTPHEADER => $headers,
		CURLOPT_RETURNTRANSFER => true
	]);

	// Print response
	echo curl_exec($ch);
	curl_close($ch);
?>

					</code></pre>
				</div>
				<div class="codeApp-content" id="python">
					<pre><code class="language-python">
import requests

headers = {
    "OGDW_APPTOKEN": "YOUR_APP_TOKEN",
    "OGDW_APPNAME": "YOUR_APP_NAME"
}

data = {
    "activate": "1",  # Required
    "developerName": "YOUR_DEV_NAME",  # Required
    # "imageURLApp": "YOUR_APP_IMAGE",  # Optional
	# "nameApp": "YOUR APP REAL NAME"  # Optional
}

# Send request
response = requests.post("https://yourdomain.com/browser/api/tokenApps.php", headers=headers, data=data)

# Print response
print(response.text)
					</code></pre>
				</div>
				<div class="codeApp-content" id="ruby">
					<pre><code class="language-ruby">
require 'net/http'
require 'uri'

uri = URI("https://yourdomain.com/browser/api/tokenApps.php")
headers = {
  "OGDW_APPTOKEN" => "YOUR_APP_TOKEN",
  "OGDW_APPNAME" => "YOUR_APP_NAME"
}

data = {
  "activate" => "1", # Required
  "developerName" => "YOUR_DEV_NAME", # Required
  # "imageURLApp" => "YOUR_APP_IMAGE", # Optional
  # "appName" => "YOUR APP REAL NAME" # Optional
}

# Send request
response = Net::HTTP.post_form(uri, data, headers)

# Print response
puts response.body
					</code></pre>
				</div>
				<div class="codeApp-content" id="javascript">
					<pre><code class="language-javascript">
const headers = { 
	OGDW_APPTOKEN: "YOUR_APP_TOKEN", 
	OGDW_APPNAME: "YOUR_APP_NAME" 
};
const postData =  { 
	activate: "1", //Required
	developerName: "YOUR_DEV_NAME", //Required
	// imageURLApp: "YOUR_APP_IMAGE", // Optional
	// nameApp: "YOUR APP REAL NAME" // Optional
};

// Send request and print response
fetch("https://yourdomain.com/browser/api/tokenApps.php", {
	method: "POST",
	headers: headers,
	body: new URLSearchParams(postData)
}).then(res => res.text()).then(console.log).catch(console.error);
					</code></pre>
				</div>
				<div class="codeApp-content" id="java">
					<pre><code class="language-java">
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

public class ApiRequest {
    public static void main(String[] args) {
        try {
            URL url = new URL("https://yourdomain.com/browser/api/tokenApps.php");
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setRequestMethod("POST");

            conn.setRequestProperty("OGDW_APPTOKEN", "YOUR_APP_TOKEN");
            conn.setRequestProperty("OGDW_APPNAME", "YOUR_APP_NAME");
            conn.setDoOutput(true);

            String data = "activate=1&developerName=YOUR_DEV_NAME"; // Required
            // data += "&imageURLApp=YOUR_APP_IMAGE"; // Optional
			// data += "&nameApp=YOUR%20REAL%20APP%20NAME"; // Optional

            // Send request
            try (OutputStream os = conn.getOutputStream()) {
                os.write(data.getBytes());
                os.flush();
            }

            // Read response
            int responseCode = conn.getResponseCode();
            System.out.println("Response Code: " + responseCode);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
					</code></pre>
				</div>
			</div>

			<p>App Name: <code id="appNameResult">...</code></p>
			<p>App Token: <code id="appTokenResult">...</code></p>

			<div style="top: 85%;height: 5%;display: ruby;align-items: center;justify-content: center; text-wrap: nowrap;">
				<div class="gdsButton blue" onclick="regenerateAppToken(document.getElementById('activateAppID').value)" src="none" id="songLink" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/new.png" height="80%">Regenerate token</h3></div>
				<div class="gdsButton" onclick="copyTokenApp(document.getElementById('appTokenResult').textContent)" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/iconkitbuttons/copy.png" height="80%">Copy token</h3></div>
				<div class="gdsButton" onclick="updateAppInfo(document.getElementById('activateAppID').value)" style="padding-left:1.5vh;padding-right:1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/refresh.png" height="80%">Refresh</h3></div>
				<div class="gdsButton red closeWindow" style="padding-left:1.5vh;padding-right:1vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect"><img class="valign rightSpace" src="../../assets/x.png" height="80%">Exit</h3></div>
			</div>

			<button type="button" class="submitForm" id="submitAppActive" hidden>
		</form>
	</div>


	<div class="popup" id="purgeDiv">
		<div class="fancybox bounce center supercenter" style="width: 35%; height: 28%">
			<h2 class="smaller center" style="font-size: 5.5vh">Delete All</h2>
			<p class="bigger center" style="line-height: 5vh; margin-top: 1.5vh;">
				Delete all saved online levels?<br><cy>Levels will be cleared from your browser.</cy>
			</p>
			<img src="../../assets/btn-cancel-green.png" height=25%; class="gdButton center closeWindow">
			<img src="../../assets/btn-delete.png" height=25%; id="purgeSaved" class="gdButton center sideSpaceB">
		</div>
	</div>

	<div class="popup" id="shuffleDiv">
		<div class="fancybox bounce center supercenter">
			<h2 class="smaller center" style="font-size: 5.5vh">Random Level</h2>
			<p class="bigger center" id="levelInfo" style="line-height: 5vh; margin-top: 1.5vh;">
				A random level cannot be picked with your current <cy>search filters!</cy>
				This is because there is no way to tell how many results were found, due to the GD servers inaccurately saying there's <cg>9999</cg>.
			</p>
			<img src="../../assets/ok.png" width=20%; class="gdButton center closeWindow">
		</div>
	</div>

	<div style="position:absolute; bottom: 0%; left: 0%; width: 100%">
		<img class="cornerPiece" src="../../assets/corner.png" width=7%;>
	</div>

	<div style="position:absolute; bottom: 0%; right: 0%; width: 100%; text-align: right;">
		<img class="cornerPiece noframe" src="../../assets/corner.png" width=7%; style="transform: scaleX(-1)">
	</div>

	<div id="searchBox" class="supercenter dragscroll">
		<div style="height: 4.5%"></div>
	</div>
	
	<div class="epicbox supercenter gs" style="width: 120vh; height: 80%; pointer-events: none;"></div>

	<div class="center noframe" style="position:absolute; top: 8%; left: 0%; right: 0%">
		<h1 id="header" style="position: absolute; left: 50%; transform: translate(-50%, 1280%);"></h1>
		
	</div>

	<div style="text-align: right; position:absolute; top: 1%; right: 2%">
		<h2 class="smaller noframe" style="font-size: 4.5vh" id="pagenum"></h2>
	</div>

	<div title="Search Song" style="text-align: right; position:absolute; top: 7.5%; right: 2%; height: 12%;">
		<img src="../../assets/magnify.png" height="60%" class="gdButton noframe" style="margin-top: 5%" onclick="$('#searchDiv').show();">
	</div>

	<div title="Jump to page" style="text-align: right; position:absolute; top: 15.5%; right: 1.5%; height: 11%;">
		<img src="../../assets/double-arrow.png" height="60%" class="gdButton noframe" style="margin-top: 5%" onclick="$('#pageDiv').show(); $('#pageSelect').focus().select()">
	</div>

	<div title="Jump to page" style="text-align: right; position:absolute; top: 23.5%; right: 2%; height: 12%;">
		<img src="../../assets/settingsbutton.png" height="60%" class="gdButton noframe" style="margin-top: 5%" onclick="$('#settingsDiv').show();">
	</div>

	<div style="position:absolute; top: 2%; left: 1.5%; width: 10%; height: 25%; pointer-events: none">
		<img class="gdButton yesClick noframe" id="backButton" src="../../assets/back.png" height="30%" onclick="backButton()">
	</div>

	<div id="purge" style="position:absolute; bottom: 1%; right: -3%; width: 10%; display:none;">
		<img class="gdButton noframe" src="../../assets/delete.png" width="60%" onclick="$('#purgeDiv').show()">
	</div>

	<div onclick="createApp()" title="Create new mappack" class="checkperm-mappacks" style="position:absolute; bottom: 15.5%; right: 1%; width: 15%; text-align: right;">
		<h3 style="transform: translate(3%, -5%);">Add App</h3>
		<img class="gdButton" src="../../assets/newBtn.png" width="40%" id="createMapPack"></a>
	</div>

	<div style="position:absolute; bottom: 2%; right: 1%; text-align: right; width: 15%;">
		<img class="gdButton noframe" src="../../assets/refresh.png" width="40%" id="refreshPage">
		<img onclick="$('#activateApp').show();" class="gdButton noframe" src="../../assets/info.png" width="40%" id="refreshPage">
	</div>

	<div style="position:absolute; bottom: 2%; right: 8.5%; text-align: right; width: 15%; display: none" id="gdWorld">
		<a title="Geometry Dash World" href="/search/*?type=gdw"><img class="gdButton" src="../../assets/gdw_circle.png" width="40%"></a>
	</div>

	<div style="position:absolute; bottom: 2%; right: 8.5%; text-align: right; width: 15%; display: none" id="normalGD">
		<a title="Back to Geometry Dash" href="/search/*?type=featured"><img class="gdButton" src="../../assets/gd_circle.png" width="40%"></a>
	</div>

	<div style="position: absolute; left: 7%; top: 45%; height: 10%;">
		<img class="gdButton noframe" id="pageDown" style="display: none"; src="../../assets/arrow-left.png" height="90%">
	</div>

	<div style="position: absolute; right: 7%; top: 45%; height: 10%;">
		<img class="gdButton noframe" id="pageUp" style="display: none"; src="../../assets/arrow-right.png" height="90%">
	</div>

	<div class="supercenter noframe" id="loading" style="height: 10%; top: 47%; display: none;">
		<!-- <img class="spin noSelect" src="../assets/loading.png" height="105%"> -->
	</div>

</div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch-jsonp/1.1.1/fetch-jsonp.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch-jsonp/1.1.1/fetch-jsonp.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="../../misc/global.js"></script>
<script type="text/javascript" src="../../misc/dragscroll.js"></script>
<script type="text/javascript" src="../../misc/gdcustomframe.js"></script>

<!-- Extensions -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<!-- PrismJS Language Plugins -->

<script src="https://unpkg.com/prismjs@1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>
<script> function devAppsErrorImg(img) { img.src = "../assets/devapps/defaultDevApp.png"; } 
	const imageAppMain = document.getElementById('devAppImage');

	

    const imageAppBG = document.getElementById('appImageBG');
    
    let colorThief = new ColorThief();

    imageAppMain.addEventListener('load', (event) => {
		console.log(event.target.src);

		let fileSrc = event.target.src;
		
		
			let color = colorThief.getColor(imageAppMain);
			let rgb = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
			console.log("Color: ", color, " rgb: ", rgb);
			imageAppBG.src = `data:image/svg+xml;charset=utf-8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100'><rect width='100%' height='100%' fill='${rgb}'/></svg>`;
		
      
    });

	const tabs = document.querySelectorAll('.codeApp-tab');
    const contents = document.querySelectorAll('.codeApp-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById(tab.dataset.tab).classList.add('active');
        });
    });

</script>
<script>
$("#loading-main").hide();

let serverType = "<?php print_r($serverType); ?>"
const MAX_API_REQUESTS = 10;
const TIME_API_WINDOW = 5000; // 5 segundos
let requestAPITimestamps = [];
const CACHE_EXPIRATION_TIME = 2 * 24 * 60 * 60 * 1000; 
const ORIGINAL_URL = window.location.href;

function WIPFunction() {
	CreateFLAlert("WIP","This feature is  `r0 not finished`, wait for  `g0 future updates!`");
}

function createApp() {
	$('#partialCreateApptoken').val(generateToken(16))
	$('#createApp').show();
}

function checkisActiveApp(isActive, appName, id){
	if(isActive > 0) return
	
	console.log("No active app ", id)
	
	$(`#devAppTitle${id}`).text(`${appName} (Unsigned)`)
	$(`#devNameSpan${id}`).text("App not active")
	$(`#devRequests${id}`).hide()


}

$('.addSongClass').click(function() { 
	$('#addSong').show();
})


$('#pageDown').hide()
$('#pageUp').hide()

let accID;
const urlParams = new URLSearchParams(window.location.search);
let url_browser = new URL(window.location.href)

let path = urlParams.get('str');
let filterSong = urlParams.get('filter');
let authorSong = urlParams.get('author');
let nounknown = urlParams.get('nounknown');
let nodiscord = urlParams.get('nodiscord');
let nodropbox = urlParams.get('nodropbox');
let nong = urlParams.get('nong');
let noroblibrary = urlParams.get('noroblibrary');
let nogdblibrary = urlParams.get('nogdlibrary');
let removeunused = urlParams.get('removeunused');
let removethumbs = urlParams.get('removethumbs');

let advURLFilter = '';

if (nounknown !== null) {advURLFilter += '&nounknown'; document.getElementById("box-nounknown").checked = true;}
if (nodiscord !== null) {advURLFilter += '&nodiscord'; document.getElementById("box-nodiscord").checked = true;}
if (nodropbox !== null) {advURLFilter += '&nodropbox'; document.getElementById("box-nodropbox").checked = true;}
if (nong !== null) {advURLFilter += '&nong'; document.getElementById("box-nong").checked = true;}
if (noroblibrary !== null) {advURLFilter += '&noroblibrary'; document.getElementById("box-noroblibrary").checked = true;}
if (nogdblibrary !== null) {advURLFilter += '&nogdlibrary'; document.getElementById("box-noogdlibrary").checked = true;}
if (removeunused !== null) {advURLFilter += '&removeunused'; document.getElementById("box-removeunused").checked = true;}
if (removethumbs !== null) {advURLFilter += '&removethumbs'; document.getElementById("box-removethumbs").checked = true; removethumbs = null;}
else {removethumbs = true;}

let legacyServer = true;
if(serverType != "legacy") legacyServer = false
if(path == null) path = "" + window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);

// if (!path || path.trim() === '') window.location.href = './search.php';
// if (path == "0") path = "*"
document.addEventListener('endLoadingItems', function(event) {
	if (new URLSearchParams(window.location.search).has('gdframe')) {
		$("#searchBox").hide()
		$("#scoreCustomTabs").hide()
		$("#leaderboardBox").hide()
		$('.noframe').hide();
		let songIDSelected = isNaN(Number(path)) ? 0 : Number(path)
		const $songElement = $(`#song${songIDSelected}`);
		if ($songElement.length) {$songElement.click();}
		else {
			$('#songInfo').show();
		}
		$('#songAuthor').css('pointer-events','none');
		$('#songInfoBox').removeClass('bounce');
	}
});


function profileRedirect(url) {
	var queryProfile = "";
    if (legacyServer == true) {
		queryProfile = "../../profile/?u=" + (encodeURIComponent(url).replace(/%2F/gi, "") || "");
	} else {
		queryProfile = "../../profile/" + (encodeURIComponent(url).replace(/%2F/gi, "") || "") 
	}
    if (queryProfile) window.location.href = "./u/" + queryProfile
}

function searchLevelsArtistRedirect(songID) {
	var queryLvl = "";
    if (legacyServer == true) {
		queryLvl = "/search/search.php/?s=0&songID="+ (encodeURIComponent(songID) || "0") + "&customSong";
	} else {
		queryLvl = "/search/0?songID="+ (encodeURIComponent(songID) || "0") + "&customSong";
	}
    if (queryLvl) window.location.href = ".." + queryLvl
}

//if (!path || path.trim() === '') path = '*';

let type = url_browser.searchParams.get('type')


let loading = false;

let page = Math.max(0, url_browser.searchParams.get('page'))

console.log(page);

let pages = 0
let results = 0
let legalPages = true
let gdwMode = false
let pageCache = {}
let apiURL = "../../api/tokenApps.php"
let searchFilters = apiURL + "?str=" + path + "&page=[PAGE]";


if(authorSong) { searchFilters = searchFilters + "&author=" + authorSong; }
if(filterSong) {
	searchFilters = searchFilters + "&filter=" + filterSong;
	document.getElementById(`tab-${filterSong}`).setAttribute("activetab","on");
}
searchFilters = searchFilters + advURLFilter;


// ---- Clean Text ----- //

function clean(text) {return ( text || "").toString().replace(/&/g, "&#38;").replace(/</g, "&#60;").replace(/>/g, "&#62;").replace(/=/g, "&#61;").replace(/"/g, "&#34;").replace(/'/g, "&#39;")}

// --- End --- //

function Append(firstLoad, noCache) {
	document.dispatchEvent(new Event('endLoadingItems'));
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

	debounceLoadingEvent(true);
	
	console.log("Levels:", res);

	res.forEach((x, y) => {
		console.log("INIT")
		changeLoadingAlert("Loading levels...");
		
		x.nameApp = clean(x.nameApp);
		x.developer.userName = clean(x.developer.userName);

		console.log("Loading levels...", x, y)
		
		$('#searchBox').append(`<div class="searchresult" style="height:25%;" title="${x.nameRGApp}" id="app${x.id}">
			<h1 title="${x.nameApp}" id="devAppTitle${x.id}" style="width: fit-content; padding-right: 1%; font-size: 5.5vh;">${(x.nameApp.length > 20 ? x.nameRGApp.substring(0,20) + '...' : x.nameApp) || " "}</h1>
			<h2 class="pre smaller inline gdButton help" title="Developer: ${x.developer}" style="margin-bottom: 2%; font-size: 3.9vh;"><span id="devNameSpan${x.id}" onclick="searchArtist('${btoa(encodeURIComponent(x.developer))}','1')">dev: ${x.developer}</span></h2>
			<h3 class="lessSpaced" style="width: fit-content;margin-bottom: 0.1%; font-size: 3vh;" title="${x.isAlive} requests(s) from this app">
				<span id="devRequests${x.id}"><img class="help valign rightSpace"  title="${x.isAlive} requests(s) from this app" src="../../assets/song/views.png" height="10%">${x.isAlive} request(s)</span>
				<br><img class="help valign rightSpace" title="AuthorID: ${x.requester.accountID}" src="../../assets/achievements/social.png" height="16%">added by: ${x.requester.userName}
			</h3>

			
		
			<div class="center" style="position:absolute; top: ${9 + (y * 26.5)}%; left: 4.4%; transform:scale(0.82); height: 10%; width: 12.5%;">


				<div class="difficultyBox">
					<img class="dAlbum" id="dFace${x.id}" src="${x.imageURLApp}" onerror="this.onerror=null; this.src='../../assets/devapps/defaultDevApp.png'; this.setAttribute('custom','0')" style="height:125%">
				</div>
			</div>

			<div class="center" style="position:absolute; right: 7%; transform:translateY(-13vh); height: 10%">
				<a title="View app" id="app${x.id}" onclick="${x.isAlive} > 0 ? showDevPanel('${btoa(encodeURIComponent(page))}','${btoa(encodeURIComponent(y))}') : showActiveAppPanelWithRegenerateToken('${btoa(encodeURIComponent(page))}','${btoa(encodeURIComponent(y))}')" ><img style="margin-bottom: 4.5%" class="valign gdButton" src="../../assets/view.png" height="105%"></a>
			</div>

		</div>`)

		checkisActiveApp(x.isAlive, x.nameApp, x.id);

		

	})

	$('#searchBox').append('<div style="height: 4.5%"></div>').scrollTop(0)
	$('#loading').hide()
	loading = false;
	document.dispatchEvent(new Event('endLoadingItems'));
	}
	
}

let debounceTimeout;
let debounceInitTimeout;
let tabToggle;

function setFilter(filter) {
	const scoreCustomTabsDiv = document.getElementById('scoreCustomTabs');
	
	scoreCustomTabsDiv.querySelectorAll('[id]').forEach(tab => {
    	if (tab.getAttribute("activetab") !== "disabled") tab.setAttribute("activetab", tab.id === filter ? "on" : "off");
	});
	
	const tabSelected = document.getElementById(filter);

	filter = filter.replace("tab-","")
	
	page = 0;
	searchFilters = apiURL + `?str=&filter=${filter}&page=[PAGE]` + advURLFilter;

	if(tabSelected.getAttribute("activetab") == tabToggle && filter == filterSong) {
		tabSelected.setAttribute("activetab","off");
		searchFilters = apiURL + `?str=&page=[PAGE]` + advURLFilter;
	}
	$('#header').text("");
	$('#tabTitle').text("Song Search")
	tabToggle = tabSelected.getAttribute("activetab");
	filterSong = filter;
	Append(true, true);
	pushNewStateURL();
}

function initLoadingEvent() {
	document.dispatchEvent(new Event('initLoadingAlert'));
	changeLoadingAlert("Loading songs...")
}

function finishLoadingEvent() {
	changeLoadingAlert("Songs loaded!","done")
	event = new Event('finishLoadingAlert');
	
	document.dispatchEvent(event);
}

function debounceLoadingEvent(type) {
    if (debounceTimeout && type) {
        clearTimeout(debounceTimeout);
    }
	if (type){ debounceTimeout = setTimeout(initLoadingEvent, 500); }
	else { debounceTimeout = setTimeout(finishLoadingEvent, 1000); }
}


function copyTokenApp(id){
	navigator.clipboard.writeText(id)
            .then(function() {
				document.dispatchEvent(new Event('initLoadingAlert'));
				changeLoadingAlert("App Token copied!","done");
				setTimeout(function() {
					document.dispatchEvent(new Event('finishLoadingAlert'));
				}, 1000);
            })
            .catch(function(error) {
				changeLoadingAlert("Error copying App Token","error");
                console.error('Fatal error using navigator.clipboard:', error);
            });
}

function searchLevelSong(songID) {
	if(document.getElementById("songLevelID").getAttribute("disabled")) return
	else searchLevelsArtistRedirect(songID);
}

function showDevPanel(a) {
	$('#devAppInfo').show();
}

function showActiveAppPanel(appName,appToken) {
	$('#appNameResult').text(appName);
	$('#appTokenResult').text(appToken);
	$('#activateApp').show();
	startActivateAppDev();
}

function regenerateAppToken(appID) {
	$('#activateAppAct').val("regenerate").attr("value", "regenerate");
	$('#activateAppID').val(appID);
	$('#activateAppToken').val(generateToken(16));
	$('#submitAppActive').trigger('click');
}

function updateAppInfo(appID) {
	$('#activateAppAct').val("refresh").attr("value", "refresh");
	if(appID) $('#activateAppID').val(appID);
	$('#activateAppToken').val("UPDATEINFO");
	$('#submitAppActive').trigger('click');
}

function showActiveAppPanelWithRegenerateToken(idDat,idObj) {
	idDat = decodeURIComponent(atob(idDat));
	idObj = decodeURIComponent(atob(idObj));
	let currentlyData = pageCache[idDat][idObj];

	regenerateAppToken(currentlyData.id);
	showActiveAppPanel(currentlyData.nameRGApp, currentlyData.token);
}

let intervalActivateAppDev;
function startActivateAppDev() {
    intervalActivateAppDev = setInterval(function() {
        if ($('#activateApp').is(':visible')) {
            // console.log("El elemento está visible.");
			updateAppInfo(0);
        } else {
            // console.log("El elemento está oculto.");
			stopActivateAppDev();
        }
    }, 15000);
}
function stopActivateAppDev() {
    clearInterval(intervalActivateAppDev);
}


function showSong(name,link,id,songAltName,author, songCount) {
	let textPlatform = "Unknown";
	name = decodeURIComponent(atob(name));
	link = decodeURIComponent(atob(link));
	id = atob(id);
	songAltName = decodeURIComponent(atob(songAltName));
	author = decodeURIComponent(atob(author));
	songCount = atob(songCount);
	if(link.includes("cdn.discordapp.com")) textPlatform = "Discord";
	else if (author.includes("ObeyGDMusic") || author.includes("ObeyGDBot") || link.includes("library.obeygdbot")) textPlatform = "ObeyGDMusic Library";
	else if(link.includes("audio.ngfiles.com")) textPlatform = "Newgrounds"; 
	else if(link.includes("dl.dropboxusercontent.com")) textPlatform = "Dropbox";
	else if(link.includes("geometrydashcontent.b-cdn.net")) textPlatform = "RobTop Music Library";

	const songData = getAlbumFromCache(songAltName);
	if (songData) {
		document.getElementById("songImageAuthor").setAttribute('custom',"1");
		document.getElementById("songImageAuthor").src = songData.artist.picture_big;
		document.getElementById("songImageAlbum").src = songData.album.cover_xl;
		document.getElementById("songImageAlbum").setAttribute('cover',"1");
		// No olvidar resetear los elements
	} else {
		document.getElementById("songImageAuthor").setAttribute('custom',"1");
		if (textPlatform == "ObeyGDMusic Library") document.getElementById("songImageAlbum").src = "../assets/song/ogdm-banner.png"; 
		else if (textPlatform == "Newgrounds") document.getElementById("songImageAlbum").src = "../assets/song/ng-banner-default.png"; 
		else {document.getElementById("songImageAlbum").src = "../assets/select.png"; document.getElementById("songImageAuthor").setAttribute('custom',"0");}
		document.getElementById("songImageAuthor").src = document.getElementById(`dFace${id}`).src;
	}

	if (textPlatform == "Discord" || textPlatform == "Unknown") $('#songWarning').show();
	else $('#songWarning').hide();

	document.getElementById("songLink").setAttribute('src',link);
	document.getElementById("songCopyID").setAttribute('idsong',id);
	document.getElementById("songName").textContent = name;
	document.getElementById("songAuthor").textContent = author;
	document.getElementById("songID").textContent = id;
	document.getElementById("songLevelID").setAttribute('idsong',id);
	if (songCount < 1) document.getElementById("songLevelID").setAttribute("disabled", "1");
	else document.getElementById("songLevelID").removeAttribute("disabled");
	document.getElementById("songCount").textContent = songCount;

	document.getElementById("songPlatform").textContent = textPlatform;
	$('#songInfo').show();
	
}

// ------- AutoScroll Song Page -------- // 
let scrollAnimationFrame;

function autoScroll(elementId, speed = 2, direction = 1) {
    const container = document.getElementById(elementId);
    const maxScrollLeft = container.scrollWidth - container.clientWidth;

    function scroll() {
        container.scrollLeft += speed * direction;
        if (container.scrollLeft >= maxScrollLeft || container.scrollLeft <= 0) direction *= -1;
        scrollAnimationFrame = requestAnimationFrame(scroll);
    }

    scroll();
}

function resetScroll(elementId) {
    cancelAnimationFrame(scrollAnimationFrame); 
    document.getElementById(elementId).scrollLeft = 0;
}


const scrollContainer = document.getElementById('appName');
scrollContainer.addEventListener('mouseenter', () => autoScroll('appName',3));
scrollContainer.addEventListener('mouseleave', () => resetScroll('appName',3));
// ------- End AutoScroll Song Page -------- // 

Append(true)


$('#pageUp').click(function() {page += 1; pushNewStateURL(); if (!loading) Append(false,true)})
$('#pageDown').click(function() {page -= 1; pushNewStateURL();  if (!loading) Append(false,true)})
//$('#lastPage').click(function() {page = (pages - 1); if (!loading) Append()})
$('#pageJump').click(function() {if (loading) return; page = parseInt(($('#pageSelect').val() || 1) - 1); pushNewStateURL(); Append()})
$('#refreshPage').click(function() { Append(false, true) } )

$('#searchSongBtn').click(function() { 
	tabToggle = "";
	tabFilter = "";
	page = 0;
	path = "" + document.getElementById("searchSong").value;

	searchFilters = apiURL + `?str=` + path + "&page=[PAGE]";
	$('#header').text(decodeURIComponent(path));
	$('#tabTitle').text(decodeURIComponent(path) + " - Song Search")

	const scoreCustomTabsDiv = document.getElementById('scoreCustomTabs');
	scoreCustomTabsDiv.querySelectorAll('[id]').forEach(tab => {
    	if (tab.getAttribute("activetab") !== "disabled") tab.setAttribute("activetab", "off");
	});
	
	Append(true, true);
	pushNewStateURL();
	
	} 
)

function searchArtist(str,encoded) {
	if(encoded == "1") str = decodeURIComponent(atob(str))
	searchFilters = apiURL + "?str=&author=" + str + "&page=[PAGE]" + advURLFilter;
	if(filterSong) searchFilters = searchFilters + "&filter=" + filterSong;
	Append(true, true);
	pushNewStateURL();
}

$('#songAuthor').click(function() {
	searchArtist($(this).text(),'0');
})

$('#searchAdvSong').click(function() {
	advURLFilter = "";
	page = 0;
	$("input:checked").each(function () {advURLFilter += $(this).attr('url')})
	searchFilters = apiURL + `?str=` + "&page=[PAGE]" + advURLFilter;
	if(advURLFilter.includes("removethumbs")) {removethumbs = null;}
	else {removethumbs = true;}
	if(filterSong) searchFilters = searchFilters + "&filter=" + filterSong;
	Append(true, true);
	pushNewStateURL();
})

function pushNewStateURL(){
	window.history.pushState(null, null, ORIGINAL_URL.slice(0,ORIGINAL_URL.lastIndexOf("?")) + searchFilters.replace("[PAGE]",page).replace(apiURL,""));
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
	if (path != "") {
		$('#header').text(decodeURIComponent(path))
		$('#tabTitle').text(decodeURIComponent(path) + " - Song Search")
	} else
		$('#header').text("")
}


$('.closeWindow').click(function() {
	$(".popup").attr('style', 'display: none;');
	stopActivateAppDev();
})

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

$(document).keydown(function(k) {
	if (loading) return;

	if ($('#pageDiv').is(':visible')) {
		if (k.which == 13) $('#pageJump').trigger('click') //enter 
		else return;
	}

    if (k.which == 37 && $('#pageDown').is(":visible")) $('#pageDown').trigger('click')   // left
	if (k.which == 39 && $('#pageUp').is(":visible")) $('#pageUp').trigger('click')       // right

});

$('.submitForm').click(function() {
	document.dispatchEvent(new Event('initLoadingAlert'));

	if ( $('.box-auto').prop("checked") == false ){
		$('.box-auto').prop("checked",true);
		$('.box-auto').val("0");
	}
	
	let formJquery = $(this).closest('form');
    let form = document.getElementById(formJquery.attr('id'));

	let typeact = formJquery.find('[name="act"]').attr('value'); 

	console.log(form)
	console.log(typeact)

	form.dispatchEvent(new Event('submit'));
    if (form.checkValidity()) {
        let formData = new FormData(form);

		console.log("submiting data", formData)

        fetch('../../api/tokenApps.php', {
            method: 'POST',
            body: formData,
			credentials: 'include'
        })
        .then(response => {$('.box-auto').prop("checked",false); $('.box-auto').val("1"); return response.text();})
        .then(data => {
			try {
				data = JSON.parse(data); 
			} catch(err) {
				console.log("Data Response: ", data);
				console.error("Error in JSON Structure");
			}
			console.log("Data Response: ", data);
			if(data.sucess != "false") {
				
				if(typeact == "create") {
					changeLoadingAlert("App created!","done");
					$(`#${$(this).closest('form').attr('id')}`).find('input, textarea, select').not('[name="act"]').val('');
					$(this).closest('.popup').hide();
					$('#refreshPage').trigger('click');
					showActiveAppPanel(data.nameApp, data.token);
				} else if(typeact == "regenerate") {
					changeLoadingAlert("Token regenerated!","done");
					$('#appTokenResult').text(data.token);
				} else if(typeact == "refresh") {
					changeLoadingAlert("App information updated!","done");
					if(data[0].isAlive >= 1) {
						$(this).closest('.popup').hide();
						$('#refreshPage').trigger('click');
						CreateFLAlert("App activated!","`g0 Application successfully activated` by `a0 developer`.\n# **Read the ObeyGDBrowser API documentation:**\n _ `a0 [ObeyGDBrowser API Docs](../../api/index.html) ` _")
					}
					
				}

				// changeLoadingAlert(`${data.message}`,"done");
				// CreateFLAlert("Song Uploaded!","Your song ID: `a0 **" + data.songID + "**`")
				// $(`#${$(this).closest('form').attr('id')}`).find('input, textarea, select').not('[name="act"]').val('');
				// $(this).closest('.popup').hide();
			}
			else {
				changeLoadingAlert(`${data.error}`,"error");
			}
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1500);
			
        })
        .catch(error => {
			changeLoadingAlert(`${error}`,"error");
            console.error('Error:', error);
			setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1500);
        });
		
		
    } else {
		changeLoadingAlert("Data not completed!","error");
        form.reportValidity();
		setTimeout(function() { document.dispatchEvent(new Event('finishLoadingAlert')); }, 1200);
    }
})

</script>