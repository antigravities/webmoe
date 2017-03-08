<?php

$site_title="webmoe";
$site_logo="webms.png";

?>
<html>
        <head>
                <link href='//fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
                <script type="text/javascript">
                        var snds;
                        var audio;
                        var memes;

                        function getAudio(callback){
                                callback(<?php echo json_encode(array_splice(scandir("./audio"), 2)); ?>);
                        }

                        function getAudioRequired(callback){
                                callback(<?php echo file_get_contents("sound.json"); ?>);
                        }

                        window.addEventListener("load", function(){
                                <?php
                                        $files=json_encode(array_splice(scandir("./files"), 2));
                                ?>

                                        memes=<?php echo $files . "\n"; ?>
                                        getAudioRequired(function(a){
                                                audio=a;

                                                var phr = [ "{n} webms | <?php echo $site_title ?>" ];

                                                document.title = phr[0].replace("{n}", memes.length);
                                                document.getElementById("memeno").innerHTML = memes.length;

                                                var html = "";

                                                memes.forEach(function(v){
                                                        html+="<option value='" + v.split(".")[0] + "'>" + v.split(".")[0] + "</option>";
                                                });

                                                document.getElementById("webmselect").innerHTML+=html;

                                                meme();
                                        });

                                function meme(){
                                        if( document.getElementById('memevid') != null ) document.getElementById("memevid").pause();
                                        if( document.getElementById('audio') != null ) document.getElementById("audio").pause();
                                        var ok = false;
                                        var tribute;
                                        if( window.location.hash != "" && window.location.hash != "#new" && window.location.hash != "#" ){
                                                memes.forEach(function(v){
                                                        if( window.location.hash.substring(1) + ".webm" == v ){
                                                                tribute = window.location.hash.substring(1) + ".webm";
                                                                ok=true;
                                                        }
                                                });
                                        }
                                        if( ! ok ) tribute = memes[Math.floor(Math.random()*memes.length)];
                                        document.getElementById("meme").innerHTML="<a href='#new'><video id='memevid' autoplay loop><source src='./files/" + tribute + "'></source></video></a>";

                                        document.getElementById("memevid").addEventListener("load", function(){
                                                setTimeout(function(){
                                                        if( document.getElementById("memevid").paused ){
                                                                document.getElementById("androidfix").setAttribute("style", "display: inline");
                                                        }
                                                }, 1000);
                                        });

                                        document.getElementById("vidinfo").innerHTML="<a class='vdlink' href='#" + tribute.split(".")[0] + "'>" + tribute.split(".")[0] + "</a>";
                                        document.getElementById("webmselect").value=tribute.split(".")[0];

                                        if( ! ok ) window.location.hash="#" + tribute.split(".")[0];
                                        // document.getElementById("tributelink").setAttribute("href", window.location);
                                        audio.forEach(function(v){
                                                if( v == tribute && ! window._NOAUDIO ){
                                                        getAudio(function(aud){
                                                                // lazy
                                                                var audtribute = aud[Math.floor(Math.random()*aud.length)];
                                                                if( document.getElementById('audio') == null ){
                                                                        document.getElementById("meme").innerHTML+="<audio id='audio' autoplay loop><source src='./audio/" + audtribute + "'></audio>";
                                                                }
                                                        });
                                                }
                                        });

                                        if( navigator.userAgent.toLowerCase().indexOf("android") > -1 ) document.getElementById("android").setAttribute("style", "display: block;");

                                }

                                window.addEventListener("hashchange", meme);
                                /*
                                        document.getElementById("help").addEventListener("click", function(){
                                                document.getElementById("window").setAttribute("style", "display: block;");
                                        });

                                        document.getElementById("closebutton").addEventListener("click", function(){
                                                document.getElementById("window").setAttribute("style", "display: none;");
                                        });
                                */

                                document.getElementById("webmselect").addEventListener("change", function(){
                                        window.location.hash = document.getElementById("webmselect").value;
                                });

                                document.getElementById("android").addEventListener("click", function(){
                                        document.getElementById("memevid").play();
                                        document.getElementById("android").setAttribute("style", "display: none;");
                                });

                                if( window.location.toString().indexOf("?") > -1 ){
                                        var options = "";
                                        if( window.location.toString().indexOf("#") > -1 ) options=window.location.toString().substring(window.location.toString().indexOf("?")+1, window.location.toString().indexOf("#"));
                                        else options=window.location.toString().substring(window.location.toString().indexOf("?"));
                                        options=options.split(",");
                                        options.forEach(function(v,k){
                                                if( v == "white" ){
                                                        document.getElementById("help").setAttribute("style", "display: none");
                                                        document.getElementById("vidinfo").setAttribute("style", "display: none");
                                                        document.getElementsByTagName("body")[0].setAttribute("style", "overflow: hidden");
                                                }
                                                else if( v == "nosound" ){
                                                        window._NOAUDIO=true;
                                                }
                                        });
                                        console.log(options);
                                }

                        });
                </script>
                <style type='text/css'>
                        #memevid {
                                position: fixed;
                                top: 50%;
                                left: 50%;
                                transform: translateX(-50%) translateY(-50%);
                                -webkit-transform: translateX(-50%) translateY(-50%);
                                min-height: 100%;
                                min-width: 100%;
                                width: auto;
                                height: cover;
                                overflow: hidden;
                                /* z-index: -1000; */
                        }
                        body {
                                padding: 0;
                                margin: 0;
                                height: 100%;
                                /* overflow: hidden; */
                                overflow-x: hidden;
                        }
                        #help {
                                /* background: white; */
                                /* border-radius: 5px; */
                                position: fixed;
                                bottom: 10;
                                left: 20;
                                opacity: 0.2;
                                transition: 0.2s;
                                -webkit-transition: 0.2s;
                                z-index: 1001;
                        }
                        #help:hover {
                                opacity: 1.0;
                                transition: 0.2s;
                                -webkit-transition: 0.2s;
                        }
                        #window {
                                position: absolute;
                                top: 150%;
                                left: 50%;
                                transform: translateX(-50%) translateY(-50%);
                                -webkit-transform: translateX(-50%) translateY(-50%);
                                height: 50%;
                                width: 50%;
                                font-family: 'Helvetica';
                                padding-left: 5px;
                                padding-right: 5px;
                                /* z-index: 1001; */
                                color: white;
                        }
                        #android {
                                position: absolute;
                                top: 50%;
                                left: 50%;
                                transform: translateX(-50%) translateY(-50%);
                                -webkit-transform: translateX(-50%) translateY(-50%);
                                height: 50%;
                                font-family: 'Helvetica';
                                padding-left: 5px;
                                padding-right: 5px;
                                color: white;
                                text-align: center;
                                display: none;
                        }
                        #closebutton {
                                position: relative;
                                top: 0;
                                left: 0;
                        }
                        #vidinfo {
                                position: absolute;
                                bottom: 10;
                                right: 20;
                                font-family: 'Indie Flower';
                                font-size: 50px;
                                text-decoration: none;
                                color: black;
                        }
                        .vdlink {
                                font-size: 50px;
                                text-decoration: none;
                                color: red;
                        }
                        #bottom {
                                position: absolute;
                                top: 100%;
                                min-height: 100%;
                                min-width: 100%;
                                background-color: rgba(0,0,0,0.6);
                                /* z-index: 1000; */
                        }
                        #logo-bot {
                                position: absolute;
                                bottom: 0;
                                align: center;
                        }
                        #androidfix {
                                position: fixed;
                                top: 50%;
                                left: 50%;
                                transform: translateX(-50%) translateY(-50%);
                                -webkit-transform: translateX(-50%) translateY(-50%);
                                min-height: 100%;
                                min-width: 100%;
                                width: auto;
                                height: auto;
                                overflow: hidden;
                                display: none;
                                text-align: center;
                        }
                </style>
                <title>
                        your loading are memes...
                </title>
        </head>
        <body>
                <div id="meme">
                </div>
                <div id="vidinfo">
                </div>
                <span id="help">
                        <img src="<?php echo $site_logo ?>" alt="&#25163;&#21161;&#12369;&#65311;"></img>
                </span>
                <div id="bottom">
                </div>
                <div id="android" style="color: white; font-size: 20%;">
                        <h1>Play</h1>
                </div>
                <div id="window" style="text-align: center;">
                        <h1 style="font-family: 'Indie Flower'; font-size: 75px;">Hosting <span id='memeno'></span> webms</h1><br>
                        Select a webm: <select id="webmselect"><option value="new">Random</option></select>
                </div>
        </body>
</html>
