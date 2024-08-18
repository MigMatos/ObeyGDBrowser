<head>
	
	<meta charset="utf-8">
	<link href="../assets/css/browser.css" type="text/css" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135255146-3"></script><script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-135255146-3');</script>
	<!-- <link href="https://cdn.obeygdbot.xyz/css/dashboard.css?v=14" rel="stylesheet"> -->	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
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
    width: 97.2%;
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
    transform: translate(-1.4%, -18.5%);
    z-index: 2;
}


.progress-bar {
    z-index: 1; 
    clip-path: inset(0 100% 0 0); 
}

.progress-contour {
    z-index: 2; 
}

.center-div {
    margin: 0 25% 0 25%;
}

</style>
s

<body class="levelBG">
<div class="everything">

	<div class="brownBox center supercenter" style="width: 135vh; height: 82%; margin-top: -0.7%">
		<div style="display:flex;"><h3>Actual version: <cg id="act-version">?</cg></h3><h3 style="margin-left: 3%">Lasted version: <cg id="last-version">?</cg></h3></div>
		<div class="center-div" style="padding: 2% 0 2% 0;">
			<img id="progress-rotate" class="noSelect" src="../assets/settings.png" height="20%"><h3 id="progress-info"></h3>
			<div style="display: none;" id="div-progress-bar">
				<div class="progress-container">
					<div id="progress-bar-img" class="progress-bar"></div>
					<img class="progress-contour" src="../assets/slider.png">
				</div>
				<h3 id="progress-bar-text">0%</h3>
			</div>
			
		</div>

		<p class="font-helvetica gitbody" id="body-github" style="background-color: #00000075;width: 65%;height: 35%;margin-left: 50%;transform: translate(-50%, 0); font-size: 2.3vh; overflow: auto; padding: 0 5% 0 5%; border-radius: 3.5vh;"></p>

		<div class="center-div" style="display: flex; align-items: center; width: 44%; padding: 2% 0 2% 0;">

			<h3>Branch:</h3>
			<div onclick="CreateFLSelector('updateType','Update branch')" style="width: 100%; padding: 0% 3% 0% 3%">
				<select class="gdsInput select" id="updateType" size="1" readonly>
					<option value="0">Stable</option>
					<option value="1">Pre-release</option>
					<option value="2">Unstable</option>
				</select>
			</div>
			
			<div class="gdsButton" id="buttonUpdate" onclick="playSong(this.getAttribute('src'))" style="width:90%;" disabled><h3 class="gdfont-Pusab">Update</h3></div>
		</div>
	
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>


<script>

const progressInfo = document.getElementById('progress-info');
document.addEventListener('DOMContentLoaded', function() { 
	const branchSelected = sessionStorage.getItem('branchSelected') || 0;
	document.getElementById("updateType").selectedIndex = branchSelected;
	fetchUpdate(branchSelected);
	document.addEventListener('FLlayerclosed', function() {
		const selectedValue = document.getElementById(FLIDSelect).value;
		if (selectedValue == 1) CreateFLAlert("Warning","Pre-release updates may **contain beta or alpha updates**.\n\n\n- `a0 Beta:` is a version with new features and some bugs.\n- `r0 Alpha:` is an early-stage version with new, incomplete features and bugs.")
		else if (selectedValue == 2) CreateFLAlert("Warning","Unstable updates are **usually unstable, incomplete and unsafe**, these are `r0 not recommended` and their use is mostly for developers.")
		fetchUpdate(selectedValue);
	});
});

async function fetchGithubVersion(owner, repo, branchType) {
    // Función para leer la versión actual y la fecha desde el archivo version.txt
    async function getCurrentVersionAndDate() {
        try {
            const response = await fetch('./version.txt');
            const text = await response.text();
            const [version, date] = text.trim().split('|').map(part => part.trim());
            return { version: version.trim(), date: date ? new Date(date.trim()) : new Date(0) };
        } catch (error) {
            console.error("Error reading version.txt:", error);
            return { version: null, date: new Date(0) };
        }
    }

    const isNewerThan = (date1, date2) => date1 > date2;

    try {
        const { version: currentVersion, date: currentDate } = await getCurrentVersionAndDate();

		console.log(currentDate);
		
        if (currentVersion === null || currentDate === null) {
            console.error("No se pudo obtener la versión actual o la fecha.");
            return {currentVersion: 0};
        } 

        if (branchType === 'master') {
            const masterResponse = await fetch(`https://api.github.com/repos/${owner}/${repo}/branches/master`);
            const masterData = await masterResponse.json();
            masterData.tag_name = masterData.commit.sha.substring(0, 10) + "-master"; 
            masterData.zipball_url = `https://github.com/${owner}/${repo}/archive/refs/heads/master.zip`;
			masterData.body = null;
			const latestDate = new Date(masterData.commit.commit.committer.date)
			if (isNewerThan(latestDate, currentDate)){
				masterData.version_date = latestDate.toISOString();
				return {
					type: 'master',
					currentVersion: currentVersion,
					data: masterData
				};
			} else {
				console.log(`La versión ${branchType} está actualizada.`);
                return null;
			}
        } else if (branchType === 'latest') {
            // Obtener la última versión estable
            const latestResponse = await fetch(`https://api.github.com/repos/${owner}/${repo}/releases/latest`);
            const latestData = await latestResponse.json();
            const latestVersion = latestData.tag_name; 
            const latestDate = new Date(latestData.created_at);

            if (latestVersion !== currentVersion || isNewerThan(latestDate, currentDate)) {
                return {
                    type: 'latest',
					currentVersion: currentVersion,
                    data: latestData
                };
            } else {
                console.log(`La versión ${branchType} está actualizada.`);
                return null;
            }
        } else if (branchType === 'prerelease') {
            const releaseResponse = await fetch(`https://api.github.com/repos/${owner}/${repo}/releases`);
            const releases = await releaseResponse.json();
            const prerelease = releases.find(release => 
                release.prerelease && 
                (release.tag_name.replace(/^v/, '') !== currentVersion || 
                isNewerThan(new Date(release.created_at), currentDate))
            );

            if (prerelease) {
                const prereleaseVersion = prerelease.tag_name;
                const prereleaseDate = new Date(prerelease.created_at);

                return {
                    type: 'prerelease',
					currentVersion: currentVersion,
                    data: prerelease
                };
            } else {
                console.log(`No hay prerelease más reciente que la versión actual.`);
                return null;
            }
        }
    } catch (error) {
        console.error("Error fetching version from GitHub:", error);
    }
}

