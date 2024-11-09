<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GDPS Configuration</title>
    <link href="../assets/css/gdpssettings.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#999999">
    
    <?php

    include("../_init_.php");
    if ($failed_conn) {

    }
    else if($logged && $isAdmin) {} else {header("Location: ../");}
    function get_gameversion($data) {
        $data = intval($data);
        
        if ($data <= 0) {
            return 1.0;
        } elseif ($data <= 7) {
            return "1." . ($data - 1);
        } elseif ($data == 10) {
            return 1.7;
        } else {
            return $data / 10;
        }
    }

   
    ?>
    
    <h4 style="margin: 0;display: flex;flex-wrap: nowrap;justify-content: center;align-items: center;">Theme: <button id="theme-toggle"><span id="theme-emoji">☀</span><span style="margin-left:1vh;" id="theme-text">Light</span></button></h3>

    <br>

    <fieldset><legend><h2>GDPS Configuration</h2></legend>

    <form id="levelForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


    <fieldset><legend><h5>Lengths (String)</h5></legend> <button type="button" class="toggle-btn"><strong>View/Hide</strong><span>▼</span></button>
        <div class="content hidden">
        <label for="length-0">Length 0:</label>
        <input type="text" id="length-0" name="length-0"><br>
        <label for="length-1">Length 1:</label>
        <input type="text" id="length-1" name="length-1"><br>
        <label for="length-2">Length 2:</label>
        <input type="text" id="length-2" name="length-2"><br>
        <label for="length-3">Length 3:</label>
        <input type="text" id="length-3" name="length-3"><br>
        <label for="length-4">Length 4:</label>
        <input type="text" id="length-4" name="length-4"><br>
        <label for="length-5">Length 5:</label>
        <input type="text" id="length-5" name="length-5"><br>
        </div>
    </fieldset>


    <fieldset><legend><h5>Featured rates</h5></legend> 
        <button type="button" class="toggle-btn">
            <strong>View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">
        <label for="featured-0">Featured 0:</label>
        <input type="text" id="featured-0" name="featured-0"><br>
        <label for="featured-1">Featured 1:</label>
        <input type="text" id="featured-1" name="featured-1"><br>
        </div>
    </fieldset>

    <fieldset><legend><h5>Epic rates</h5></legend>
        <button type="button" class="toggle-btn">
            <strong>View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">
        <label for="epic-0">Epic 0:</label>
        <input type="text" id="epic-0" name="epic-0"><br>
        <label for="epic-1">Epic 1:</label>
        <input type="text" id="epic-1" name="epic-1"><br>
        <label for="epic-2">Epic 2:</label>
        <input type="text" id="epic-2" name="epic-2"><br>
        <label for="epic-3">Epic 3:</label>
        <input type="text" id="epic-3" name="epic-3"><br>
        </div>
    </fieldset>

    <fieldset><legend><h5>Demon difficulties</h5></legend>
        <button type="button" class="toggle-btn">
            <strong>View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">
        <label for="states_demon-0">Demon Type 0:</label>
        <input type="text" id="states_demon-0" name="states_demon-0"><br>
        <label for="states_demon-3">Demon Type 3:</label>
        <input type="text" id="states_demon-3" name="states_demon-3"><br>
        <label for="states_demon-4">Demon Type 4:</label>
        <input type="text" id="states_demon-4" name="states_demon-4"><br>
        <label for="states_demon-5">Demon Type 5:</label>
        <input type="text" id="states_demon-5" name="states_demon-5"><br>
        <label for="states_demon-6">Demon Type 6:</label>
        <input type="text" id="states_demon-6" name="states_demon-6"><br>
        </div>
    </fieldset>

    <fieldset><legend><h5>Difficulties</h5></legend>
        <button type="button" class="toggle-btn">
            <strong>View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">
        <label for="states_diff_num-0">Difficulty Type 0:</label>
        <input type="text" id="states_diff_num-0" name="states_diff_num-0"><br>
        <label for="states_diff_num-10">Difficulty Type 10:</label>
        <input type="text" id="states_diff_num-10" name="states_diff_num-10"><br>
        <label for="states_diff_num-20">Difficulty Type 20:</label>
        <input type="text" id="states_diff_num-20" name="states_diff_num-20"><br>
        <label for="states_diff_num-30">Difficulty Type 30:</label>
        <input type="text" id="states_diff_num-30" name="states_diff_num-30"><br>
        <label for="states_diff_num-40">Difficulty Type 40:</label>
        <input type="text" id="states_diff_num-40" name="states_diff_num-40"><br>
        <label for="states_diff_num-50">Difficulty Type 50:</label>
        <input type="text" id="states_diff_num-50" name="states_diff_num-50"><br>
        </div>
    </fieldset>

    <fieldset><legend><h5>Gauntlets</h5></legend>
        <button type="button" class="toggle-btn">
            <strong>View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">

        <label for="gauntlet-1-name">Gauntlet 1:</label>
<input type="text" id="gauntlet-1-name" name="gauntlet-1-name" value="Fire"><br>
<label for="gauntlet-1-textcolor">Gauntlet 1 Text Color:</label>
<input type="color" id="gauntlet-1-textcolor" name="gauntlet-1-textcolor" value="#FFC700"><br>
<label for="gauntlet-1-bgcolor">Gauntlet 1 BG Color:</label>
<input type="color" id="gauntlet-1-bgcolor" name="gauntlet-1-bgcolor" value="#cf1200"><br>

<label for="gauntlet-2-name">Gauntlet 2:</label>
<input type="text" id="gauntlet-2-name" name="gauntlet-2-name" value="Ice"><br>
<label for="gauntlet-2-textcolor">Gauntlet 2 Text Color:</label>
<input type="color" id="gauntlet-2-textcolor" name="gauntlet-2-textcolor" value="#5CFFFF"><br>
<label for="gauntlet-2-bgcolor">Gauntlet 2 BG Color:</label>
<input type="color" id="gauntlet-2-bgcolor" name="gauntlet-2-bgcolor" value="#1299ff"><br>

<label for="gauntlet-3-name">Gauntlet 3:</label>
<input type="text" id="gauntlet-3-name" name="gauntlet-3-name" value="Poison"><br>
<label for="gauntlet-3-textcolor">Gauntlet 3 Text Color:</label>
<input type="color" id="gauntlet-3-textcolor" name="gauntlet-3-textcolor" value="#00FF00"><br>
<label for="gauntlet-3-bgcolor">Gauntlet 3 BG Color:</label>
<input type="color" id="gauntlet-3-bgcolor" name="gauntlet-3-bgcolor" value="#2cb205"><br>

<label for="gauntlet-4-name">Gauntlet 4:</label>
<input type="text" id="gauntlet-4-name" name="gauntlet-4-name" value="Shadow"><br>
<label for="gauntlet-4-textcolor">Gauntlet 4 Text Color:</label>
<input type="color" id="gauntlet-4-textcolor" name="gauntlet-4-textcolor" value="#B339DB"><br>
<label for="gauntlet-4-bgcolor">Gauntlet 4 BG Color:</label>
<input type="color" id="gauntlet-4-bgcolor" name="gauntlet-4-bgcolor" value="#5400A4"><br>

<label for="gauntlet-5-name">Gauntlet 5:</label>
<input type="text" id="gauntlet-5-name" name="gauntlet-5-name" value="Lava"><br>
<label for="gauntlet-5-textcolor">Gauntlet 5 Text Color:</label>
<input type="color" id="gauntlet-5-textcolor" name="gauntlet-5-textcolor" value="#E75F19"><br>
<label for="gauntlet-5-bgcolor">Gauntlet 5 BG Color:</label>
<input type="color" id="gauntlet-5-bgcolor" name="gauntlet-5-bgcolor" value="#AE0000"><br>

