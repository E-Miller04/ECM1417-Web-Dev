<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['Username']) && !empty($_POST['Username'])) {
            func();
            //see if post request and if username has value
        } 
    }

    
    function func() {
        //cookies           
           
        $cookie_value = $_POST['Username'];
        setcookie("username", $cookie_value, time() + 60*60*2);
        $_COOKIE['username'] = $_POST['Username'];
    }
?>

<html>
    <head>
		<link rel="stylesheet" type="text/css" href="style.css">
        <style>
            form{
                width: 60%;
                margin: auto;                
                padding: 30px;
                
            }
            fieldset {        
                background-color: rgba(238, 238, 238,.5); 
                border-radius: 30px;
            }
            legend {
                background-color: rgba(161, 161, 161, .5);
                color: white;
                text-indent: 30px;
                border-radius: 30px 30px 0px 0px;
            }

            /*username input */
            .input-group {
                padding: 30px;
                margin-top: 1cm;
            }
            .valid {                
                color: #212529 !important;
            }
            .invalid {
                color: rgb(255, 21, 0) !important;
            }
            #message{
                color: rgb(158, 14, 2);
                font-weight: bold;
                padding-left: 30px !important;
            }

            /*submitting name and profile pic */
            .submit-btn{
                margin: 10px 30px;
                display: inline-block;
                padding: 10px 30px;
                color: black;
                font-size: 15px;
                font-weight: bold;
                background: none;
                border: 3px solid;
                border-radius: 99px;
                transition: 0.4s;
              
            }
            .submit-btn:hover {
                box-shadow: 5px 5px 4px;
                background-color: rgba(62, 255, 3, .5);
            }
            .submitting {
                clear: left;
                width: 100%;
                padding-top: 20px;
            }

            /*avatar selection */
            .profile-selector {
                width: 100%;
            }
            .selection {
                width: 50%;
                float: left;
            }
            .display {
                width: 50%;
                float: right;
                height: auto;
            }       
            .image-area {
                width: 170;
                height: 170;
                background-color: rgba(201, 201, 201, .5);
                margin: 10px auto;
                position: relative;
            }    
            .image-choice {
                width: 90%;
                height: 90%;
                display: block;
                margin: 8.5;
                position: absolute;
            }
            .selection-btn {                
                margin: 10px 30px;
                display: inline-block;
                font-weight: bold;
                text-decoration: none;
                display: inline-block;
                padding: 8px 16px;
                color: black;
                background-color: rgba(201, 201, 201, .5);
                transition: 0.4s;
                border: 2.5px solid;
                border-color: rgb(66, 66, 66);
            }
            .selection-btn:hover {
                color: black;
                background-color: rgba(255, 21, 0, .5);
                border-color: black;
            }
            .right{
                /*float: right;*/
            }
            .round {
                border-radius: 50%;
            }
            .profile-selector label {
                width: 120px;
                display: inline-block;
                text-align: center;
                color: black;
                font-weight: bold;
            }



            .submitted {
                margin-top: 30px;
                color: white;
                text-align: center;
                font-size: 2em;
            }
            .submittedName{
                color: rgb(62, 255, 3);
                text-align: center;
                font-size: 2em;
            }

            .disclaimer{
                margin: 10px 30px;
                color: white;
                font-size: 0.6em;
            }
        </style>
	</head>
    <body>
        <div id = "main">
            <?php
                $title = 'Registration Page';
                $page = 'registration';
                include_once ('navbar.php');
            ?>
            <?php if (isset($_COOKIE["username"])) { ?>
                <p class="submitted">You are already registered</p>
                <p class="submittedName"><?php echo $_COOKIE["username"] ?></p>
            <?php } else { ?>
                <form name="register-form" id="register-form" action="registration.php" method="post">
                    <fieldset>
                        <legend>Please fill in:</legend>
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">@</span>
                            <input type="text" name = "Username" id="Username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">                        
                        </div>
                        <p id="message"></p>
                        <br>

                        <div class="profile-selector">
                            <div class="selection">
                                <div class="skin">
                                    <button type='button' class="selection-btn round" id="skin-previous">&#8249;</button>
                                    <label id="skin-colour"></label>
                                    <button type='button' class="selection-btn round right" id="skin-next">&#8250;</button>
                                </div>
                                <div class="eyes">
                                    <button type='button' class="selection-btn round" id="eyes-previous">&#8249;</button>
                                    <label id="eye-colour"></label>
                                    <button type='button' class="selection-btn round right" id="eyes-next">&#8250;</button>
                                </div>
                                <div class="mouth">
                                    <button type='button' class="selection-btn round" id="mouth-previous">&#8249;</button>
                                    <label id="mouth-shape"></label>
                                    <button type='button' class="selection-btn round right" id="mouth-next">&#8250;</button>
                                </div>
                            </div>
                            <div class="display">
                                <div class="image-area">
                                    <img id="skin-img" class="image-choice" src="" alt="Skin">
                                    <img id="eyes-img" class="image-choice" src="" alt="Eyes">
                                    <img id="mouth-img" class="image-choice" src="" alt="Mouth">
                                </div>
                            </div>
                        </div>

                        <div class="submitting">
                            <input type="submit" value="Submit" class="submit-btn" id="submit-btn">
                        </div>
                        <p class="disclaimer">This site uses cookies to track who is registered. By submitting you are agreeing to us using cookies to track who you are.</p>
                    </fieldset>
                </form>
            <?php }
            ?>
        </div>

        <script>
            //username selection
            const form = document.querySelector('#register-form');
            const invalidChars = /["!@#%&*()+=^{}\[\]—;:“'<>?/]/;
            let username = form.elements.namedItem("Username");

            username.addEventListener('input', validate);

            function validate (e) {
                let target = e.target;

                if (target.name == "Username") {
                    if (!(invalidChars.test(target.value))) {
                        console.log("it's valid");
                        target.classList.add('valid');
                        target.classList.remove('invalid');
                        document.getElementById("message").innerHTML = "";
                        document.getElementById("submit-btn").disabled = false;
                    } else {
                        console.log("it's not valid")
                        target.classList.add('invalid');
                        target.classList.remove('valid');
                        document.getElementById("message").innerHTML = "Invalid Character Used:<br>( \"!@#%&*()+=^{}[]—;:“'<>?/ )";
                        document.getElementById("submit-btn").disabled = true;
                    }
                } 
            }

            //Avatar selection
            const skin = ["red.png", "yellow.png", "green.png"];
            var skin_index = 0;            
            const eyes = ["closed.png", "laughing.png", "long.png", "normal.png", "rolling.png", "winking.png"];
            var eye_index = 0;
            const mouth = ["open.png", "sad.png", "smiling.png", "straight.png", "surprise.png", "teeth.png"];
            var mouth_index = 0;
            
            //setting default values of images - index at 0
            document.getElementById("skin-colour").innerHTML = "Skin: " + skin[skin_index].substr(0, (skin[skin_index]).length - 4);
            document.getElementById("skin-img").src = "emoji_assets/skin/" + skin[skin_index];
            document.cookie = "javascriptSkin = " + skin[skin_index];
            document.getElementById("eye-colour").innerHTML = "Eyes: " + eyes[eye_index].substr(0, (eyes[eye_index]).length - 4);
            document.getElementById("eyes-img").src = "emoji_assets/eyes/" + eyes[eye_index];
            document.cookie = "javascriptEyes = " + eyes[eye_index];
            document.getElementById("mouth-shape").innerHTML = "Mouth: " + mouth[mouth_index].substr(0, (mouth[mouth_index]).length - 4);
            document.getElementById("mouth-img").src = "emoji_assets/mouth/" + mouth[mouth_index];
            document.cookie = "javascriptMouth = " + mouth[mouth_index];

            const s_next = document.getElementById("skin-next");
            s_next.addEventListener("click", sn);
            const s_previous = document.getElementById("skin-previous");
            s_previous.addEventListener("click", sp);

            const e_next = document.getElementById("eyes-next");
            e_next.addEventListener("click", en);
            const e_previous = document.getElementById("eyes-previous");
            e_previous.addEventListener("click", ep);

            const m_next = document.getElementById("mouth-next");
            m_next.addEventListener("click", mn);
            const m_previous = document.getElementById("mouth-previous");
            m_previous.addEventListener("click", mp);

            function sn() {
                skin_index = position(skin_index, 1, skin.length)
                document.getElementById("skin-colour").innerHTML = "Skin: " + skin[skin_index].substr(0, (skin[skin_index]).length - 4);
                document.getElementById("skin-img").src = "emoji_assets/skin/" + skin[skin_index];
                document.cookie = "javascriptSkin = " + skin[skin_index];
            }
            function sp() {
                skin_index = position(skin_index, -1, skin.length)
                document.getElementById("skin-colour").innerHTML = "Skin: " + skin[skin_index].substr(0, (skin[skin_index]).length - 4);
                document.getElementById("skin-img").src = "emoji_assets/skin/" + skin[skin_index];
                document.cookie = "javascriptSkin = " + skin[skin_index];
            }
            function en() {
                eye_index = position(eye_index, 1, eyes.length)
                document.getElementById("eye-colour").innerHTML = "Eyes: " + eyes[eye_index].substr(0, (eyes[eye_index]).length - 4);
                document.getElementById("eyes-img").src = "emoji_assets/eyes/" + eyes[eye_index];
                document.cookie = "javascriptEyes = " + eyes[eye_index];
            }
            function ep() {
                eye_index = position(eye_index, -1, eyes.length)
                document.getElementById("eye-colour").innerHTML = "Eyes: " + eyes[eye_index].substr(0, (eyes[eye_index]).length - 4);
                document.getElementById("eyes-img").src = "emoji_assets/eyes/" + eyes[eye_index];
                document.cookie = "javascriptEyes = " + eyes[eye_index];
            }
            function mn() {
                mouth_index = position(mouth_index, 1, mouth.length)
                document.getElementById("mouth-shape").innerHTML = "Mouth: " + mouth[mouth_index].substr(0, (mouth[mouth_index]).length - 4);
                document.getElementById("mouth-img").src = "emoji_assets/mouth/" + mouth[mouth_index];
                document.cookie = "javascriptMouth = " + mouth[mouth_index];
            }
            function mp() {
                mouth_index = position(mouth_index, -1, mouth.length)
                document.getElementById("mouth-shape").innerHTML = "Mouth: " + mouth[mouth_index].substr(0, (mouth[mouth_index]).length - 4);
                document.getElementById("mouth-img").src = "emoji_assets/mouth/" + mouth[mouth_index];
                document.cookie = "javascriptMouth = " + mouth[mouth_index];
            }

            function position(current, change, list_length) {
                if ((current + change) > (list_length - 1)) {
                    return 0;
                } else if ((current + change) < 0) {
                    return list_length -1;
                } else {
                    return current + change;
                }
            }

        </script>
    </body>
</html>
