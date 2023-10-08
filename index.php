<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">

        <style>
            a.nextPage {
                animation: glowing 1s ease-in-out infinite alternate;
            }
            a.nextPage:hover {
                text-decoration: underline;
                color: white;
                cursor: pointer;
                background-color: transparent;
                animation-play-state: paused;
            }
            .register {
                width: 40%;
                margin: auto; 
                margin-top: 200px;               
                padding: 30px;
                background-color: rgba(0,0,0,.7); 
                border-radius: 50%;
                
            }
            .play{               
                margin-left: auto;
                margin-right: auto;
                display: inline-block;
                font-size: 15px;
                font-weight: bold;
                background: none;
                border: 3px solid;
                border-radius: 99px;      
                margin-top: 100px;     
                padding: 10px 30px;   
                color: black;
                background-color: rgba(49, 204, 2, .8);
                transition: 0.4s;
            }
            .play:hover {
                box-shadow: 5px 5px 4px;
                background-color: rgba(62, 255, 3, .9);
            }
        </style>
	</head>
	<body>
		
        <div id = "main">
            <?php
                $title = 'Home Page';
                $page = 'index';
                include_once('navbar.php');
            ?>        
            
            
            <div class = "area-around-decision">
                <div class = "registerOrPlay">
                    <?php if (isset($_COOKIE["username"])) { ?>
                        <div class="WelcomeMessage">
                            <p>Welcome to Pairs</p>
                        </div>
                        <button class="play" onclick="location.href='pairs.php'" type="button">Click here to play</button>
                    <?php } else { ?>
                        <div class = "register">
                            <p >You're not using a registered session?<br>
                            <a class="nextPage" href="registration.php">Register now</a>
                            </p>
                        </div>
                    <?php }
                    ?>
                    
                </div>
            </div>
        </div>
	</body>
	
</html>