<label for="gauntlet-6-name">Gauntlet 6:</label>
<input type="text" id="gauntlet-6-name" name="gauntlet-6-name" value="Bonus"><br>
<label for="gauntlet-6-textcolor">Gauntlet 6 Text Color:</label>
<input type="color" id="gauntlet-6-textcolor" name="gauntlet-6-textcolor" value="#FFFFFF"><br>
<label for="gauntlet-6-bgcolor">Gauntlet 6 BG Color:</label>
<input type="color" id="gauntlet-6-bgcolor" name="gauntlet-6-bgcolor" value="#3954D6"><br>

<label for="gauntlet-7-name">Gauntlet 7:</label>
<input type="text" id="gauntlet-7-name" name="gauntlet-7-name" value="Chaos"><br>
<label for="gauntlet-7-textcolor">Gauntlet 7 Text Color:</label>
<input type="color" id="gauntlet-7-textcolor" name="gauntlet-7-textcolor" value="#E21C25"><br>
<label for="gauntlet-7-bgcolor">Gauntlet 7 BG Color:</label>
<input type="color" id="gauntlet-7-bgcolor" name="gauntlet-7-bgcolor" value="#505050"><br>

<label for="gauntlet-8-name">Gauntlet 8:</label>
<input type="text" id="gauntlet-8-name" name="gauntlet-8-name" value="Demon"><br>
<label for="gauntlet-8-textcolor">Gauntlet 8 Text Color:</label>
<input type="color" id="gauntlet-8-textcolor" name="gauntlet-8-textcolor" value="#E21C25"><br>
<label for="gauntlet-8-bgcolor">Gauntlet 8 BG Color:</label>
<input type="color" id="gauntlet-8-bgcolor" name="gauntlet-8-bgcolor" value="#282828"><br>

<label for="gauntlet-9-name">Gauntlet 9:</label>
<input type="text" id="gauntlet-9-name" name="gauntlet-9-name" value="Time"><br>
<label for="gauntlet-9-textcolor">Gauntlet 9 Text Color:</label>
<input type="color" id="gauntlet-9-textcolor" name="gauntlet-9-textcolor" value="#1DF7F1"><br>
<label for="gauntlet-9-bgcolor">Gauntlet 9 BG Color:</label>
<input type="color" id="gauntlet-9-bgcolor" name="gauntlet-9-bgcolor" value="#0053D4"><br>

<label for="gauntlet-10-name">Gauntlet 10:</label>
<input type="text" id="gauntlet-10-name" name="gauntlet-10-name" value="Crystal"><br>
<label for="gauntlet-10-textcolor">Gauntlet 10 Text Color:</label>
<input type="color" id="gauntlet-10-textcolor" name="gauntlet-10-textcolor" value="#F4C6EC"><br>
<label for="gauntlet-10-bgcolor">Gauntlet 10 BG Color:</label>
<input type="color" id="gauntlet-10-bgcolor" name="gauntlet-10-bgcolor" value="#DF0079"><br>

<label for="gauntlet-11-name">Gauntlet 11:</label>
<input type="text" id="gauntlet-11-name" name="gauntlet-11-name" value="Magic"><br>
<label for="gauntlet-11-textcolor">Gauntlet 11 Text Color:</label>
<input type="color" id="gauntlet-11-textcolor" name="gauntlet-11-textcolor" value="#3FF6F4"><br>
<label for="gauntlet-11-bgcolor">Gauntlet 11 BG Color:</label>
<input type="color" id="gauntlet-11-bgcolor" name="gauntlet-11-bgcolor" value="#002969"><br>

<label for="gauntlet-12-name">Gauntlet 12:</label>
<input type="text" id="gauntlet-12-name" name="gauntlet-12-name" value="Spike"><br>
<label for="gauntlet-12-textcolor">Gauntlet 12 Text Color:</label>
<input type="color" id="gauntlet-12-textcolor" name="gauntlet-12-textcolor" value="#E5C04F"><br>
<label for="gauntlet-12-bgcolor">Gauntlet 12 BG Color:</label>
<input type="color" id="gauntlet-12-bgcolor" name="gauntlet-12-bgcolor" value="#7F5000"><br>

<label for="gauntlet-13-name">Gauntlet 13:</label>
<input type="text" id="gauntlet-13-name" name="gauntlet-13-name" value="Monster"><br>
<label for="gauntlet-13-textcolor">Gauntlet 13 Text Color:</label>
<input type="color" id="gauntlet-13-textcolor" name="gauntlet-13-textcolor" value="#40E924"><br>
<label for="gauntlet-13-bgcolor">Gauntlet 13 BG Color:</label>
<input type="color" id="gauntlet-13-bgcolor" name="gauntlet-13-bgcolor" value="#008800"><br>

<label for="gauntlet-14-name">Gauntlet 14:</label>
<input type="text" id="gauntlet-14-name" name="gauntlet-14-name" value="Doom"><br>
<label for="gauntlet-14-textcolor">Gauntlet 14 Text Color:</label>
<input type="color" id="gauntlet-14-textcolor" name="gauntlet-14-textcolor" value="#E62227"><br>
<label for="gauntlet-14-bgcolor">Gauntlet 14 BG Color:</label>
<input type="color" id="gauntlet-14-bgcolor" name="gauntlet-14-bgcolor" value="#DF0079"><br>

<label for="gauntlet-15-name">Gauntlet 15:</label>
<input type="text" id="gauntlet-15-name" name="gauntlet-15-name" value="Death"><br>
<label for="gauntlet-15-textcolor">Gauntlet 15 Text Color:</label>
<input type="color" id="gauntlet-15-textcolor" name="gauntlet-15-textcolor" value="#E62227"><br>
<label for="gauntlet-15-bgcolor">Gauntlet 15 BG Color:</label>
<input type="color" id="gauntlet-15-bgcolor" name="gauntlet-15-bgcolor" value="#282828"><br>

<label for="gauntlet-16-name">Gauntlet 16:</label>
<input type="text" id="gauntlet-16-name" name="gauntlet-16-name" value="Forest"><br>
<label for="gauntlet-16-textcolor">Gauntlet 16 Text Color:</label>
<input type="color" id="gauntlet-16-textcolor" name="gauntlet-16-textcolor" value=""><br>
<label for="gauntlet-16-bgcolor">Gauntlet 16 BG Color:</label>
<input type="color" id="gauntlet-16-bgcolor" name="gauntlet-16-bgcolor" value="#005300"><br>

<label for="gauntlet-17-name">Gauntlet 17:</label>
<input type="text" id="gauntlet-17-name" name="gauntlet-17-name" value="Rune"><br>
<label for="gauntlet-17-textcolor">Gauntlet 17 Text Color:</label>
<input type="color" id="gauntlet-17-textcolor" name="gauntlet-17-textcolor" value="#FFC600"><br>
<label for="gauntlet-17-bgcolor">Gauntlet 17 BG Color:</label>
<input type="color" id="gauntlet-17-bgcolor" name="gauntlet-17-bgcolor" value="#814F00"><br>

<label for="gauntlet-18-name">Gauntlet 18:</label>
<input type="text" id="gauntlet-18-name" name="gauntlet-18-name" value="Force"><br>
<label for="gauntlet-18-textcolor">Gauntlet 18 Text Color:</label>
<input type="color" id="gauntlet-18-textcolor" name="gauntlet-18-textcolor" value="#FF76FF"><br>
<label for="gauntlet-18-bgcolor">Gauntlet 18 BG Color:</label>
<input type="color" id="gauntlet-18-bgcolor" name="gauntlet-18-bgcolor" value="#55009B"><br>

<label for="gauntlet-19-name">Gauntlet 19:</label>
<input type="text" id="gauntlet-19-name" name="gauntlet-19-name" value="Spooky"><br>
<label for="gauntlet-19-textcolor">Gauntlet 19 Text Color:</label>
<input type="color" id="gauntlet-19-textcolor" name="gauntlet-19-textcolor" value="#00CDCB"><br>
<label for="gauntlet-19-bgcolor">Gauntlet 19 BG Color:</label>
<input type="color" id="gauntlet-19-bgcolor" name="gauntlet-19-bgcolor" value="#003D3D"><br>

