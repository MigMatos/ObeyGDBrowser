$('body').append(`
	<div data-nosnippet id="tooSmall" class="brownbox center supercenter" style="display: none; width: 80%">
	<h1>Yikes!</h1>
	<p>Your <cg>screen</cg> isn't <ca>wide</ca> enough to <cy>display</cy> this <cg>page</cg>.<br>
	Please <cy>rotate</cy> your <cg>device</cg> <ca>horizontally</ca> or <cy>resize</cy> your <cg>window</cg> to be <ca>longer</ca>.
	</p>
	<p style="font-size: 1.8vh">Did I color too many words? I think I colored too many words.</p>
	</div>
`)


$(window).resize(function () {
	if (window.innerHeight > window.innerWidth - 75) { 
		$('#everything').hide(); 
		$('#tooSmall').show();
	}

	else { 
		$('#everything').show(); 
		$('#tooSmall').hide() 
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
	
	return new Promise(function (res, rej) {
		fetch(link).then(resp => {
			if (!resp.ok) return rej(resp)
			resp.json().then(res)
		}).catch(rej)
	})
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