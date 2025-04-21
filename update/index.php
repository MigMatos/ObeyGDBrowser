<?php


include("../_init_.php");


if ($isAdmin != "1" || $logged != true) {

} else {
    $source = "../ogbrowser_init_updater.php";
    $destination = "../../ogbrowser_init_updater.php";

    
    $content = file_get_contents($source);

    if ($content !== false) {
        file_put_contents($destination, $content);
    }

}

?>



<head>
    <title>OGDW Updater</title>
    <link rel="icon" href="../assets/settings.png" type="image/png">
	<meta charset="utf-8">
	<link href="../assets/css/browser.css?v=<?= $_OBEYGDBROWSER_FILEVERSION; ?>" type="text/css" rel="stylesheet">
	<?php
		include("../assets/htmlext/flayeralert.php");
    ?>

</head>

<style>

.gitbody {
    scrollbar-width: thin;
    scrollbar-color: #fff transparent;
}

.progress-container {
    position: relative; 
    width: 60vh; 
    height: 5vh;
}

.progress-bar {
    position: absolute;
    top: 0;
    left: 0;
    width: 97.7%;
    height: 50%;
    background-image: url('../assets/sliderBar.png');
    background-repeat: repeat-x; 
    background-size: contain; 
    z-index: 1;
}

.progress-contour {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transform: translate(-1.3%, -10.5%);
    z-index: 2;
}


.progress-bar {
    z-index: 1; 
    clip-path: inset(0 100% 0 0); 
    transform: translate(0%, 30.5%);
}

.center-div {
    margin: 0 25% 0 25%;
}

.updateBox {
    background: rgb(0 0 0 / 40%);
    padding: 3vh;
    border-radius: 5vh;

    border: 0.3vh solid #ffffff;
    filter: drop-shadow(2px 4px 6px black);
}


.updateObjAnimation {
    mix-blend-mode: hard-light;
    animation: pulseAndRotate 2.2s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
    transform-origin: center;
}

.searchingObjAnimation {
    mix-blend-mode: hard-light;
    animation: pulse 2.2s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
    transform-origin: center;
}

@keyframes pulseAndRotate {
  0% {
    -webkit-transform: rotate(0deg) scale(1);
    transform: rotate(0deg) scale(1);
  }
  50% {
    -webkit-transform: rotate(180deg) scale(1.2);
    filter: saturate(2.5) brightness(1.1);
    transform: rotate(180deg) scale(1.2);
  }
  100% {
    -webkit-transform: rotate(360deg) scale(1);
    transform: rotate(360deg) scale(1);
  }
}

@keyframes pulse {
  0%,100% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }
  50% {
    -webkit-transform: scale(1.2);
    filter: saturate(2.5) brightness(1.1);
    transform: scale(1.2);
  }
}

.hide-smooth {
    opacity: 0;
    transform: scale(0.95);
    transition: opacity 0.3s ease, transform 0.3s ease;
    pointer-events: none;
}

.hide-smooth.hidden {
    display: none !important;
}