<label for="gauntlet-20-name">Gauntlet 20:</label>
<input type="text" id="gauntlet-20-name" name="gauntlet-20-name" value="Dragon"><br>
<label for="gauntlet-20-textcolor">Gauntlet 20 Text Color:</label>
<input type="color" id="gauntlet-20-textcolor" name="gauntlet-20-textcolor" value="#FF3900"><br>
<label for="gauntlet-20-bgcolor">Gauntlet 20 BG Color:</label>
<input type="color" id="gauntlet-20-bgcolor" name="gauntlet-20-bgcolor" value="#600000"><br>

<label for="gauntlet-21-name">Gauntlet 21:</label>
<input type="text" id="gauntlet-21-name" name="gauntlet-21-name" value="Water"><br>
<label for="gauntlet-21-textcolor">Gauntlet 21 Text Color:</label>
<input type="color" id="gauntlet-21-textcolor" name="gauntlet-21-textcolor" value="#00FFFF"><br>
<label for="gauntlet-21-bgcolor">Gauntlet 21 BG Color:</label>
<input type="color" id="gauntlet-21-bgcolor" name="gauntlet-21-bgcolor" value="#0062CE"><br>

<label for="gauntlet-22-name">Gauntlet 22:</label>
<input type="text" id="gauntlet-22-name" name="gauntlet-22-name" value="Haunted"><br>
<label for="gauntlet-22-textcolor">Gauntlet 22 Text Color:</label>
<input type="color" id="gauntlet-22-textcolor" name="gauntlet-22-textcolor" value="#FBFF52"><br>
<label for="gauntlet-22-bgcolor">Gauntlet 22 BG Color:</label>
<input type="color" id="gauntlet-22-bgcolor" name="gauntlet-22-bgcolor" value="#191F23"><br>

<label for="gauntlet-23-name">Gauntlet 23:</label>
<input type="text" id="gauntlet-23-name" name="gauntlet-23-name" value="Acid"><br>
<label for="gauntlet-23-textcolor">Gauntlet 23 Text Color:</label>
<input type="color" id="gauntlet-23-textcolor" name="gauntlet-23-textcolor" value="#75FF00"><br>
<label for="gauntlet-23-bgcolor">Gauntlet 23 BG Color:</label>
<input type="color" id="gauntlet-23-bgcolor" name="gauntlet-23-bgcolor" value="#44443B"><br>

<label for="gauntlet-24-name">Gauntlet 24:</label>
<input type="text" id="gauntlet-24-name" name="gauntlet-24-name" value="Witch"><br>
<label for="gauntlet-24-textcolor">Gauntlet 24 Text Color:</label>
<input type="color" id="gauntlet-24-textcolor" name="gauntlet-24-textcolor" value="#60F7FF"><br>
<label for="gauntlet-24-bgcolor">Gauntlet 24 BG Color:</label>
<input type="color" id="gauntlet-24-bgcolor" name="gauntlet-24-bgcolor" value="#13322F"><br>

<label for="gauntlet-25-name">Gauntlet 25:</label>
<input type="text" id="gauntlet-25-name" name="gauntlet-25-name" value="Power"><br>
<label for="gauntlet-25-textcolor">Gauntlet 25 Text Color:</label>
<input type="color" id="gauntlet-25-textcolor" name="gauntlet-25-textcolor" value="#FDE69E"><br>
<label for="gauntlet-25-bgcolor">Gauntlet 25 BG Color:</label>
<input type="color" id="gauntlet-25-bgcolor" name="gauntlet-25-bgcolor" value="#2F1D1A"><br>

<label for="gauntlet-26-name">Gauntlet 26:</label>
<input type="text" id="gauntlet-26-name" name="gauntlet-26-name" value="Potion"><br>
<label for="gauntlet-26-textcolor">Gauntlet 26 Text Color:</label>
<input type="color" id="gauntlet-26-textcolor" name="gauntlet-26-textcolor" value="#FF92FF"><br>
<label for="gauntlet-26-bgcolor">Gauntlet 26 BG Color:</label>
<input type="color" id="gauntlet-26-bgcolor" name="gauntlet-26-bgcolor" value="#4F1B32"><br>

<label for="gauntlet-27-name">Gauntlet 27:</label>
<input type="text" id="gauntlet-27-name" name="gauntlet-27-name" value="Snake"><br>
<label for="gauntlet-27-textcolor">Gauntlet 27 Text Color:</label>
<input type="color" id="gauntlet-27-textcolor" name="gauntlet-27-textcolor" value="#FFB267"><br>
<label for="gauntlet-27-bgcolor">Gauntlet 27 BG Color:</label>
<input type="color" id="gauntlet-27-bgcolor" name="gauntlet-27-bgcolor" value="#2F225A"><br>

<label for="gauntlet-28-name">Gauntlet 28:</label>
<input type="text" id="gauntlet-28-name" name="gauntlet-28-name" value="Toxic"><br>
<label for="gauntlet-28-textcolor">Gauntlet 28 Text Color:</label>
<input type="color" id="gauntlet-28-textcolor" name="gauntlet-28-textcolor" value="#00FF00"><br>
<label for="gauntlet-28-bgcolor">Gauntlet 28 BG Color:</label>
<input type="color" id="gauntlet-28-bgcolor" name="gauntlet-28-bgcolor" value="#490F4E"><br>

<label for="gauntlet-29-name">Gauntlet 29:</label>
<input type="text" id="gauntlet-29-name" name="gauntlet-29-name" value="Halloween"><br>
<label for="gauntlet-29-textcolor">Gauntlet 29 Text Color:</label>
<input type="color" id="gauntlet-29-textcolor" name="gauntlet-29-textcolor" value="#FF7700"><br>
<label for="gauntlet-29-bgcolor">Gauntlet 29 BG Color:</label>
<input type="color" id="gauntlet-29-bgcolor" name="gauntlet-29-bgcolor" value="#3D1600"><br>

<label for="gauntlet-30-name">Gauntlet 30:</label>
<input type="text" id="gauntlet-30-name" name="gauntlet-30-name" value="Treasure"><br>
<label for="gauntlet-30-textcolor">Gauntlet 30 Text Color:</label>
<input type="color" id="gauntlet-30-textcolor" name="gauntlet-30-textcolor" value="#FFDC00"><br>
<label for="gauntlet-30-bgcolor">Gauntlet 30 BG Color:</label>
<input type="color" id="gauntlet-30-bgcolor" name="gauntlet-30-bgcolor" value="#1F2C22"><br>

<label for="gauntlet-31-name">Gauntlet 31:</label>
<input type="text" id="gauntlet-31-name" name="gauntlet-31-name" value="Ghost"><br>
<label for="gauntlet-31-textcolor">Gauntlet 31 Text Color:</label>
<input type="color" id="gauntlet-31-textcolor" name="gauntlet-31-textcolor" value="#FFFFFF"><br>
<label for="gauntlet-31-bgcolor">Gauntlet 31 BG Color:</label>
<input type="color" id="gauntlet-31-bgcolor" name="gauntlet-31-bgcolor" value="#002843"><br>

<label for="gauntlet-32-name">Gauntlet 32:</label>
<input type="text" id="gauntlet-32-name" name="gauntlet-32-name" value="Spider"><br>
<label for="gauntlet-32-textcolor">Gauntlet 32 Text Color:</label>
<input type="color" id="gauntlet-32-textcolor" name="gauntlet-32-textcolor" value="#B059FF"><br>
<label for="gauntlet-32-bgcolor">Gauntlet 32 BG Color:</label>
<input type="color" id="gauntlet-32-bgcolor" name="gauntlet-32-bgcolor" value="#261B2F"><br>

