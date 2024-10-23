<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="../../assets/css/browser.css" type="text/css" rel="stylesheet">
    <?php
		include("../../_init_.php");
		include("../../assets/htmlext/flayeralert.php");
		include("../../assets/htmlext/loadingalert.php");
    
    ?>
</head>
<style>
  .gdsub {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    flex-wrap: nowrap;
    margin: 2vh 2vh 2vh 2vh;
  }

  .gdsub-right {
    overflow-y: auto;
    height: 60vh;
    margin-left: auto;
    align-content: center;

    background-color: #00000065;
    border-radius: 2.5vh;
    width: auto;

  }

  .gdsub-left {
    width: auto;
    height: 60vh;
    align-content: center;
    text-align: left;
  }

  .gdDivCheckbox {
    text-align: center;
    display: inline-flex !important;
    justify-content: center;
  }

  .gdDivCheckbox > h3 {
    text-wrap: nowrap;
    text-align: center;
  }
  
  .gdDivCheckbox > h3 > label {
    height: 4vh;
  }

  .gdColorPicker {
    width: unset !important;
  }

</style>

<body class="levelBG" style="background-image: linear-gradient(to bottom, #76153f, #370016); width: 100%; height: 100%;">

<div id="scoreCustomTabs">
		<div class="invisibleBox leaderboardCustomTab" id="tab-rates" activetab="off" onclick="setFilter(this.getAttribute('id'))"><h1 style="transform: translate(0px, -1vh);"> <img src="../../assets/star.png" style="height:5vh">  </h1></div>
		<div class="invisibleBox leaderboardCustomTab" id="tab-daily" activetab="off" onclick="setFilter(this.getAttribute('id'))"><h1 style="transform: translate(0px, -1vh);"> <img src="../../assets/crown-daily.png" style="height:5vh"> </h1></div>
    <div class="invisibleBox leaderboardCustomTab" id="tab-weekly" activetab="off" onclick="setFilter(this.getAttribute('id'))"><h1 style="transform: translate(0px, -1vh);"> <img src="../../assets/crown-weekly.png" style="height:5vh"> </h1></div>
    <div class="invisibleBox leaderboardCustomTab" id="tab-custom" activetab="off" onclick="setFilter(this.getAttribute('id'))"><h1 style="transform: translate(0px, -1vh);">Custom <span id="tab-custom-text">+</span></h1></div>
</div>

<div class="purpleBox center supercenter" style="width: 80%; height: 80%; margin-top: 2.3%">
  <h2>Webhooks</h2>


  
<form>

<div class="gd-container">
    <div class="gdsub">

    <div class="gdsub-left" id="gdsub-left">
    <!-- Thank you Danktuary for this amazing library! https://github.com/Danktuary/wc-discord-message -->
    
    <discord-messages id="discord-msg-builder">

        <discord-message id="msg1" author="ObeyGDRates" avatar="" role-color="" bot="true">
            <msg class="discord-Text-Content"></msg>
            <discord-embed id="msg1embed" slot="embeds" color="" embed-title="" author-image="" author-name="" thumbnail="" footerImage=""><span class="content"></span>
                <footer class="discord-footer"><img id="" src=""><span class="footer-content"></span></footer>
            </discord-embed>
            
        </discord-message>
        
    </discord-messages>

    </div>


    <div class="gdsub-right" id="gdsub-right" oninput="updateWebhookMessage(event.srcElement)">

        <!-- <div class="webhooks-list">
            <h3 class="gdfont-Pusab small wl selected">Rated</h3>
            <h3 class="gdfont-Pusab small wl">Unrated</h3>
            <h3 class="gdfont-Pusab small wl">Daily</h3>
            <h3 class="gdfont-Pusab small wl">Weekly</h3>
        </div> -->



        <div class="webhook-content" id="filterStuff">
            <br>

            <div class="gdDivCheckbox"><h3><input type="checkbox" id="enabled" name="enabled" value="1">
            <label for="enabled" class="gdcheckbox gdButton" tabindex="0"></label>Enable Webhook</h3>
            </div>
            <br><br>
            <h3 for="webhook-url">Webhook URL:</h3>
            <input type="text" id="webhook-url" name="webhook-url" pattern="^(https:\/\/discord\.com\/api\/webhooks\/.*)?$" required>
            <br><br>
            <h3 for="webhook-url">Webhook bot name:</h3>
            <input type="text" id="webhook-bot-name" name="webhook-bot-name" value="ObeyGDRates">
            <br><br>
            <h3 for="webhook-bot-imgurl">Webhook bot image URL:</h3>
            <input type="text" id="webhook-bot-imgurl" name="webhook-bot-imgurl" pattern="^(https:\/\/.*)?$">
            <br><br>
            <h3 for="webhook-content">Message content:</h3>
            <textarea id="webhook-content" name="webhook-content" rows="3" cols="50" maxlength="2000" wrap="hard" style="resize: none;">New rate!</textarea>
            <br><br>
            <h3 for="embed-author-name">Embed author name:</h3>
            <input type="text" id="embed-author-name" name="embed-author-name">
            <br><br>
            <h3 for="embed-author-imgurl">Embed author image URL:</h3>
            <input type="text" id="embed-author-imgurl" name="embed-author-imgurl" pattern="^(https:\/\/.*)?$">
            <br><br>
            <h3 for="embed-title">Embed title:</h3>
            <input type="text" id="embed-title" name="embed-title" value="test">
            <br>
            <h3 for="embed-desc">Embed description:</h3>
            <textarea id="embed-desc" name="embed-desc" rows="3" cols="50" maxlength="4000" wrap="hard" style="resize: none;">New rate!</textarea>
            <br><br>
            <h3 for="embed-thumbnail-imgurl">Embed thumbnail image URLs:</h3>
            <input type="text" id="embed-thumbnail-imgurl" name="embed-thumbnail-imgurl">
            <br><br>
            <h3 for="embed-footer-author">Embed footer author name:</h3>
            <input type="text" id="embed-footer-author" name="embed-footer-author">
            <br><br>
            <h3 for="embed-footer-author-imgurl">Embed footer author image URL:</h3>
            <input type="text" id="embed-footer-author-imgurl" name="embed-footer-author-imgurl">
            <br><br>
            <h3 for="embed-color">Embed color:</h3>
            <div class="gdColorPicker"><input class="inputmaps" type="color" id="embed-color" name="embed-color" value="#202225"></div>
            <br><br>
        </div>

    </div>
    
    


    </div>

    <script src="https://unpkg.com/wc-discord-message@2.0.4/dist/wc-discord-message/wc-discord-message.js">
      window.$discordMessage = {
        avatars: {
          'default': 'green',
          jojo: 'https://i.imgur.com/BOlehTj.jpg',
        }
      }
    </script>
    
    <!-- Discord view closed -->
    
    <div style="display: flex; justify-content: center;">

    <div class="gdsButton blue" style="width: fit-content; padding-left:1.5vh;padding-right:1.5vh;margin-right: 3vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect">Save Webhook</h3></div>
    
    </div>
  