.show-smooth {
    opacity: 0;
    transform: scale(0.95);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.show-smooth.visible {
    opacity: 1;
    transform: scale(1);
}

@keyframes lowBackgroundBrightness {
  from {
    backdrop-filter: brightness(1);
  }
  to {
    backdrop-filter: brightness(0.7);
  }
}

.low-background-brightness {
    animation: lowBackgroundBrightness 3s forwards;
}

</style>


<body class="levelBG" style="background-image: linear-gradient(#6e00fd, #000973);" onbeforeunload="saveUrl()">
<div id="everything" style>

    

	<div id="data-info-0" class="transparentBox center supercenter updateBox" style="width: 135vh;height: 82%;margin-top: -0.7%;overflow-y: auto;overflow-x: clip;display: flex;flex-direction: column; align-items: center;justify-content: space-between;">
		
		<div class="center-div" style="padding: 2% 0 5% 0;height: auto;">
			<img id="progress-rotate" class="noSelect searchingObjAnimation" src="../assets/settings.png" style="height: 13vh;"><h3 id="progress-info">Please wait...</h3>
			<div style="display: none;" id="div-progress-bar"><div style="display:flex;">
				<div class="progress-container">
					<div id="progress-bar-img" class="progress-bar"></div>
					<img class="progress-contour" src="../assets/slider.png">
				</div>
				<h3 id="progress-bar-text">0%</h3></div>
			</div>
			<div id="last-version-div" style="display:none;justify-content: center;transform: scale(0.85);">
                <h3 id="last-version-txt">Version: <cg id="last-version">?</cg></h3>
            </div>
		</div>

		<p class="font-helvetica gitbody" id="body-github" style="white-space: normal; line-height: 1.5; background-color: #00000075;width: 70%;height: 40.5%;/* margin-left: 50%; *//* transform: translate(-50%, 0); */font-size: 2.3vh;overflow: auto;padding: 0 5% 0 5%;border-radius: 3.5vh;"></p>

        <div id="data-info-1" class="center-div" style="width: 44%; display: flex; align-items: center;">

        <div style="width: 40%;transform: translate(-145%, 10%);">
            <h3>Branch:</h3>
            <div onclick="CreateFLSelector('updateType','Update branch')" style="cursor: pointer; width: 100%; padding: 0% 3% 0% 3%">
                <select class="gdsInput select" id="updateType" size="1" style="font-size: 2.6vh;" readonly="">
                    <option value="0">Stable</option>
                    <option value="1">Pre-release</option>
                    <option value="2">Unstable</option>
                </select>
            </div>
            <div class="gdsButton" id="buttonLog" onclick="openLogs()" style="width: 65%;transform: translate(25%, 25%);"><h3 class="gdfont-Pusab">Logs</h3></div>
        </div>

        <div class="gdsButton" id="buttonUpdate" onclick="updateOGDWCore()" style="width: 40%;transform: translate(-35%, -10%);" disabled="" readonly><h3 class="gdfont-Pusab">Update</h3></div>

        </div>

        
        <div id="data-info-2" style="display:flex;"><h3>Actual version: <ca id="act-version"><?php print_r($_OBEYGDBROWSER_VERSION); ?></ca></h3></div>
	</div>

    

    <img class="gdButton yesClick" id="backButton" src="../assets/back.png" onclick="backButton()" tabindex="1" style="position: absolute; height: 7%; margin: 0% 0% 0% 4%;">

</div>
</body>

<script type="text/javascript" src="../misc/jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="../misc/global.js?v=<?= $_OBEYGDBROWSER_FILEVERSION; ?>"></script>
<script type="text/javascript" src="../misc/updater.js?v=<?= $_OBEYGDBROWSER_FILEVERSION; ?>"></script>
<script>

const progressInfo = document.getElementById('progress-info');
document.addEventListener('DOMContentLoaded', function() { 
    const url = new URL(window.location.href);
    const params = new URLSearchParams(location.search);
    let encodedChangeLog = params.get('changelog');
    let changelogDecoded = "";

    if (encodedChangeLog) {
        try {
            changelogDecoded = decodeURIComponent(atob(encodedChangeLog));
            encodedChangeLog = "";
        } catch (e) {console.warn('Invalid changelog Base64:', e);}
    }
    
    if (url.searchParams.has('changelog')) {
        url.searchParams.delete('changelog');
        window.history.replaceState({}, '', url.pathname + url.search + url.hash);
        CreateFLAlert("Welcome to <?php print_r($_OBEYGDBROWSER_VERSION) ?> version!",`### ´g0 CHANGELOG´\n${changelogDecoded}`);
    }
	const branchSelected = localStorage.getItem('branchSelected') || 0;
	document.getElementById("updateType").selectedIndex = branchSelected;
	fetchUpdate(branchSelected);
	document.addEventListener('FLlayerclosed', function() {
        try {
		const selectedValue = document.getElementById(FLIDSelect).value;
		if (selectedValue == 1) CreateFLAlert("Warning","Pre-release updates may **contain beta or alpha updates**.\n\n\n- `a0 Beta:` is a version with new features and some bugs.\n- `r0 Alpha:` is an early-stage version with new, incomplete features and bugs.")
		else if (selectedValue == 2) CreateFLAlert("Warning","Unstable updates are **usually unstable, incomplete and unsafe**, these are `r0 not recommended` and their use is mostly for developers.")
		fetchUpdate(selectedValue);
        } catch (e) {
            console.error(e);
        }
	});
});

function openLogs() {
    const url = './log.txt';
    window.open(url, '_blank');
}


let lru_branch = null;
let version_branch = null;
let date_branch = null;
let data_changelog = "";

function fetchUpdate(branch) {
	localStorage.setItem('branchSelected', branch);
    document.getElementById('progress-rotate').classList.add("searchingObjAnimation");
	progressInfo.textContent = "Fetching version..."
    progressInfo.style.color = 'white';
	if(branch == 0) branch = "latest"
	else if(branch == 1) branch = "prerelease";
	else if(branch == 2) branch = "master"
	else branch = "latest"

	fetchGithubVersion('migmatos', 'ObeyGDBrowser', branch, '<?php print_r($_OBEYGDBROWSER_VERSION) ?>' , '<?php print_r($_OBEYGDBROWSER_BINARYVERSION) ?>')
		.then(result => {
			console.log(result);
            document.getElementById('progress-rotate').classList.remove("searchingObjAnimation");
            document.getElementById('progress-rotate').style.filter = "";
			progressInfo.textContent = "Loading version information..."
            if (!result.data) {
				progressInfo.textContent = "No updates available";
                document.getElementById('progress-rotate').style.filter = "grayscale(1)";
                document.getElementById('last-version').textContent = "-";
                document.getElementById('last-version-div').style.display = "none";
				document.getElementById('buttonUpdate').setAttribute('disabled','');
				document.getElementById('buttonUpdate').setAttribute('readonly','');
                document.getElementById('body-github').innerHTML = processHTMLtoMarkdown("`(without description)`")
				return;
			} 
			lru_branch = result.data.zipball_url;
            version_branch = result.data.tag_name;
            date_branch = result.data.version_date;
			if(lru_branch) {
				document.getElementById('buttonUpdate').removeAttribute('disabled');
				document.getElementById('buttonUpdate').removeAttribute('readonly');
                document.getElementById('last-version').textContent = result.data.tag_name;
                document.getElementById('last-version-div').style.display = "flex";
                progressInfo.textContent = "New update available!";
                if(result.data.body){ 
                    document.getElementById('body-github').innerHTML = processHTMLtoMarkdown(result.data.body);
                    data_changelog = result.data.body;
                } else { document.getElementById('body-github').innerHTML = processHTMLtoMarkdown("`(without description)`") }
			} else {
                progressInfo.textContent = "Error getting update file";
                document.getElementById('progress-rotate').style.filter = "grayscale(1)";
                document.getElementById('last-version').textContent = "-";
                document.getElementById('last-version').style.display = "none";
				document.getElementById('buttonUpdate').setAttribute('disabled','');
				document.getElementById('buttonUpdate').setAttribute('readonly','');
            }
		});
}

let currentPercentage = 0; 
let animationFrameId;
let queue = []; 
checkProgressBarPoll = null;

let resultState = null;
let lastChangeTime = Date.now();

function setResultState(newValue) {
  const now = Date.now();
  if (now - lastChangeTime < 3000) {
    console.log("Ignorating new results...");
    return;
  }
  if (newValue !== resultState) {
    resultState = newValue;
    lastChangeTime = now;
    console.log("New resultState:", resultState);
  }
}


function updateOGDWCore(){
    initAnimationUpdate();
	initUpdaterServer();
}

function initAnimationUpdate() {
    progressInfo.style.color = 'white';
	progressInfo.textContent = "Initializing updater...";
	document.getElementById('div-progress-bar').style.display = "flex";
	document.getElementById('progress-rotate').classList.add("updateObjAnimation");
    const toHide = ['data-info-1', 'data-info-2', 'backButton'].map(id => document.getElementById(id));
    toHide.forEach(el => {
        el.classList.add('hide-smooth');
        setTimeout(() => el.classList.add('hidden'), 350);
        el.classList.remove('show-smooth');
        setTimeout(() => el.classList.remove('visible'), 350);
    });

    document.getElementById('data-info-0').style.justifyContent = 'space-evenly';
    document.getElementById('everything').classList.add('low-background-brightness');

    const progressBar = document.getElementById('div-progress-bar');
    progressBar.style.display = 'block';
    progressBar.classList.add('show-smooth');
    progressBar.classList.remove('hide-smooth');
    setTimeout(function() {progressBar.classList.add('visible'); progressBar.classList.remove('hidden');}, 10);
}

function initUpdaterServer() {
	let xhr = new XMLHttpRequest();
	xhr.open('POST', '../../ogbrowser_init_updater.php', true);
	xhr.withCredentials = true;
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // ignorating hehe...
        } else if (xhr.status === 250) {
            console.log("Finished successfully");
            finishedUpdate();
        } else if (xhr.status === 401) {
            console.error("Error 401 | " + xhr.responseText);
            errorUpdate(xhr.responseText);
        } else {
            console.error("Error " + xhr.status + ": " + xhr.statusText);
            errorUpdate(xhr.responseText);
        }
    };

    xhr.onerror = function() {
        errorUpdate(xhr.responseText);
        console.error("Request failed. Please check your network connection or ogdbrowser_init_updater.php dont exist.");
    };

	let data = `lru=${encodeURIComponent(lru_branch)}&ver=${encodeURIComponent(version_branch)}&date=${encodeURIComponent(date_branch)}`;
	xhr.send(data);
	checkProgressBarPoll = setInterval(checkProgressBar, 150);
}

