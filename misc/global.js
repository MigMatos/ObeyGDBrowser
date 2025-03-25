$('body').append(`
	<style>
		@keyframes rotateWithArrows {
		0% {
			transform: rotate(0deg);
		}
		50% {
			filter: drop-shadow(1.5vh -1.5vh 0.7vh black);
			transform: rotate(90deg);
		}

		80% {
			transform: rotate(90deg);
		}

		100% {
			transform: rotate(90deg);
		}
		}

		.rotateDemo {
			display: inline-block;
			animation: rotateWithArrows 3s ease-in-out infinite;
			transform-origin: center center;
		}
	</style>
	<div data-nosnippet id="tooSmall" class="brownbox center supercenter" style="display: none; width: 80%">
	<h1 style="font-size: 4vh">Small screen!</h1>
	
	<div style="height: 50vh;" id="rotateDemoDevice">
    <svg version="1.1" height="100%" width="75%" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" style="z-index: 1;">
        <style type="text/css">
            .st0{fill:white;}
        </style>
        <g>
            <path class="st0" d="M360.189,0H151.812C118.96,0,92.328,26.631,92.328,59.484v357.344c0,52.566,42.607,95.172,95.172,95.172H324.5
                c52.566,0,95.172-42.607,95.172-95.172V59.484C419.672,26.631,393.042,0,360.189,0z M256,481.229
                c-8.115,0-14.688-6.574-14.688-14.688s6.574-14.689,14.688-14.689c8.115,0,14.688,6.574,14.688,14.689S264.115,481.229,256,481.229
                z M218.23,22.384h75.532c4.255,0,7.697,3.452,7.697,7.697c0,4.246-3.442,7.697-7.697,7.697H218.23c-4.254,0-7.697-3.45-7.697-7.697
                C210.533,25.836,213.976,22.384,218.23,22.384z M125.902,416.828V71.344h260.197v345.483c0,3.844-0.401,7.59-1.074,11.238h-258.05
                C126.304,424.418,125.902,420.672,125.902,416.828z"></path>
        </g>
    </svg>
	</div>

	<p style="font-size: 2.2vh">Are you on desktop? Just increase the window size (or rotate the screen yee!).</p>
	</div>
`)

console.log("%c" + "Warning!", "color: #ff0000; -webkit-text-stroke: 2px black; font-size: 72px; font-weight: bold;");
console.log("%cIf someone told you to perform an action here, they might be scamming you!%c\nIf you are a developer and know what you're doing, you can ignore this warning.", "background-color: black; font-size: 15px; color: red; font-weight: normal;", "font-weight: bold;");

window.onerror = function (message, source, lineno, colno, error) {

    // console.error(`Error: ${message} at ${source}:${lineno}:${colno}`);

	console.log("%c❌ ERROR IN OBEYGDBROWSER!", "font-size: 36px; color: red; font-weight: bold; -webkit-text-stroke: 1px black;");
	console.log(`%c${message} at ${source}:${lineno}:${colno}`, "color: red; font-size: 16px;");

    CreateFLAlert("Fatal Error in Browser!","**Join our support server and report:** [![Geometry Dash](https://invidget.switchblade.xyz/EbYKSHh95B)](https://discord.gg/EbYKSHh95B)\n\n\n# `a0 **Click in OK to restart**` \n\n## `g0 **Log Error:**` \n`r0 "+`${error} at ${source}:${lineno}:${colno}`+"`")
	$('#everything').hide(); 

	document.addEventListener('FLlayerclosed', function() {
		console.log('FLlayerclosed event triggered! Reloading the page...');
		location.reload();
	});

    document.body.style.backgroundImage = "unset";
	document.body.style.backgroundColor = "black";

	

    return true;
};

// ------------ IMPORTANT ------------ 

let globalMismatch = 3;

themeBrowser = ""
hasThemeBrowser = false;
const currentScript = document.currentScript || document.querySelector('script[src*="global.js"]');
const scriptPath = currentScript.src.split('/').slice(0, -2).join('/');

// ------------ IMPORTANT ------------ 


