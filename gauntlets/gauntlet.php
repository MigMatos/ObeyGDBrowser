<head>
    <title id="tabTitle">Gauntlet</title>
    <meta charset="utf-8">
    <link href="../assets/css/browser.css" type="text/css" rel="stylesheet">
    <link rel="icon" href="../assets/coin.png">
    <meta id="meta-title" property="og:title" content="Gauntlet">
    <meta id="meta-desc" property="og:description" content="View the 5 levels in a Gauntlet!">
    <meta id="meta-image" name="og:image" itemprop="image" content="../coin.png">
    <meta name="twitter:card" content="summary">
</head>
<style>
    #levels {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        flex-wrap: wrap;
        position: absolute;
        top: 20%;
        width: 100%;
    }

    #gauntlet-title {
        display: none;
    }

    .dots {
        top: 35%;
        height: 99%;
        /* display: none; */
    }
    .gauntlet-level {
        position: relative;
        width: 30vh;
    }
    .gauntlet-level.down {
        top: 27vh;
    }
    .level-text {
        font-family: "Pusab", sans-serif;
        -webkit-text-stroke-width: 0.25vh;
        -webkit-text-stroke-color: black;
    }
    .level-last {
        position: absolute;
        width: 9vh;
    }
    .level-text.name {
        margin: 0 0 1vh 0;
        font-size: 3.8vh;
        width: 100%;
        position: relative;
        text-align: center;
        overflow: hidden;
    }
    .level-text.stars {
        position: relative;
        margin: 0.5vh 0;
        font-size: 5vh;
    }
    .level-star {
        margin: -0.5vh -1vh;
        height: 5vh;
    }
    .level-img {
        height: 15vh;
    }
</style>

<body class="darkBG" onbeforeunload="saveUrl()">

<div id="everything" style="overflow: auto;">

    <!-- <div style="position: absolute; height: 100%; width: 100%;">
        <img class="dots" src="../assets/gauntlets/icons/dots.png" style="position: absolute; left: 21vw;">
        <img class="dots" src="../assets/gauntlets/icons/dots.png" style="transform:scaleX(-1); position: absolute; left: 39vw;">
        <img class="dots" src="../assets/gauntlets/icons/dots.png" style="position: absolute; left: 57.5vw;">
        <img class="dots" src="../assets/gauntlets/icons/dots.png" style="transform:scaleX(-1); position: absolute; left: 75vw;">
    </div> -->
    <div style="position: absolute; height: 100%; width: 100%; background: rgba(0, 0, 0, 0.6)"></div>

    <div class="supercenter" style="top: 7%; width: 100%; text-align: center">
        <h2 id="gauntlet-title">Gauntlet</h2>
    </div>

    <div style="position:absolute; top: 2%; left: 1.5%; width: 10%; height: 25%; pointer-events: none">
        <img class="gdButton yesClick" id="backButton" src="../assets/back.png" height="30%" onclick="backButton()">
    </div>

    <div class="supercenter" id="loading" style="height: 10%; top: 47%; display: none;">
        <img class="spin noSelect" src="../assets/loading.png" height="105%">
    </div>

    <div id="levels">

    </div>

</div>

</body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="../misc/global.js?"></script>
<script type="text/javascript" src="../misc/dragscroll.js"></script>

<script>
    let url = new URL(window.location.href)
    const urlParams = new URLSearchParams(window.location.search);
    let gauntlet = urlParams.get('id');
    let legacyServer = true
    if (gauntlet == null) {
        gauntlet = "" + window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);
        legacyServer = false;
    }

    let loading = false

    function gauntletErrorImg(img) {
		img.src = "../assets/gauntlets/1.png";
		img.style.filter = 'grayscale(100%)';
	}

    if (!gauntlet) {
        window.location.href = "./"
        $('#loading').hide()
        loading = false
    }

    let container = $("#everything")[0]
    container.style.backgroundImage = `url("../assets/bgs/14.png")`
    container.style.backgroundSize = "cover"
    container.style.backgroundPosition = "0 92%"

    let searchFilters = `../api/gauntlets.php?id=${gauntlet}`
    let searchLevels = '../api/search.php?list&levelName='

    function clean(text) {return (text || "").toString().replace(/&/g, "&#38;").replace(/</g, "&#60;").replace(/>/g, "&#62;").replace(/=/g, "&#61;").replace(/"/g, "&#34;").replace(/'/g, "&#39;")}
    let hostMatch = window.location.host.match(/\./g)

    function Append(firstLoad, noCache) {

        loading = true;
        $('#loading').show()

        Fetch(searchFilters).then(appendLevels).catch(e => $('#loading').hide())

        function appendLevels(res) {
            res = res[0];
            console.log(res);

            document.title = `${res.gauntlet.name} Gauntlet`
            $('#gauntlet-title').html(`${res.gauntlet.name} Gauntlet`)
            $('#meta-desc').attr('content',  `View the 5 levels in the ${res.gauntlet.name} Gauntlet!`)


            let levelsID = res.levels.split(",");
            console.log(levelsID)

            if (res == '' || levelsID.length == 0) { $('#loading').hide(); return loading = false }

            Fetch(searchLevels+res.levels).then(levelsData => {

                $(".dots").show()
                $("#gauntlet-title").show()

                levelsData.forEach((x, y) => {
                $("#levels").append(`
                ${y == 1 ? '<img class="dots" src="../assets/gauntlets/icons/dots.png" style="height: 1vh;transform: translateY(14.5vh) scale(30.5);">' : ''}
                ${y == 2 ? '<img class="dots" src="../assets/gauntlets/icons/dots.png" style="height: 1vh;transform: translateY(14.5vh) scale(30.5) scaleX(-1);">' : ''}
                ${y == 3 ? '<img class="dots" src="../assets/gauntlets/icons/dots.png" style="height: 1vh;transform: translateY(14.5vh) scale(30.5);">' : ''}
                ${y == 4 ? '<img class="dots" src="../assets/gauntlets/icons/dots.png" style="height: 1vh;transform: translateY(14.5vh) scale(30.5) scaleX(-1);">' : ''}
                <a onclick="levelRedirect(${x.id})" class="gauntlet-level gdButton${y % 2 ? "" : " down"}">
               
                <p class="level-text name">${x.name}</p>
                <div style="display: flex;justify-content: center;align-items: center;">
                <img class="level-img" onerror="gauntletErrorImg(this)" src="../assets/gauntlets/${res.id}.png">
                ${y == 4 ? '<img class="level-last" src="../assets/gauntlets/icons/skull.png">' : ""}
                </div>
                <p class="level-text stars">${x.stars}
                <img class="level-star" src="../assets/bigstar.png"></p>
                </a>`)
                })

                $('#loading').hide()
                loading = false;

            })
            

        }
    }

    Append(true)


    $('.closeWindow').click(function() {$(".popup").attr('style', 'display: none;')})

    $(document).keydown(function(k) {
        if (loading) return;

        if ($('#pageDiv').is(':visible')) {
            if (k.which == 13) $('#pageJump').trigger('click') //enter
            else return;
        }
    })


    function levelRedirect(url) {
        var queryLvl = "";
        if (legacyServer == true) {
            queryLvl = "/level/?id=" + (encodeURIComponent(url) || "0")
        } else {
            queryLvl = "/level/" + (encodeURIComponent(url) || "0")
        }
        if (queryLvl) window.location.href = ".." + queryLvl
    }


</script>