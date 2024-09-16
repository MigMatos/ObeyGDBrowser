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

		console.log(iconConfig);
	}

}

// reset scroll
while ($(this).scrollTop() != 0) {
	$(this).scrollTop(0);
} 

$(document).ready(function() {
	$(window).trigger('resize');
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