let lru_branch = null;

function fetchUpdate(branch) {
	sessionStorage.setItem('branchSelected', branch);

	progressInfo.textContent = "Fetching version..."
	if(branch == 0) branch = "latest"
	else if(branch == 1) branch = "prerelease";
	else if(branch == 2) branch = "master"
	else branch = "latest"

	fetchGithubVersion('migmatos', 'ObeyGDBrowser', branch)
		.then(result => {
			console.log(result);
			document.getElementById('act-version').textContent = result.currentVersion ? result.currentVersion : '?';
			if (result.data === null) {
				progressInfo.textContent = "No updates available";
				document.getElementById('buttonUpdate').setAttribute('disabled','');
				document.getElementById('buttonUpdate').setAttribute('readonly','');
				return;
			}
			
			progressInfo.textContent = "Loading version information..."
			document.getElementById('last-version').textContent = result.data.tag_name;
			progressInfo.textContent = "New update available!";
			if(result.data.body){
				document.getElementById('body-github').innerHTML = sanitizerCode(processHTMLContent(result.data.body));
			} else {
				document.getElementById('body-github').innerHTML = "(without description)"
			}
			lru_branch = result.data.zipball_url;
			if(lru_branch) {
				document.getElementById('buttonUpdate').removeAttribute('disabled');
				document.getElementById('buttonUpdate').removeAttribute('readonly');
			}
		});
}

let currentPercentage = 0; 
let animationFrameId;
let queue = []; 

function updateOGDWCore(){
	progressInfo.textContent = "Initializing updater...";
	document.getElementById('div-progress-bar').style.display = "flex";
	document.getElementById('progress-rotate').classList.add("spin");
	pollingInterval = setInterval(pollServer, 500);
	// let xhr = new XMLHttpRequest();
	// xhr.open('POST', '../../ogbrowser_init_updater.php', true);
	// xhr.withCredentials = true;
	// xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

}

function pollingServer() {
    fetch('../../ogbrowser_init_updater.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `lru=${lru_branch}`,
        credentials: 'include'
    })
    .then(response => response.text())
    .then(text => {
        console.log('Respuesta del servidor:', text);
        document.getElementById('resultado').textContent += text + '\n';

        // Verificar si el procesamiento está completo
        if (text.includes('FINISHIED...')) {
            clearInterval(pollingInterval); // Detener el polling
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        clearInterval(pollingInterval); // Detener el polling en caso de error
    });
}

// updateOGDWCore();

// function testClipPathAnimation() {
//     let percentage = 0;
	
//     function incrementPercentage() {
//         if (percentage <= 100) {
//             progressBarPercentage(percentage);
//             percentage++;
//             setTimeout(incrementPercentage, 50); // Ajusta el retardo para controlar la velocidad (50ms)
//         }
//     }

//     incrementPercentage();
// }




function progressBarPercentage(newPercentage) {
    // Asegurar que solo se acepten números enteros
    if (!Number.isInteger(newPercentage) || newPercentage < 0 || newPercentage > 100) {
        console.error("ProgressBarError: The percentage must be an integer between 0 and 100.");
        return;
    } else if (currentPercentage == newPercentage) return;

    // Agregar la nueva tarea a la cola
    queue.push(newPercentage);

    // Si ya hay una animación en curso, salimos
    if (animationFrameId) {
        return;
    }

    // Procesar la animación
    processQueue();
}

function processQueue() {
    // Si no hay más tareas en la cola, salir
    if (queue.length === 0) {
        return;
    }

    // Obtener la última tarea en la cola y limpiar la cola
    const targetPercentage = queue.pop();
    queue = [];

    const startPercentage = currentPercentage;
    const duration = 1000; // 1 segundo para la animación completa
    const stepTime = 10; // Tiempo entre pasos (en milisegundos)
    const steps = Math.abs(targetPercentage - startPercentage) * (1000 / duration);

    let step = 0;

    function animate() {
        step++;
        const progress = startPercentage + (step / steps) * (targetPercentage - startPercentage);
        currentPercentage = progress;
        const clippedPercentage = 100 - currentPercentage;

        // Actualizar el `clip-path` para recortar de derecha a izquierda
		
        
        document.getElementById('progress-bar-img').style.clipPath = `inset(0 ${clippedPercentage}% 0 0)`;
		document.getElementById('progress-bar-text').textContent = currentPercentage.toFixed(0) + "%";

        if (step < steps) {
            animationFrameId = requestAnimationFrame(animate);
        } else {
            animationFrameId = null; // Animación completa, resetear ID
            currentPercentage = targetPercentage;
            processQueue(); // Procesar la siguiente tarea en la cola si existe
        }
    }

    animationFrameId = requestAnimationFrame(animate);
}



</script>

</body>