</div>
</div>


<script>
    function updateWebhookMessage(event) {
        //console.log(event)
        var ValueElement = event.value;
        var NameElement = event.id;
        

        //Msgbuilder
        var discordMsgBuilder = document.getElementById("discord-msg-builder");
        var webhookMessage = discordMsgBuilder.querySelector("discord-message");
        var webhookContentMessage = webhookMessage.querySelector("msg");
        var webhookEmbedMessage = webhookMessage.querySelector("discord-embed");
        //console.log(NameElement);
        switch (NameElement) {
            case "webhook-bot-name":
                webhookMessage.setAttribute("author", ValueElement);
                break;
            case "webhook-bot-imgurl":
                if (/^https?:\/\//.test(ValueElement)) {webhookMessage.setAttribute("avatar", ValueElement);} 
                else {webhookMessage.setAttribute("avatar", "https://iili.io/2Hy7sdg.png");}
                break;
            case "webhook-content":
                webhookContentMessage.innerHTML = '';
                webhookContentMessage.textContent = '';
                webhookContentMessage.innerHTML = sanitizerCode(processHTMLContent(ValueElement));
                break;
            case "embed-author-name":
                webhookEmbedMessage.setAttribute("author-name", ValueElement);
                break;
            case "embed-author-imgurl":
                if (/^https?:\/\//.test(ValueElement)) {webhookEmbedMessage.setAttribute("author-image", ValueElement);} 
                else {webhookEmbedMessage.setAttribute("author-image", "");}
                break;
            case "embed-title":
                webhookEmbedMessage.setAttribute("embed-title", ValueElement);
                break;
            case "embed-desc":
                webhookEmbedMessage.querySelector('.content').textContent = ValueElement;
                break;
            case "embed-thumbnail-imgurl":
                if (/^https?:\/\//.test(ValueElement)) {webhookEmbedMessage.setAttribute("thumbnail", ValueElement);} 
                else {webhookEmbedMessage.setAttribute("thumbnail", "");}
                break;
            case "embed-footer-author":
                webhookEmbedMessage.querySelector('footer').querySelector('span').textContent = ValueElement;
                break;
            case "embed-footer-author-imgurl":
                if (/^https?:\/\//.test(ValueElement)) {}
                else {ValueElement = ""}
                webhookEmbedMessage.querySelector('footer').querySelector('img').src = ValueElement;
                break;
            case "embed-color":
                webhookEmbedMessage.setAttribute("color", ValueElement);
                break;
            default:
                break;

        }
    }

    
    


    document.addEventListener("DOMContentLoaded", function() {

  var webhookElements = document.querySelectorAll('.webhook-content');

  webhookElements.forEach(function(element) {

    var inputs = element.querySelectorAll('input[type="text"],textarea,input[type="number"], input[type="color"]');

    inputs.forEach(function(input) {

        updateWebhookMessage(input);
      
    });
  });
});
</script>

</form>



</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="../../misc/gdcustomframe.js"></script>
<script>$('#loading-main').hide()</script>

<script>

const urlParams = new URLSearchParams(window.location.search);
let tabSelected = urlParams.get('tab');

if(!tabSelected) {
  setFilter('tab-rates');
}

function setFilter(filter) {
	const scoreCustomTabsDiv = document.getElementById('scoreCustomTabs');
	
	scoreCustomTabsDiv.querySelectorAll('[id]').forEach(tab => {
    	if (tab.getAttribute("activetab") !== "disabled") tab.setAttribute("activetab", tab.id === filter ? "on" : "off");
	});
	
	const tabSelected = document.getElementById(filter);

	filter = filter.replace("tab-","")
	

	tabToggle = tabSelected.getAttribute("activetab");

}

</script>

</html>