function checkProgressBar() {
	console.log("checking progress bar");
	fetch('./log.txt') 
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text(); 
        })
        .then(text => {
            const lastLine = text.trim().split('\n').pop(); 
            
            let [info, percentage] = lastLine.split('|');
            percentage = percentage ? percentage.replace('%', '') : '0%';
            info = info ? info.trim() : '';

            const percentageValue = parseFloat(percentage.trim());
            if(!isNaN(percentageValue) && percentageValue >= 100) {
                // console.log("Finished successfully");
                // finishedUpdate();
            }
            else if (!isNaN(percentageValue) && percentageValue >= 0 && percentageValue <= 100) {
                progressBarPercentage(percentageValue);
                progressInfo.textContent = info;
            }
            
        })
        .catch(error => {
            console.error('Error reading file:', error);
        });
}

function errorUpdate(data) {
    clearInterval(checkProgressBarPoll);
    setResultState(false);
    if(resultState) return;
    setTimeout(function() {
        progressInfo.textContent = data;
        progressInfo.style.color = 'red';
        document.getElementById('progress-rotate').classList.remove("updateObjAnimation");

        const toShow = ['data-info-1', 'data-info-2', 'backButton'].map(id => document.getElementById(id));
        toShow.forEach(el => {
            el.classList.remove('hide-smooth');
            el.classList.remove('hidden');
            el.classList.add('show-smooth');
            setTimeout(() => el.classList.add('visible'), 350);
        });

        document.getElementById('data-info-0').style.justifyContent = 'flex-start';
        document.getElementById('everything').classList.remove('low-background-brightness');

        const progressBar = document.getElementById('div-progress-bar');
        progressBar.classList.remove('show-smooth');
        progressBar.classList.remove('visible');
        progressBar.classList.add('hide-smooth');
        setTimeout(() => progressBar.classList.add('hidden'), 350);



        // document.getElementById('body-github').style.height = "40.5%";
        document.getElementById('progress-rotate').classList.remove('updateObjAnimation');
    }, 350);
}