<label for="gauntlet-33-name">Gauntlet 33:</label>
<input type="text" id="gauntlet-33-name" name="gauntlet-33-name" value="Gem"><br>
<label for="gauntlet-33-textcolor">Gauntlet 33 Text Color:</label>
<input type="color" id="gauntlet-33-textcolor" name="gauntlet-33-textcolor" value="#00EBFF"><br>
<label for="gauntlet-33-bgcolor">Gauntlet 33 BG Color:</label>
<input type="color" id="gauntlet-33-bgcolor" name="gauntlet-33-bgcolor" value="#003B6A"><br>

<label for="gauntlet-34-name">Gauntlet 34:</label>
<input type="text" id="gauntlet-34-name" name="gauntlet-34-name" value="Inferno"><br>
<label for="gauntlet-34-textcolor">Gauntlet 34 Text Color:</label>
<input type="color" id="gauntlet-34-textcolor" name="gauntlet-34-textcolor" value="#00FF00"><br>
<label for="gauntlet-34-bgcolor">Gauntlet 34 BG Color:</label>
<input type="color" id="gauntlet-34-bgcolor" name="gauntlet-34-bgcolor" value="#450040"><br>

<label for="gauntlet-35-name">Gauntlet 35:</label>
<input type="text" id="gauntlet-35-name" name="gauntlet-35-name" value="Portal"><br>
<label for="gauntlet-35-textcolor">Gauntlet 35 Text Color:</label>
<input type="color" id="gauntlet-35-textcolor" name="gauntlet-35-textcolor" value="#00FFFF"><br>
<label for="gauntlet-35-bgcolor">Gauntlet 35 BG Color:</label>
<input type="color" id="gauntlet-35-bgcolor" name="gauntlet-35-bgcolor" value="#2D1757"><br>

<label for="gauntlet-36-name">Gauntlet 36:</label>
<input type="text" id="gauntlet-36-name" name="gauntlet-36-name" value="Strange"><br>
<label for="gauntlet-36-textcolor">Gauntlet 36 Text Color:</label>
<input type="color" id="gauntlet-36-textcolor" name="gauntlet-36-textcolor" value="#78FF00"><br>
<label for="gauntlet-36-bgcolor">Gauntlet 36 BG Color:</label>
<input type="color" id="gauntlet-36-bgcolor" name="gauntlet-36-bgcolor" value="#55007C"><br>

<label for="gauntlet-37-name">Gauntlet 37:</label>
<input type="text" id="gauntlet-37-name" name="gauntlet-37-name" value="Fantasy"><br>
<label for="gauntlet-37-textcolor">Gauntlet 37 Text Color:</label>
<input type="color" id="gauntlet-37-textcolor" name="gauntlet-37-textcolor" value="#C7FF00"><br>
<label for="gauntlet-37-bgcolor">Gauntlet 37 BG Color:</label>
<input type="color" id="gauntlet-37-bgcolor" name="gauntlet-37-bgcolor" value="#245200"><br>

<label for="gauntlet-38-name">Gauntlet 38:</label>
<input type="text" id="gauntlet-38-name" name="gauntlet-38-name" value="Christmas"><br>
<label for="gauntlet-38-textcolor">Gauntlet 38 Text Color:</label>
<input type="color" id="gauntlet-38-textcolor" name="gauntlet-38-textcolor" value="#FFFFFF"><br>
<label for="gauntlet-38-bgcolor">Gauntlet 38 BG Color:</label>
<input type="color" id="gauntlet-38-bgcolor" name="gauntlet-38-bgcolor" value="#0077D3"><br>

<label for="gauntlet-39-name">Gauntlet 39:</label>
<input type="text" id="gauntlet-39-name" name="gauntlet-39-name" value="Surprise"><br>
<label for="gauntlet-39-textcolor">Gauntlet 39 Text Color:</label>
<input type="color" id="gauntlet-39-textcolor" name="gauntlet-39-textcolor" value="#FFFFFF"><br>
<label for="gauntlet-39-bgcolor">Gauntlet 39 BG Color:</label>
<input type="color" id="gauntlet-39-bgcolor" name="gauntlet-39-bgcolor" value="#692A00"><br>

<label for="gauntlet-40-name">Gauntlet 40:</label>
<input type="text" id="gauntlet-40-name" name="gauntlet-40-name" value="Mystery"><br>
<label for="gauntlet-40-textcolor">Gauntlet 40 Text Color:</label>
<input type="color" id="gauntlet-40-textcolor" name="gauntlet-40-textcolor" value="#FDFF00"><br>
<label for="gauntlet-40-bgcolor">Gauntlet 40 BG Color:</label>
<input type="color" id="gauntlet-40-bgcolor" name="gauntlet-40-bgcolor" value="#112A00"><br>

<label for="gauntlet-41-name">Gauntlet 41:</label>
<input type="text" id="gauntlet-41-name" name="gauntlet-41-name" value="Cursed"><br>
<label for="gauntlet-41-textcolor">Gauntlet 41 Text Color:</label>
<input type="color" id="gauntlet-41-textcolor" name="gauntlet-41-textcolor" value="#00FF00"><br>
<label for="gauntlet-41-bgcolor">Gauntlet 41 BG Color:</label>
<input type="color" id="gauntlet-41-bgcolor" name="gauntlet-41-bgcolor" value="#450029"><br>

<label for="gauntlet-42-name">Gauntlet 42:</label>
<input type="text" id="gauntlet-42-name" name="gauntlet-42-name" value="Cyborg"><br>
<label for="gauntlet-42-textcolor">Gauntlet 42 Text Color:</label>
<input type="color" id="gauntlet-42-textcolor" name="gauntlet-42-textcolor" value="#00FFFF"><br>
<label for="gauntlet-42-bgcolor">Gauntlet 42 BG Color:</label>
<input type="color" id="gauntlet-42-bgcolor" name="gauntlet-42-bgcolor" value="#282828"><br>

<label for="gauntlet-43-name">Gauntlet 43:</label>
<input type="text" id="gauntlet-43-name" name="gauntlet-43-name" value="Castle"><br>
<label for="gauntlet-43-textcolor">Gauntlet 43 Text Color:</label>
<input type="color" id="gauntlet-43-textcolor" name="gauntlet-43-textcolor" value="#FFFFFF"><br>
<label for="gauntlet-43-bgcolor">Gauntlet 43 BG Color:</label>
<input type="color" id="gauntlet-43-bgcolor" name="gauntlet-43-bgcolor" value="#0053D4"><br>

<label for="gauntlet-44-name">Gauntlet 44:</label>
<input type="text" id="gauntlet-44-name" name="gauntlet-44-name" value="Grave"><br>
<label for="gauntlet-44-textcolor">Gauntlet 44 Text Color:</label>
<input type="color" id="gauntlet-44-textcolor" name="gauntlet-44-textcolor" value="#51FDA6"><br>
<label for="gauntlet-44-bgcolor">Gauntlet 44 BG Color:</label>
<input type="color" id="gauntlet-44-bgcolor" name="gauntlet-44-bgcolor" value="#002828"><br>

<label for="gauntlet-45-name">Gauntlet 45:</label>
<input type="text" id="gauntlet-45-name" name="gauntlet-45-name" value="Temple"><br>
<label for="gauntlet-45-textcolor">Gauntlet 45 Text Color:</label>
<input type="color" id="gauntlet-45-textcolor" name="gauntlet-45-textcolor" value="#F7FE90"><br>
<label for="gauntlet-45-bgcolor">Gauntlet 45 BG Color:</label>
<input type="color" id="gauntlet-45-bgcolor" name="gauntlet-45-bgcolor" value="#003A00"><br>