if (new URLSearchParams(window.location.search).has('gdframe') || "[[GDFRAME]]" === "TRUE") {

	const mbody = document.body;

	
	mbody.classList.remove("levelBG");
	mbody.classList.remove("darkBG");
	mbody.style = "background-color: #ff000000 !IMPORTANT; background-image: url('') !IMPORTANT;";

	// mbody.forEach(mbodyelem => {
	// 	console.log(mbody.classList);
	// 	mbodyelem.classList.remove("darkBG");
	// 	mbodyelem.style = "background-color: #ff000000; background-image: #00000000;";
	// 	// mbodyelem.style.backgroundColor = "#ff000000"; 
	// 	mbodyelem.style.backgroundImage = 'url("")';
	// 	// background-image: none !important;
	// });
	$(".cornerPiece").hide();
	$('#backButton').hide();
} else {
	$(window).resize(function () {
		if (window.innerHeight > window.innerWidth - 75) { 
			$('#everything').hide(); 
			$('#tooSmall').show();
			$('#rotateDemoDevice').addClass('rotateDemo');
		}
	
		else { 
			$('#everything').show(); 
			$('#tooSmall').hide()
			$('#rotateDemoDevice').removeClass('rotateDemo');
		}
	});
}

function darknessPage(){
	const overlay = document.createElement('div');
    overlay.id = 'overlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'black';
    overlay.style.opacity = '0';
    overlay.style.transition = 'opacity 0.3s ease-in-out';
    overlay.style.pointerEvents = 'none';
    document.body.appendChild(overlay);
	setTimeout(function () {
    	overlay.style.opacity = '1';
	}, 100);  
}

// Check if page is cached (SAFARI ISSUE)
window.onpageshow = function(event) {
    if (event.persisted) {
		let overlayCache = document.getElementById("overlay");
		if(overlayCache != null) overlayCache.style.opacity = '0';
    }
};



function saveUrl() {
    if (window.location.href.endsWith('?download')) return;
	sessionStorage.setItem('prevUrl', window.location.href);
}

function backButton() {
	if (window.history.length > 1 && document.referrer.startsWith(window.location.origin)){
            if (sessionStorage.getItem('prevUrl') === window.location.href.replace('?download', '')) window.history.back();
            else window.history.back()
        }
	else window.location.href = "../"
}

let onePointNine = false

function Fetch(link) {
	console.log(link)
	return new Promise(function (res, rej) {
		fetch(link).then(resp => {
			if (!resp.ok) return rej(resp)
			resp.json().then(res)
		}).catch(rej)
	})
}

function FetchAdmin(link,method="GET") {
    console.log(link);
    return new Promise(function (res, rej) {
        fetch(link, {
            method: method,
            credentials: 'include' 
        }).then(resp => {
            if (!resp.ok) return rej(resp);
            resp.json().then(res).catch(rej);
        }).catch(rej);
    });
}

let allowEsc = true;
let popupEsc = true;

$(document).keydown(function(k) {
	if (k.keyCode == 27) { //esc
		if (!allowEsc) return
		k.preventDefault()
		if (popupEsc && $('.popup').is(":visible")) $('.popup').hide();   
		else $('#backButton').trigger('click')
	}
});

let iconData = null
let iconCanvas = null
let iconRenderer = null
let overrideLoader = false
let renderedIcons = {}


async function renderIcons() {

	//cube - ship - ball - ufo - wave - robot - spider - swing - jetpack
	let iconsToRender = $('gdicon:not([rendered], [dontload])')
	if (iconsToRender.length < 1) return

	console.log(iconsToRender.length);

	for (let i = 0; i < iconsToRender.length; i++) {
		let currentIcon = iconsToRender.eq(i);
		var extraUrlIcon = "";
		let iconConfig = {
			id: +currentIcon.attr('iconID') || 1,
			form: currentIcon.attr('iconForm') || "cube",
			col1: +currentIcon.attr('col1') || 1,
			col2: +currentIcon.attr('col2') || 1,
			colg: (+currentIcon.attr('colg') !== 0 && +currentIcon.attr('colg')) || (+currentIcon.attr('col2') || 1),
			glow: currentIcon.attr('glow') || 0
		}

		if (iconConfig.glow == 1) { extraUrlIcon = `&glow=${iconConfig.colg}`; }
		let urlIcon = `https://gdicon.oat.zone/icon.png?type=${iconConfig.form}&value=${iconConfig.id}&color1=${iconConfig.col1}&color2=${iconConfig.col2}&color3=${iconConfig.colg}${extraUrlIcon}`



		currentIcon.append(`<img title="${iconConfig.form}" style="${currentIcon.attr("imgStyle") || ""}" src="${urlIcon}">`)
		currentIcon.attr("rendered", "true")

		
	}

}