function finishedUpdate() {
    clearInterval(checkProgressBarPoll);
    setResultState(true);
    if(!resultState) return;
    setTimeout(function() {
        progressInfo.textContent = "Finishing update...";
        progressInfo.style.color = '#00ff22';
        // document.getElementById('buttonLog').removeAttribute('disabled');
        // document.getElementById('buttonLog').removeAttribute('readonly');
        // document.getElementById('body-github').style.height = "40.5%";
        document.getElementById('div-progress-bar').style.display = "none";
        // document.getElementById('last-version').textContent = "";
        document.getElementById('last-version-txt').innerHTML = "<cg>Applying changes, please wait...</cg>"
    }, 350);
    setTimeout(function() {
        progressInfo.textContent = "Updated!";
        progressInfo.style.color = '#00ff22';
        document.getElementById('progress-rotate').classList.remove('updateObjAnimation');
        document.getElementById('last-version-txt').innerHTML = "<cg>Restarting updater...</cg>"
    }, 2500);
    setTimeout(function() {
        const url = new URL(window.location.href);
        url.searchParams.set('changelog', btoa(encodeURIComponent(data_changelog)) );
        window.location.href = url.toString();
    }, 4000)
}



function progressBarPercentage(newPercentage) {
    newPercentage = isNaN(parsedFloat = parseFloat(newPercentage)) ? null : Math.round(parsedFloat);
    if (isNaN(newPercentage) || newPercentage < 0 || newPercentage > 100) {
        console.error("ProgressBarError: The percentage must be an integer between 0 and 100.");
        return;
    } else if (currentPercentage == newPercentage) return;
    queue.push(newPercentage);
    if (animationFrameId) {
        return;
    }


    processQueue();
}

function processQueue() {

    if (queue.length === 0) {
        return;
    }

    const targetPercentage = queue.pop();
    queue = [];

    const startPercentage = currentPercentage;
    const duration = 1000; 
    const stepTime = 10; 
    const steps = Math.abs(targetPercentage - startPercentage) * (1000 / duration);

    let step = 0;

    function animate() {
        step++;
        const progress = startPercentage + (step / steps) * (targetPercentage - startPercentage);
        currentPercentage = progress;
        const clippedPercentage = 100 - currentPercentage;
        
        document.getElementById('progress-bar-img').style.clipPath = `inset(0 ${clippedPercentage}% 0 0)`;
		document.getElementById('progress-bar-text').textContent = currentPercentage.toFixed(0) + "%";

        if (step < steps) {
            animationFrameId = requestAnimationFrame(animate);
        } else {
            animationFrameId = null; 
            currentPercentage = targetPercentage;
            processQueue(); 
        }
    }

    animationFrameId = requestAnimationFrame(animate);
}



</script>