<label for="gauntlet-46-name">Gauntlet 46:</label>
<input type="text" id="gauntlet-46-name" name="gauntlet-46-name" value="World"><br>
<label for="gauntlet-46-textcolor">Gauntlet 46 Text Color:</label>
<input type="color" id="gauntlet-46-textcolor" name="gauntlet-46-textcolor" value="#FFFFFF"><br>
<label for="gauntlet-46-bgcolor">Gauntlet 46 BG Color:</label>
<input type="color" id="gauntlet-46-bgcolor" name="gauntlet-46-bgcolor" value="#0051AC"><br>

<label for="gauntlet-47-name">Gauntlet 47:</label>
<input type="text" id="gauntlet-47-name" name="gauntlet-47-name" value="Galaxy"><br>
<label for="gauntlet-47-textcolor">Gauntlet 47 Text Color:</label>
<input type="color" id="gauntlet-47-textcolor" name="gauntlet-47-textcolor" value="#FFBBFF"><br>
<label for="gauntlet-47-bgcolor">Gauntlet 47 BG Color:</label>
<input type="color" id="gauntlet-47-bgcolor" name="gauntlet-47-bgcolor" value="#351B3D"><br>

<label for="gauntlet-48-name">Gauntlet 48:</label>
<input type="text" id="gauntlet-48-name" name="gauntlet-48-name" value="Universe"><br>
<label for="gauntlet-48-textcolor">Gauntlet 48 Text Color:</label>
<input type="color" id="gauntlet-48-textcolor" name="gauntlet-48-textcolor" value="#00FFFF"><br>
<label for="gauntlet-48-bgcolor">Gauntlet 48 BG Color:</label>
<input type="color" id="gauntlet-48-bgcolor" name="gauntlet-48-bgcolor" value="#191843"><br>

<label for="gauntlet-49-name">Gauntlet 49:</label>
<input type="text" id="gauntlet-49-name" name="gauntlet-49-name" value="Discord"><br>
<label for="gauntlet-49-textcolor">Gauntlet 49 Text Color:</label>
<input type="color" id="gauntlet-49-textcolor" name="gauntlet-49-textcolor" value="#66FFFF"><br>
<label for="gauntlet-49-bgcolor">Gauntlet 49 BG Color:</label>
<input type="color" id="gauntlet-49-bgcolor" name="gauntlet-49-bgcolor" value="#0F1F39"><br>

<label for="gauntlet-50-name">Gauntlet 50:</label>
<input type="text" id="gauntlet-50-name" name="gauntlet-50-name" value="Split"><br>
<label for="gauntlet-50-textcolor">Gauntlet 50 Text Color:</label>
<input type="color" id="gauntlet-50-textcolor" name="gauntlet-50-textcolor" value="#FFA7FB"><br>
<label for="gauntlet-50-bgcolor">Gauntlet 50 BG Color:</label>
<input type="color" id="gauntlet-50-bgcolor" name="gauntlet-50-bgcolor" value="#3A0037"><br>

<label for="gauntlet-51-name">Gauntlet 51:</label>
<input type="text" id="gauntlet-51-name" name="gauntlet-51-name" value="NCS I"><br>
<label for="gauntlet-51-textcolor">Gauntlet 51 Text Color:</label>
<input type="color" id="gauntlet-51-textcolor" name="gauntlet-51-textcolor" value="#00FFFF"><br>
<label for="gauntlet-51-bgcolor">Gauntlet 51 BG Color:</label>
<input type="color" id="gauntlet-51-bgcolor" name="gauntlet-51-bgcolor" value="#023139"><br>

<label for="gauntlet-52-name">Gauntlet 52:</label>
<input type="text" id="gauntlet-52-name" name="gauntlet-52-name" value="NCS II"><br>
<label for="gauntlet-52-textcolor">Gauntlet 52 Text Color:</label>
<input type="color" id="gauntlet-52-textcolor" name="gauntlet-52-textcolor" value="#FFAAFF"><br>
<label for="gauntlet-52-bgcolor">Gauntlet 52 BG Color:</label>
<input type="color" id="gauntlet-52-bgcolor" name="gauntlet-52-bgcolor" value="#341536"><br>

<label for="gauntlet-53-name">Gauntlet 53:</label>
<input type="text" id="gauntlet-53-name" name="gauntlet-53-name" value="Space"><br>
<label for="gauntlet-53-textcolor">Gauntlet 53 Text Color:</label>
<input type="color" id="gauntlet-53-textcolor" name="gauntlet-53-textcolor" value="#32ffff"><br>
<label for="gauntlet-53-bgcolor">Gauntlet 53 BG Color:</label>
<input type="color" id="gauntlet-53-bgcolor" name="gauntlet-53-bgcolor" value="#162a35"><br>