// reset scroll
while ($(this).scrollTop() != 0) {
	$(this).scrollTop(0);
} 

$(document).ready(function() {
	$(window).trigger('resize');
	loadFile(`${scriptPath}/gdps_settings.json`, 'json')
	.then(data => {
		data.browser_theme = data.browser_theme || "1";
		data.browser_theme_path = data.browser_theme_path || "";
		if(data.browser_theme_path != "") setThemeBrowser('', data.browser_theme_path)
		if(data.browser_theme == "1") loadDefaultThemeBrowser()
	})
	.catch(error => {
		console.error(error);
	});
});

// Adds all necessary elements into the tab index (all buttons and links that aren't natively focusable)
const inaccessibleLinkSelector = "*:not(a) > img.gdButton, .leaderboardTab, .gdcheckbox, .diffDiv, .lengthDiv";

document.querySelectorAll(inaccessibleLinkSelector).forEach(elem => {
  elem.setAttribute('tabindex', 0);
})

document.getElementById('backButton')?.setAttribute('tabindex', 1); // Prioritize back button, first element to be focused

// Event listener to run a .click() function if
window.addEventListener("keydown", e => {
  if(e.key !== 'Enter') return;

  const active = document.activeElement;
  const isUnsupportedLink = active.hasAttribute('tabindex'); // Only click on links that aren't already natively supported to prevent double clicking
  if(isUnsupportedLink) active.click();
})

// stolen from stackoverflow
$.fn.isInViewport = function () {
    let elementTop = $(this).offset().top;
    let elementBottom = elementTop + $(this).outerHeight();
    let viewportTop = $(window).scrollTop();
    let viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
};

function loadDefaultThemeBrowser() {
	const isHalloweenSeason = () => { const today = new Date(); return today >= new Date(today.getFullYear(), 9, 25) && today <= new Date(today.getFullYear(), 10, 23); };
	const isChristmasSeason = () => { const today = new Date(); return today >= new Date(today.getFullYear(), 10, 24) && today <= new Date(today.getFullYear(), 11, 31); };
	const isNewYearSeason = () => new Date().getMonth() === 0 && new Date().getDate() === 1;

	

	if(isHalloweenSeason()){
		setThemeBrowser('halloween')
	}
	else if(isChristmasSeason()){
		setThemeBrowser('christmas')
	}
	else if(isNewYearSeason()){
		setThemeBrowser('newyear')
	}
}


function setThemeBrowser(themeName, themePath = null) {

	console.log(themeName, themePath);

	let cssPath = `${scriptPath}/assets/theme/${themeName}.css`;
	if(themePath) cssPath = `${scriptPath}/${themePath}`

	console.log(cssPath)
 
	loadIfExists(cssPath).then(exists => {
		if(exists) {
			$('<link>')
			.attr('rel', 'stylesheet')
			.attr('type', 'text/css')
			.attr('href', cssPath)
			.attr('crossorigin', 'anonymous')
			.appendTo('body');
	
			console.log('Appended CSS Theme')
			loadThemeAttr();
		} else {
			console.log("Error loading CSS Theme")
		}
	});

	
}

function loadThemeAttr() {
	hasThemeBrowser = true;
}

function loadIfExists(url) {
	return new Promise((resolve, reject) => {
	  $.ajax({
		url: url,
		type: 'HEAD',
		success: function() {
		  resolve(true);
		},
		error: function() {
		  resolve(false);
		}
	  });
	});
}

function loadFile(url, dataType = 'text') {
	return new Promise((resolve, reject) => {
	  $.ajax({
		url: url,
		type: 'GET',
		dataType: dataType,
		success: function(data) {
		  resolve(data);
		},
		error: function(jqXHR, textStatus, errorThrown) {
		  reject(`Error loading file: ${textStatus}, ${errorThrown}`);
		}
	  });
	});
  }

function generateToken(length) {
	return Array.from({ length: length }, () => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_'.charAt(Math.floor(Math.random() * 64))).join('')
}


// Service worker