<label for="gauntlet-54-name">Gauntlet 54:</label>
<input type="text" id="gauntlet-54-name" name="gauntlet-54-name" value="Cosmos"><br>
<label for="gauntlet-54-textcolor">Gauntlet 54 Text Color:</label>
<input type="color" id="gauntlet-54-textcolor" name="gauntlet-54-textcolor" value="#f9c800"><br>
<label for="gauntlet-54-bgcolor">Gauntlet 54 BG Color:</label>
<input type="color" id="gauntlet-54-bgcolor" name="gauntlet-54-bgcolor" value="#2c2424"><br>

        </div>
    </fieldset>




    <fieldset><legend><h5>GDBrowser Settings</h5></legend>

        <h2>GDPS Basic Settings</h2><br>

        <label for="gdbrowser_title">GDPS Title:</label>
        <input type="text" id="gdbrowser_title" name="gdbrowser_title"><br>
        <label for="gdbrowser_name">GDPS Name:</label>
        <input type="text" id="gdbrowser_name" name="gdbrowser_name"><br>
        <label for="gdbrowser_icon">GDPS Icon:</label>
        <input type="text" id="gdbrowser_icon" name="gdbrowser_icon"><br>
        <label for="gdps_version">GDPS Version:</label>
        <input type="number" id="gdps_version" required name="gdps_version"><br>
        <label for="show_level_passwords">Show Level Passwords:</label>
        <label for="">
            <input type="radio" id="show_level_passwords-0" name="show_level_passwords" value="0">
            Disable
        </label>
        <label for="">
            <input type="radio" id="show_level_passwords-1" name="show_level_passwords" value="1">
            Enable
        </label>
        <label for="gdbrowser_desc">GDPS Description:</label>
        <input type="text" size="100" id="gdbrowser_desc" name="gdbrowser_desc"><br>

        <label>Theme Settings:</label>
        <label for="">
            <input type="radio" id="browser_theme-0" name="browser_theme" value="0">
            Disable automatic event themes
        </label>
        <label for="">
            <input type="radio" id="browser_theme-1" name="browser_theme" value="1">
            Enable automatic event themes
        </label>
        <br>
        <label for="browser_theme_path">Custom CSS Path <label style="color:#af0000;">[Recommended to place in "customfiles/" folder]</label>: </label>
        <input type="text" size="50" id="browser_theme_path" name="browser_theme_path" placeholder="customfiles/mycustomtheme.css"><br>

        <label for="disable_colored_texture_level_browser">Colored Texture Level Browser:</label>
        <label for="">
            <input type="radio" id="disable_colored_texture_level_browser-0" name="disable_colored_texture_level_browser" value="0">
            Disable
        </label>
        <label for="">
            <input type="radio" id="disable_colored_texture_level_browser-1" name="disable_colored_texture_level_browser" value="1">
            Enable
        </label>
    <!-- More -->
        <h2>GDPS Assets Settings</h2><br>

        <label for="gdbrowser_icon_embed">GDPS Icon URL (for embeds) <label style="color:#af0000;">[ONLY .JPG, JPEG AND .PNG]</label>: </label>
        <input type="text" id="gdbrowser_icon_embed" name="gdbrowser_icon_embed"><br>
        <label for="gdbrowser_assets_full_url">GDPS Assets Folder URL (for embeds):</label>
        <input type="text" size="50" id="gdbrowser_assets_full_url" name="gdbrowser_assets_full_url"><br>
        <label for="gdps_logo_url">GDPS Logo URL:</label>
        <input type="text" id="gdps_logo_url" name="gdps_logo_url"><br>
        <label for="gdps_level_browser_logo_url">GDPS Level Browser Logo URL:</label>
        <input type="text" id="gdps_level_browser_logo_url" name="gdps_level_browser_logo_url"><br>
        
        <h2>GDPS Advanced Settings</h2><br>


        <label>Server Software:</label>
        <label for="automatic">
            <input type="radio" id="server_software-automatic" name="server_software" value="automatic">
            Automatic
        </label>
        <label for="apache">
            <input type="radio" id="server_software-apache" name="server_software" value="apache">
            Apache
        </label>
        <label for="nginx">
            <input type="radio" id="server_software-nginx" name="server_software" value="nginx">
            Nginx <label style="color:#af0000;">(Needs install nginx.conf)</label>
        </label>
        <label for="legacy">
            <input type="radio" id="server_software-legacy" name="server_software" value="legacy">
            Legacy (Compatible with most host servers)
        </label>
        <br>

        <label for="path_connection">Path Connection <label style="color:#af0000;">(Deprecated, please configure "Lib Folder"!):</label></label>
        <input type="text" id="path_connection" name="path_connection"><br>
        <label for="path_lib_folder" placeholder="../incl/lib/">Lib Folder:</label>
        <input type="text" id="path_lib_folder" required name="path_lib_folder"><br>
        <label for="path_browser_folder" placeholder="../incl/lib/">Browser Folder:</label>
        <input type="text" id="browser_path" required name="browser_path" value="browser/"><br>
        <label for="path_folder_levels">Levels Path Folder (Important for the level analyzer!)</label>
        <input type="text" id="path_folder_levels" placeholder="../../data/levels/" name="path_folder_levels"><br>
        
        <h2>App installer</h2><br>
        <!-- App Start URL -->
        <label for="manifest_start_url">App Start URL</label>
        <input type="text" id="manifest_start_url" placeholder="/browser/" name="manifest_start_url" value="/browser/" required><br>

        <!-- App Name -->
        <label for="manifest_name">App Name</label>
        <input type="text" id="manifest_name" placeholder="MyGDPS: ObeyGDBrowser" name="manifest_name" value="MyGDPS: ObeyGDBrowser" required><br>

        <!-- App Theme Color -->
        <label for="manifest_theme_color">App Theme Color</label>
        <input type="color" id="manifest_theme_color" name="manifest_theme_color" value="#000000" required><br>

        <!-- App Background Color -->
        <label for="manifest_background_color">App Background Color</label>
        <input type="color" id="manifest_background_color" name="manifest_background_color" value="#000000" required><br>

        <!-- App Short Name -->
        <label for="manifest_short_name">App Short Name</label>
        <input type="text" id="manifest_short_name" placeholder="MyGDPS: ObeyGDBrowser" name="manifest_short_name" value="MyGDPS: ObeyGDBrowser" required><br>

        <!-- App Description -->
        <label for="manifest_description">App Description</label>
        <input type="text" id="manifest_description" placeholder="My GDPS! :D" name="manifest_description" value="My GDPS! :D" required><br>
    </fieldset>


        <br>

        <input type="submit" value="Save">
        <button type="button" onclick="window.location.href = '../';">Back</button>

    </form>
    </fieldset>



    <script>
    
    const jsonData = <?php echo json_encode($gdps_settings); ?>;

function loadValues() {
    for (const key in jsonData) {
        let keyData = jsonData[key];

        console.log(keyData);
        
        if (keyData.constructor === ({}).constructor) {
            for (const subKey in keyData) {
                let subkeyData = keyData[subKey];
                
                try {
                    if(key != "gauntlets") {
                        let element = document.getElementById(`${key}-${subKey}`);
                        element.value = subkeyData;
                    }
                    
                } catch (e) {
                    console.log("ID Element not found: ", key, "-", subKey);
                }

                try {
                    if(key == "gauntlets") {
                        let rkey = key.replace("gauntlets","gauntlet")
                        let element = document.getElementById(`${rkey}-${subKey}-name`);
                        element.value = (subkeyData.name ?? "") || "Unknown";
                        element = document.getElementById(`${rkey}-${subKey}-textcolor`);
                        element.value = (subkeyData.textColor ?? "") || "#c8c8c8";
                        element = document.getElementById(`${rkey}-${subKey}-bgcolor`);
                        element.value = (subkeyData.bgColor ?? "") || "#c8c8c8";
                    }
                } catch (e) {
                    console.log("ID Element not found: ", key, "-", subKey, "-name/-textcolor/-bgcolor");
                }
            }
        } else {

            try {
                
                let element = document.getElementById(`${key}`);
                element.value = keyData;

            } catch (e) {
                try {
                let element = document.getElementById(`${key}-${keyData}`);
                if (element.value === keyData){
                    element.checked = true;
                            
                } 
            } catch (e) {
                console.log("ID Element not found: ", key);
            }
            console.log("ID Element not found: ", key);
            }
        }
    }
}

loadValues();

// Manifest

fetch('../manifest.json')
    .then(response => response.json())
    .then(data => {
        document.getElementById('manifest_name').value = data.name;
        document.getElementById('manifest_theme_color').value = data.theme_color;
        document.getElementById('manifest_background_color').value = data.background_color;
        document.getElementById('manifest_short_name').value = data.short_name;
        document.getElementById('manifest_description').value = data.description;
        document.getElementById('manifest_start_url').value = data.start_url;
    })
    .catch(console.error);

    </script>

<script>

document.querySelectorAll('.toggle-btn').forEach(button => {
        button.addEventListener('click', function() {
            const content = this.nextElementSibling;
            if (content && content.classList.contains('content')) {
                content.classList.toggle('hidden');
            }
            this.classList.toggle('collapsed');
        });
});

</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById('theme-toggle');
    
    function applyTheme(theme) {
        document.body.classList.toggle('dark', theme === 'dark');
        document.body.classList.toggle('light', theme === 'light');
        if(theme == 'dark') {
            document.getElementById('theme-emoji').textContent = "🌙";
            document.getElementById('theme-text').textContent = "Dark";
        } else {
            document.getElementById('theme-emoji').textContent = "☀";
            document.getElementById('theme-text').textContent = "Light";
        }
        const elements = document.querySelectorAll('fieldset, legend, input[type="text"], input[type="number"], input[type="submit"], button, .error-message, .info');
        elements.forEach(el => {
            el.classList.toggle('dark', theme === 'dark');
            el.classList.toggle('light', theme === 'light');
        });
    }

    const savedTheme = localStorage.getItem('theme-settings') || 'light';
    applyTheme(savedTheme);

    toggleButton.addEventListener('click', () => {
        const currentTheme = document.body.classList.contains('dark') ? 'dark' : 'light';
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        applyTheme(newTheme);
        localStorage.setItem('theme-settings', newTheme);
    });
});
</script>


<!-- 




    PHP CODE




 -->



<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($failed_conn) {

    } else if($logged && $isAdmin) {} else {echo "No permissions";} 
    function get_post_value($key) {
        return isset($_POST[$key]) ? $_POST[$key] : "";
    }

    // Obtener los valores del formulario y almacenarlos en un diccionario PHP
    $gdps_settings = array(
        "length" => array(
            "-1" => "",
            "0" => get_post_value("length-0"),
            "1" => get_post_value("length-1"),
            "2" => get_post_value("length-2"),
            "3" => get_post_value("length-3"),
            "4" => get_post_value("length-4"),
            "5" => get_post_value("length-5")
        ),
        "featured" => array(
            "-1" => "",
            "0" => get_post_value("featured-0"),
            "1" => get_post_value("featured-1")
        ),
        "epic" => array(
            "-1" => "",
            "0" => get_post_value("epic-0"),
            "1" => get_post_value("epic-1"),
            "2" => get_post_value("epic-2"),
            "3" => get_post_value("epic-3")
        ),
        "states_demon" => array(
            "-1" => "",
            "0" => get_post_value("states_demon-0"),
            "3" => get_post_value("states_demon-3"),
            "4" => get_post_value("states_demon-4"),
            "5" => get_post_value("states_demon-5"),
            "6" => get_post_value("states_demon-6")
        ),
        "states_diff_num" => array(
            "-1" => "",
            "0" => get_post_value("states_diff_num-0"),
            "10" => get_post_value("states_diff_num-10"),
            "20" => get_post_value("states_diff_num-20"),
            "30" => get_post_value("states_diff_num-30"),
            "40" => get_post_value("states_diff_num-40"),
            "50" => get_post_value("states_diff_num-50")
        ),
        "gauntlets" => array(
            "-1" => array(
                "name" => "",
                "textColor" => "",
                "bgColor" => ""
            ),
            "0" => array(
                "name" => get_post_value("gauntlet-0-name"),
                "textColor" => get_post_value("gauntlet-0-textcolor"),
                "bgColor" => get_post_value("gauntlet-0-bgcolor")
            ),
            "1" => array(
                "name" => get_post_value("gauntlet-1-name"),
                "textColor" => get_post_value("gauntlet-1-textcolor"),
                "bgColor" => get_post_value("gauntlet-1-bgcolor")
            ),
            "2" => array(
                "name" => get_post_value("gauntlet-2-name"),
                "textColor" => get_post_value("gauntlet-2-textcolor"),
                "bgColor" => get_post_value("gauntlet-2-bgcolor")
            ),
            "3" => array(
                "name" => get_post_value("gauntlet-3-name"),
                "textColor" => get_post_value("gauntlet-3-textcolor"),
                "bgColor" => get_post_value("gauntlet-3-bgcolor")
            ),
            "4" => array(
                "name" => get_post_value("gauntlet-4-name"),
                "textColor" => get_post_value("gauntlet-4-textcolor"),
                "bgColor" => get_post_value("gauntlet-4-bgcolor")
            ),
            "5" => array(
                "name" => get_post_value("gauntlet-5-name"),
                "textColor" => get_post_value("gauntlet-5-textcolor"),
                "bgColor" => get_post_value("gauntlet-5-bgcolor")
            ),
            "6" => array(
                "name" => get_post_value("gauntlet-6-name"),
                "textColor" => get_post_value("gauntlet-6-textcolor"),
                "bgColor" => get_post_value("gauntlet-6-bgcolor")
            ),
            "7" => array(
                "name" => get_post_value("gauntlet-7-name"),
                "textColor" => get_post_value("gauntlet-7-textcolor"),
                "bgColor" => get_post_value("gauntlet-7-bgcolor")
            ),
            "8" => array(
                "name" => get_post_value("gauntlet-8-name"),
                "textColor" => get_post_value("gauntlet-8-textcolor"),
                "bgColor" => get_post_value("gauntlet-8-bgcolor")
            ),
            "9" => array(
                "name" => get_post_value("gauntlet-9-name"),
                "textColor" => get_post_value("gauntlet-9-textcolor"),
                "bgColor" => get_post_value("gauntlet-9-bgcolor")
            ),
            "10" => array(
                "name" => get_post_value("gauntlet-10-name"),
                "textColor" => get_post_value("gauntlet-10-textcolor"),
                "bgColor" => get_post_value("gauntlet-10-bgcolor")
            ),
            "11" => array(
                "name" => get_post_value("gauntlet-11-name"),
                "textColor" => get_post_value("gauntlet-11-textcolor"),
                "bgColor" => get_post_value("gauntlet-11-bgcolor")
            ),
            "12" => array(
                "name" => get_post_value("gauntlet-12-name"),
                "textColor" => get_post_value("gauntlet-12-textcolor"),
                "bgColor" => get_post_value("gauntlet-12-bgcolor")
            ),
            "13" => array(
                "name" => get_post_value("gauntlet-13-name"),
                "textColor" => get_post_value("gauntlet-13-textcolor"),
                "bgColor" => get_post_value("gauntlet-13-bgcolor")
            ),
            "14" => array(
                "name" => get_post_value("gauntlet-14-name"),
                "textColor" => get_post_value("gauntlet-14-textcolor"),
                "bgColor" => get_post_value("gauntlet-14-bgcolor")
            ),
            "15" => array(
                "name" => get_post_value("gauntlet-15-name"),
                "textColor" => get_post_value("gauntlet-15-textcolor"),
                "bgColor" => get_post_value("gauntlet-15-bgcolor")
            ),
            "16" => array(
                "name" => get_post_value("gauntlet-16-name"),
                "textColor" => get_post_value("gauntlet-16-textcolor"),
                "bgColor" => get_post_value("gauntlet-16-bgcolor")
            ),
            "17" => array(
                "name" => get_post_value("gauntlet-17-name"),
                "textColor" => get_post_value("gauntlet-17-textcolor"),
                "bgColor" => get_post_value("gauntlet-17-bgcolor")
            ),
            "18" => array(
                "name" => get_post_value("gauntlet-18-name"),
                "textColor" => get_post_value("gauntlet-18-textcolor"),
                "bgColor" => get_post_value("gauntlet-18-bgcolor")
            ),
            "19" => array(
                "name" => get_post_value("gauntlet-19-name"),
                "textColor" => get_post_value("gauntlet-19-textcolor"),
                "bgColor" => get_post_value("gauntlet-19-bgcolor")
            ),
            "20" => array(
                "name" => get_post_value("gauntlet-20-name"),
                "textColor" => get_post_value("gauntlet-20-textcolor"),
                "bgColor" => get_post_value("gauntlet-20-bgcolor")
            ),
            "21" => array(
                "name" => get_post_value("gauntlet-21-name"),
                "textColor" => get_post_value("gauntlet-21-textcolor"),
                "bgColor" => get_post_value("gauntlet-21-bgcolor")
            ),
            "22" => array(
                "name" => get_post_value("gauntlet-22-name"),
                "textColor" => get_post_value("gauntlet-22-textcolor"),
                "bgColor" => get_post_value("gauntlet-22-bgcolor")
            ),
            "23" => array(
                "name" => get_post_value("gauntlet-23-name"),
                "textColor" => get_post_value("gauntlet-23-textcolor"),
                "bgColor" => get_post_value("gauntlet-23-bgcolor")
            ),
            "24" => array(
                "name" => get_post_value("gauntlet-24-name"),
                "textColor" => get_post_value("gauntlet-24-textcolor"),
                "bgColor" => get_post_value("gauntlet-24-bgcolor")
            ),
            "25" => array(
                "name" => get_post_value("gauntlet-25-name"),
                "textColor" => get_post_value("gauntlet-25-textcolor"),
                "bgColor" => get_post_value("gauntlet-25-bgcolor")
            ),
            "26" => array(
                "name" => get_post_value("gauntlet-26-name"),
                "textColor" => get_post_value("gauntlet-26-textcolor"),
                "bgColor" => get_post_value("gauntlet-26-bgcolor")
            ),
            "27" => array(
                "name" => get_post_value("gauntlet-27-name"),
                "textColor" => get_post_value("gauntlet-27-textcolor"),
                "bgColor" => get_post_value("gauntlet-27-bgcolor")
            ),
            "28" => array(
                "name" => get_post_value("gauntlet-28-name"),
                "textColor" => get_post_value("gauntlet-28-textcolor"),
                "bgColor" => get_post_value("gauntlet-28-bgcolor")
            ),
            "29" => array(
                "name" => get_post_value("gauntlet-29-name"),
                "textColor" => get_post_value("gauntlet-29-textcolor"),
                "bgColor" => get_post_value("gauntlet-29-bgcolor")
            ),
            "30" => array(
                "name" => get_post_value("gauntlet-30-name"),
                "textColor" => get_post_value("gauntlet-30-textcolor"),
                "bgColor" => get_post_value("gauntlet-30-bgcolor")
            ),
            "31" => array(
                "name" => get_post_value("gauntlet-31-name"),
                "textColor" => get_post_value("gauntlet-31-textcolor"),
                "bgColor" => get_post_value("gauntlet-31-bgcolor")
            ),
            "32" => array(
                "name" => get_post_value("gauntlet-32-name"),
                "textColor" => get_post_value("gauntlet-32-textcolor"),
                "bgColor" => get_post_value("gauntlet-32-bgcolor")
            ),
            "33" => array(
                "name" => get_post_value("gauntlet-33-name"),
                "textColor" => get_post_value("gauntlet-33-textcolor"),
                "bgColor" => get_post_value("gauntlet-33-bgcolor")
            ),
            "34" => array(
                "name" => get_post_value("gauntlet-34-name"),
                "textColor" => get_post_value("gauntlet-34-textcolor"),
                "bgColor" => get_post_value("gauntlet-34-bgcolor")
            ),
            "35" => array(
                "name" => get_post_value("gauntlet-35-name"),
                "textColor" => get_post_value("gauntlet-35-textcolor"),
                "bgColor" => get_post_value("gauntlet-35-bgcolor")
            ),
            "36" => array(
                "name" => get_post_value("gauntlet-36-name"),
                "textColor" => get_post_value("gauntlet-36-textcolor"),
                "bgColor" => get_post_value("gauntlet-36-bgcolor")
            ),
            "37" => array(
                "name" => get_post_value("gauntlet-37-name"),
                "textColor" => get_post_value("gauntlet-37-textcolor"),
                "bgColor" => get_post_value("gauntlet-37-bgcolor")
            ),
            "38" => array(
                "name" => get_post_value("gauntlet-38-name"),
                "textColor" => get_post_value("gauntlet-38-textcolor"),
                "bgColor" => get_post_value("gauntlet-38-bgcolor")
            ),
            "39" => array(
                "name" => get_post_value("gauntlet-39-name"),
                "textColor" => get_post_value("gauntlet-39-textcolor"),
                "bgColor" => get_post_value("gauntlet-39-bgcolor")
            ),
            "40" => array(
                "name" => get_post_value("gauntlet-40-name"),
                "textColor" => get_post_value("gauntlet-40-textcolor"),
                "bgColor" => get_post_value("gauntlet-40-bgcolor")
            ),
            "41" => array(
                "name" => get_post_value("gauntlet-41-name"),
                "textColor" => get_post_value("gauntlet-41-textcolor"),
                "bgColor" => get_post_value("gauntlet-41-bgcolor")
            ),
            "42" => array(
                "name" => get_post_value("gauntlet-42-name"),
                "textColor" => get_post_value("gauntlet-42-textcolor"),
                "bgColor" => get_post_value("gauntlet-42-bgcolor")
            ),
            "43" => array(
                "name" => get_post_value("gauntlet-43-name"),
                "textColor" => get_post_value("gauntlet-43-textcolor"),
                "bgColor" => get_post_value("gauntlet-43-bgcolor")
            ),
            "44" => array(
                "name" => get_post_value("gauntlet-44-name"),
                "textColor" => get_post_value("gauntlet-44-textcolor"),
                "bgColor" => get_post_value("gauntlet-44-bgcolor")
            ),
            "45" => array(
                "name" => get_post_value("gauntlet-45-name"),
                "textColor" => get_post_value("gauntlet-45-textcolor"),
                "bgColor" => get_post_value("gauntlet-45-bgcolor")
            ),
            "46" => array(
                "name" => get_post_value("gauntlet-46-name"),
                "textColor" => get_post_value("gauntlet-46-textcolor"),
                "bgColor" => get_post_value("gauntlet-46-bgcolor")
            ),
            "47" => array(
                "name" => get_post_value("gauntlet-47-name"),
                "textColor" => get_post_value("gauntlet-47-textcolor"),
                "bgColor" => get_post_value("gauntlet-47-bgcolor")
            ),
            "48" => array(
                "name" => get_post_value("gauntlet-48-name"),
                "textColor" => get_post_value("gauntlet-48-textcolor"),
                "bgColor" => get_post_value("gauntlet-48-bgcolor")
            ),
            "49" => array(
                "name" => get_post_value("gauntlet-49-name"),
                "textColor" => get_post_value("gauntlet-49-textcolor"),
                "bgColor" => get_post_value("gauntlet-49-bgcolor")
            ),
            "50" => array(
                "name" => get_post_value("gauntlet-50-name"),
                "textColor" => get_post_value("gauntlet-50-textcolor"),
                "bgColor" => get_post_value("gauntlet-50-bgcolor")
            ),
            "51" => array(
                "name" => get_post_value("gauntlet-51-name"),
                "textColor" => get_post_value("gauntlet-51-textcolor"),
                "bgColor" => get_post_value("gauntlet-51-bgcolor")
            ),
            "52" => array(
                "name" => get_post_value("gauntlet-52-name"),
                "textColor" => get_post_value("gauntlet-52-textcolor"),
                "bgColor" => get_post_value("gauntlet-52-bgcolor")
            ),
            "53" => array(
                "name" => get_post_value("gauntlet-53-name"),
                "textColor" => get_post_value("gauntlet-53-textcolor"),
                "bgColor" => get_post_value("gauntlet-53-bgcolor")
            ),
            "54" => array(
                "name" => get_post_value("gauntlet-54-name"),
                "textColor" => get_post_value("gauntlet-54-textcolor"),
                "bgColor" => get_post_value("gauntlet-54-bgcolor")
            )
        ),
        "server_software" => get_post_value("server_software"),
        "gdbrowser_title" => get_post_value("gdbrowser_title"),
        "gdbrowser_name" => get_post_value("gdbrowser_name"),
        "gdbrowser_icon" => get_post_value("gdbrowser_icon"),
        "gdbrowser_icon_embed" => get_post_value("gdbrowser_icon_embed"),
        "gdbrowser_desc" => get_post_value("gdbrowser_desc"),
        "gdbrowser_assets_full_url" => get_post_value("gdbrowser_assets_full_url"),
        "show_level_passwords" => get_post_value("show_level_passwords"),
        "gdps_logo_url" => get_post_value("gdps_logo_url"),
        "gdps_level_browser_logo_url" => get_post_value("gdps_level_browser_logo_url"),
        "disable_colored_texture_level_browser" => get_post_value("disable_colored_texture_level_browser"),
        "path_connection" => get_post_value("path_connection"),
        "gdps_version" => get_post_value("gdps_version"),
        "path_lib_folder" => get_post_value("path_lib_folder"),
        "path_folder_levels" => get_post_value("path_folder_levels"),
        "browser_path" => get_post_value("browser_path"),
        "browser_theme_path" => get_post_value("browser_theme_path"),
        "browser_theme" => get_post_value("browser_theme")
    );

    $json_data = json_encode($gdps_settings, JSON_PRETTY_PRINT);
    file_put_contents("../gdps_settings.json", $json_data);


    $jsonFile = '../manifest.json';
    $data = json_decode(file_get_contents($jsonFile), true);

    $data['name'] = get_post_value('manifest_name');
    $data['theme_color'] = get_post_value('manifest_theme_color');
    $data['background_color'] = get_post_value('manifest_background_color');
    $data['short_name'] = get_post_value('manifest_short_name');
    $data['description'] = get_post_value('manifest_description');
    $data['start_url'] = get_post_value('manifest_start_url');

    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));


    ?>
    <script>
        alert("Configurations saved!");
        window.location.href = window.location.href;
    </script>

    <?php

} else {
    if($logged && $isAdmin) {} else {
        
    ?>
    <script>
        alert("Error saving!");
    </script>

    <?php
    } 
}
?>

</body>
</html>