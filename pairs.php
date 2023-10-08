<?php
    // highScore cookie is js so if user cookie expires and browser isn't closed it will remember user

    if (!isset($_COOKIE['username']) && isset($_COOKIE['highScore'])) {
        setcookie("highScore", "", time() - 3600);
        $_COOKIE['highScore'] = NULL;
    }          
?>

<html>
    <head>
		<link rel="stylesheet" type="text/css" href="style.css">

        <style>
            .game-area {
                width: 70%;
                margin: 30px auto;                
                background-color: rgba(128, 128, 128,.5); 
                border-radius: 30px;
                box-shadow: 5px 5px 4px;
            }
            .winning {
                background-color: rgba(255, 215, 0,.7); /*Gold*/
            }

            .overview {
                background-color: rgba(199, 199, 199, .5);
                color: white;
                border-radius: 30px 30px 0px 0px;
                padding: 15px 0px;
                font-size: 1.6em;
                font-weight: bold;
            }
            ul.player-info { 
                list-style-type: none; 
                padding: 0px;
				overflow: hidden;
                margin: 0;
            }
            ul.player-info li {     
                float:left;                
                display: block;
				width: 6.5cm;	
				text-decoration: none;
				text-align: center;
            }



            /*Start and end buttons*/
            .standard-btn{               
                margin-left: auto;
                margin-right: auto;
                display: inline-block;
                font-size: 15px;
                font-weight: bold;
                background: none;
                border: 3px solid;
                border-radius: 99px;      
                margin-top: 200px;     
                padding: 10px 30px;   
                color: black;
                background-color: rgba(49, 204, 2, .5);
                transition: 0.4s;
            }
            .standard-btn:hover {
                box-shadow: 5px 5px 4px;
                background-color: rgba(62, 255, 3, .8);
            }
            .start-game{
                width: 20%;
                margin:auto;
                font-weight: bold;
            }



			/*all things card related*/
            .card-area {
                min-height: 500;
            }
			
			
			/*grid of cards*/
			.cards {
				display: grid;
				justify-content: center;
				grid-gap: 20px;
				grid-template-columns: repeat(auto-fill, minmax(132px, 1fr));
				padding: 20px;
                clear: both;
			}

			/*contains grid and cards*/
            .active-game{
                padding: 30px;
            }
			

            .gameCard {
                width: 132px;
                height: 204px;
                border-radius: 24px;
                position: relative;
                background: transparent;
				transform-style: preserve-3d;
				transition: .8s ease-in-out;
            }
			.gameCard:hover {
                transform: translateY(-20px);
				box-shadow: 5px 10px 8px;
            }
			.gameCard.flipped {
				transform: rotateY(180deg);
			}
			.gameCard.flipped:hover {
				box-shadow: none;
			}
			
			/*the decorative image for front and back of card*/
			.front, .back {
				position: absolute;
				height: 100%;
				width: 100%;
				backface-visibility: hidden;
				border-radius: 24px;
			}
			.front {
				background-image: url("front-of-card.png");
				background-position: center center;
				background-size: cover;
				transform: rotateY(180deg);
				position: absolute;
				border-color: rgba(241, 173, 75, .8);
				border-style: outset;
				border-width: 5px;
			}
			.back {
				background-image: url("back-of-card.png");
				background-position: center center;
				background-size: cover;
				backface-visibility: hidden;
				position: absolute;
			}
			/*face elements*/
			.front-image {
                position: absolute;
				height: 68px;
				width:68px;
				background-position: center center;		
				margin: 63.2px 27.2px;
			}


            /*time and guesses */
            .game-stats {
                color: rgb(234, 196, 255);
                font-weight: bold;
                font-size: 1.2em;
                float: left;
                padding: 20px;
            }
            .game-stats-container {
                float: left;
                
            }



            /* end screen */
            .game-over {
                margin:auto;
            }

            .end-text {
                display: none;
                text-align: center;
                color: rgb(255, 17, 0);
                font-weight: bold;
                font-size: 1.3em;
                
            }
            .end-choice {
                display: none;
                margin: auto;
                height: 113.3;
                width: 420;
            }
            .decision {
                margin: 20px 40px 30px;
            }
            .left-btn {
                
            }
            .right-btn {
                
            }
            .submit {
                background-color: rgba(2, 177, 204, .5);
            }
            .submit:hover {
                background-color: rgba(0, 221, 255, .8);
            }
            
			.round-complete-msg {
                display: none;
                text-align: center;
                color: rgb(62, 255, 3);
                font-weight: bold;
                font-size: 1.6em;
            }
			
        </style>
	</head>
    <body>
        <div id = "main">
            <?php
                $title = 'Mini Game Page';
                $page = 'pairs';
                include_once ('navbar.php');
            ?>
            
            <div class="game-area" id="game-area">
                <div class = "overview">
                    <ul class="player-info">
                        <li class="Global" id="high-score-display">High Score = ----</li> 
                        <li style="float:right" class="Current-game" id="round-num-display">Round No. = ----</li>
                        <li style="float:right" class="Current-game" id="current-score-display">Your Score = ----</li>                                              
                    </ul>
                </div>

                <div class="card-area">
                    <div class="start-game">
                        <button type='button' class="standard-btn" id="start-btn">Start the game</button>
                    </div>
                    <p class="round-complete-msg" id = "round-complete-msg">ROUND COMPLETE</p>
                    <p class="round-complete-msg" id = "round-complete-msg-countdown">Next Round in: </p>
                    <div class="game-over" id="game-over">
                        <div class="end-text" id="end-text">
                            <p class = "over message" id="game-done">GAME OVER</p>
                            <p class = "message" id="message"></p>
                        </div>
                        <div class="end-choice" id="end-choice">
                            <button type='button' class="standard-btn left-btn decision" id="PlayAgain-btn" onclick="restartG()">Play Again</button>

                            <?php if (isset($_COOKIE["username"])) { 
                                echo "<button type='button' class='submit right-btn standard-btn decision' id='Submit-btn' onclick='submitG()'>Submit</button>";
                            }?>
                        </div>
                        
                    </div>
                    <div class="active-game" id="active-game">
                        <div class="game-stats-container">
                            <p class="timer game-stats" id="timer-display"></p>
                            <p class="guess game-stats" id="guessesLeft-display"></p>
                        </div>
                        <div class="cards" id="cards">

                        </div>                        
                    </div>

                    
                </div>
            </div>
            <div id="hidden_form" style="display:none;"></div>
        </div>

        <script>
            var score = 0;
            var scorePerRound = [];
            var scoreAtStartOfRound;
            var round = 0;
            var cards_to_pair, pair_amount;
            var guessesLeft, guessesAllocated;
            var timeRemaining, timeAllocated;
            var countDownInterval;
            var disableCards, round_game_over;
            var timeComplete = false;
            const skin = ["red.png", "yellow.png", "green.png"];
            const eyes = ["closed.png", "laughing.png", "long.png", "normal.png", "rolling.png", "winking.png"];
            const mouth = ["open.png", "sad.png", "smiling.png", "straight.png", "surprise.png", "teeth.png"];

            //hide game at start
            document.getElementById("active-game").style.display = "none";

            //buttons to interact with
            const begin_game = document.getElementById("start-btn");
            begin_game.addEventListener("click", begin);


            document.getElementById("game-area").classList.remove("winning");


            function restartG() {
                console.log("Restarting");
                score = 0;
                scorePerRound = [];
                round = 0;
                document.getElementById("active-game").style.opacity = "1";
                begin();
            }
            function submitG() {
                console.log("Score = " + score);
                var theForm, scoreInput, roundsInput;

                theForm = document.createElement('form');
                theForm.action = "leaderboard.php";
                theForm.method = "post";

                scoreInput = document.createElement('input');
                scoreInput.type = "hidden";
                scoreInput.name = "totalScore";
                scoreInput.value = score;
                
                roundsInput = document.createElement('input');
                roundsInput.type = "hidden";
                roundsInput.name = "rounds";
                roundsInput.value = scorePerRound;

                theForm.appendChild(scoreInput);
                theForm.appendChild(roundsInput);

                document.getElementById('hidden_form').appendChild(theForm);

                theForm.submit();
            }

            function begin() {
                <?php 
                if (isset($_COOKIE['highScore'])) { 
                    echo 'var previousHighScore = ' . $_COOKIE['highScore']. ';';?>
                    document.getElementById("high-score-display").innerHTML = "High Score = " + previousHighScore;
                <?php } else { ?>
                    document.getElementById("high-score-display").innerHTML = "High Score = ----";
                <?php }
                ?>

                document.getElementById("game-area").classList.remove("winning");

                pair_amount = 3;
                cards_to_pair = 2;


                document.getElementById("current-score-display").innerHTML = "Your Score = " + score;
                document.getElementById("round-num-display").innerHTML = "Round No. = " + round;

                document.getElementById("end-text").style.display = "none";
                document.getElementById("end-choice").style.display = "none";

                //remove button
                document.getElementById("start-btn").style.display = "none";
                //show game
                document.getElementById("active-game").style.display = "block";

                setup_round();
            }
            var newDifficultyInterval, newDifficultyCountdown;
            function setup_round() {
                document.getElementById("round-complete-msg").style.display = "none";
                document.getElementById("round-complete-msg-countdown").style.display = "none";

                //remove cards from previous rounds
                const list = document.getElementById("cards");

                while (list.hasChildNodes()) {
                    list.removeChild(list.firstChild);
                }
              
                
                var card_list = [];
                

                round +=1;
                document.getElementById("round-num-display").innerHTML = "Round No. = " + round;
                scoreAtStartOfRound = score;


                //working out card amount, pairing type, time allowed and guesses allowed

                if (round == 1) {
                    timeRemaining = 30;
                    timeAllocated = 30;
                    guessesLeft = 7;
                    guessesAllocated = 7;

                    pair_amount = 3;
                    cards_to_pair = 2;

                    //no changes - just continuing as far as you can go
                } else if (round > 35) {
                    timeRemaining = 96;
                    timeAllocated = 96;
                    guessesLeft = 9;
                    guessesAllocated = 9;

                    pair_amount = 6;
                    cards_to_pair = 4;


                    //card/pairamount changes
                } else if ((round % 3) == 0) {
                    scoreIncrease(5)
                    if (round == 12) {
                        pair_amount = 3;
                        cards_to_pair = 3;
                    } else if (round == 24) {
                        pair_amount = 3;
                        cards_to_pair = 4;
                    } else {
                        pair_amount += 1;
                    }

                    var cardTotal = pair_amount*cards_to_pair;
                    timeRemaining = cardTotal * 7;
                    timeAllocated = timeRemaining;

                    guessesLeft = pair_amount + 7;
                    guessesAllocated = guessesLeft;
                    
                    
                } else {
                    //COINTINUING with same card amount but time&guesses decrease
                    var cardTotal = pair_amount*cards_to_pair;
                    timeRemaining = timeAllocated - cardTotal;
                    timeAllocated = timeRemaining;

                    guessesLeft = guessesAllocated - 1;
                    guessesAllocated = guessesLeft;
                }
                
                if (round == 1) {
                    document.getElementById("guessesLeft-display").style.display = "none";
                    document.getElementById("timer-display").style.display = "none";
                    document.getElementById("round-complete-msg").innerHTML = "Card amount = <span style='color: white'>" + (pair_amount*cards_to_pair) + "</span><br>Cards to match = <span style='color: white'>" + cards_to_pair+ "</span>";
                    document.getElementById("round-complete-msg").style.display = "block";
                    
                    newDifficultyCountdown = 5;
                    document.getElementById("round-complete-msg-countdown").innerHTML = "Starting in : " + newDifficultyCountdown;
                    document.getElementById("round-complete-msg-countdown").style.display = "block";
                    newDifficultyInterval = setInterval(newDifficulty, 1000);
                    setTimeout(delay, 5000);
                }else if ((round % 3) == 0) {
                    document.getElementById("guessesLeft-display").style.display = "none";
                    document.getElementById("timer-display").style.display = "none";
                    document.getElementById("round-complete-msg").innerHTML = "NEW DIFFICULTY <span style='color: white'>+5</span><br>Card amount = <span style='color: white'>" + (pair_amount*cards_to_pair) + "</span><br>Cards to match = <span style='color: white'>" + cards_to_pair+ "</span>";
                    document.getElementById("round-complete-msg").style.display = "block";
                    
                    newDifficultyCountdown = 5;
                    document.getElementById("round-complete-msg-countdown").innerHTML = "Starting in : " + newDifficultyCountdown;
                    document.getElementById("round-complete-msg-countdown").style.display = "block";
                    newDifficultyInterval = setInterval(newDifficulty, 1000);
                    setTimeout(delay, 5000);
                } else {
                    card_list = generate_pairs(pair_amount);
                    card_list = shuffle_Cards(card_list);
                    display(card_list);        

                    firstCard = "";
                    secondCard = "";
                    thirdCard = "";
                    fourthCard = "";
                    
                    disableCards = false;
                    round_game_over = false;
                    timeComplete = false;

                    document.getElementById("guessesLeft-display").innerHTML = "Guesses Left = <span style='color: white'>" + guessesLeft + "</span>";
                    document.getElementById("timer-display").innerHTML = timeDisplay();
                    countDownInterval = setInterval(Countdown, 1000);
                }     
                
                console.log(timeRemaining);
                console.log(guessesLeft);
                
            }


            function delay() {
                document.getElementById("round-complete-msg-countdown").style.display = "none";
                document.getElementById("round-complete-msg").style.display = "none";
                document.getElementById("guessesLeft-display").style.display = "block";
                document.getElementById("timer-display").style.display = "block";

                card_list = generate_pairs(pair_amount);
                card_list = shuffle_Cards(card_list);
                display(card_list);        

                firstCard = "";
                secondCard = "";
                thirdCard = "";
                fourthCard = "";
                
                disableCards = false;
                round_game_over = false;
                timeComplete = false;

                document.getElementById("guessesLeft-display").innerHTML = "Guesses Left = <span style='color: white'>" + guessesLeft + "</span>";
                document.getElementById("timer-display").innerHTML = timeDisplay();
                countDownInterval = setInterval(Countdown, 1000);
            }

            function newDifficulty() {
                newDifficultyCountdown -= 1;
                document.getElementById("round-complete-msg-countdown").innerHTML = "Starting in : " + newDifficultyCountdown;
                if (newDifficultyCountdown == 0) {
                    clearInterval(newDifficultyInterval);
                    
                }
            }

            
            function Countdown() {
                timeRemaining -= 1;
                document.getElementById("timer-display").innerHTML = timeDisplay();
                if (timeRemaining == 0 && round_game_over == false) {
                    clearInterval(countDownInterval);
                    timeComplete = true;
                    game_over("OUT OF TIME");

                }
            }
            function timeDisplay() {
                var output = "Time Left = <span style='color: white'>";
                if ((Math.floor(timeRemaining/60)) < 10) {
                    output += "0" + Math.floor(timeRemaining/60) + ":";
                } else {
                    output +=  Math.floor(timeRemaining/60) + ":";
                }
                if ((timeRemaining % 60) < 10) {
                    output += "0" + timeRemaining % 60;
                } else {
                    output += timeRemaining % 60;
                }
                output += "</span>";
                return output;
            }
			
			function shuffle_Cards(card_list) {
				//loop and swap cards over
				var randomPosition1, randomPosition2, temp;
				
                console.log("shuffle");
                for (let card of card_list) {
                    console.log(card);
                }

				for(i=0; i < 100; i++) {
					randomPosition1 = Math.floor(Math.random() * card_list.length);
					randomPosition2 = Math.floor(Math.random() * card_list.length);
					
					temp = card_list[randomPosition1];
					card_list[randomPosition1] = card_list[randomPosition2];
					card_list[randomPosition2] = temp;
				}

                console.log("after shuffle");
                for (let card of card_list) {
                    console.log(card);
                }
				
				return card_list;
			}
			
			var firstCard = "";
            var secondCard = "";
            var thirdCard = "";
            var fourthCard = "";

            function display(card_list) {
				console.log("display")
				for (let card of card_list) {
					const cardElement = document.createElement("div");
					cardElement.classList.add("gameCard");
					cardElement.setAttribute("data-name", card.name);
					cardElement.innerHTML = '<div class = "front"><img class="front-image" src="emoji_assets/skin/' + skin[card.skin_index] + '"><img class="front-image" src="emoji_assets/eyes/' + eyes[card.eye_index] +'"><img class="front-image" src="emoji_assets/mouth/' + mouth[card.mouth_index] + '"></div><div class = "back"></div>';
					console.log(skin[card.skin_index]);
                    console.log(eyes[card.eye_index]);
                    console.log(mouth[card.mouth_index]);
					cardElement.addEventListener("click", flip_Card);
					
					document.getElementById("cards").appendChild(cardElement);
				}
            }
            
			function flip_Card() {
                //no card interaction allowed
                if (disableCards || round_game_over) {
                    return;
                }
				
                //is the card the card already flipped
				if (this.dataset.name == firstCard) {                    
                    return; 
                }
				
				this.classList.add("flipped"); //not flipped so flip it over
				
				//is this the only card flipped
				if (firstCard == "") {
					firstCard = this.dataset.name;
					return;
                    //check if secondCard
				} else if (secondCard == "") {
                    //this is the second card to be flipped 
                    secondCard = this.dataset.name;

                    if (cards_to_pair == 2) {
                        disableCards = true;
                        //allow for animation
                        setTimeout(isItAMatch, 1000);
                    }
                    
                } else if (thirdCard == "") {
                    //this is the thrid card to be flipped 
                    thirdCard = this.dataset.name;

                    if (cards_to_pair == 3) {
                        disableCards = true;
                        //allow for animation
                        setTimeout(isItAMatch, 1000);
                    }
                } else {
                    //this is the thrid card to be flipped 
                    fourthCard = this.dataset.name;

                    disableCards = true;
                    //allow for animation
                    setTimeout(isItAMatch, 1000);
                }
            }
			
			
			function isItAMatch() {
                //name = skin+eyes+mouth+id
                var match;
                if (cards_to_pair == 3) {
                    match = ((firstCard.substr(0, 3) == secondCard.substr(0, 3)) && (firstCard.substr(0, 3) == thirdCard.substr(0, 3)));
                } else if (cards_to_pair == 4) {
                    match = ((firstCard.substr(0, 3) == secondCard.substr(0, 3)) && (firstCard.substr(0, 3) == thirdCard.substr(0, 3)) && (firstCard.substr(0, 3) == fourthCard.substr(0, 3)));
                } else {
                    match = (firstCard.substr(0, 3) == secondCard.substr(0, 3));
                    console.log("match = " + match);
                }
				
				

				//match
				if (match == true) {
                    console.log("match");
					//can't be clicked
                    var card1 = document.querySelector("[data-name = '" +firstCard+ "']");
                    card1.removeEventListener("click", flip_Card);

                    var card2 = document.querySelector("[data-name = '" +secondCard+ "']");
                    card2.removeEventListener("click", flip_Card);
                    
                    var card3, card4;
                    if (cards_to_pair > 2) {
                        card3 = document.querySelector("[data-name = '" +thirdCard+ "']");
                        card3.removeEventListener("click", flip_Card);
                    }
                    if (cards_to_pair == 4) {
                        card4 = document.querySelector("[data-name = '" +fourthCard+ "']");
                        card4.removeEventListener("click", flip_Card);
                    }

                    scoreIncrease(1);

                    if (timeComplete == false) {
                        var child = card1.children;
                        child[0].style.borderColor = "rgba(242, 242, 242, .8)";

                        var child = card2.children;
                        child[0].style.borderColor = "rgba(242, 242, 242, .8)";

                        if (cards_to_pair > 2) {
                            var child = card3.children;
                            child[0].style.borderColor = "rgba(242, 242, 242, .8)";
                        }
                        if (cards_to_pair == 4) {
                            var child = card4.children;
                            child[0].style.borderColor = "rgba(242, 242, 242, .8)";
                        }
                    }
                    

                    isRoundComplete();

				} else {
					//turn cards over
                    var card1 = document.querySelector("[data-name = '" +firstCard+ "']");
                    card1.classList.remove("flipped");

                    var card2 = document.querySelector("[data-name = '" +secondCard+ "']");
                    card2.classList.remove("flipped");

                    if (cards_to_pair > 2) {
                        var card3 = document.querySelector("[data-name = '" +thirdCard+ "']");
                        card3.classList.remove("flipped");
                    }
                    if (cards_to_pair == 4) {
                        var card4 = document.querySelector("[data-name = '" +fourthCard+ "']");
                        card4.classList.remove("flipped");
                    }

                    console.log("not a match");

				}

                //if round is continuing then decrease guess counter and check if 0
                if (round_game_over == false) {
                    guessesLeft -= 1;
                    document.getElementById("guessesLeft-display").innerHTML = "Guesses Left = <span style='color: white'>" + guessesLeft + "</span>";
                    firstCard = "";
                    secondCard = "";
                    thirdCard = "";
                    fourthCard = "";
                    if (guessesLeft == 0) {
                        game_over("OUT OF GUESSES");
                        
                    }
                    
                    disableCards = false;
                }
                
			}

            var NextRoundInterval;
            var time;
            function isRoundComplete() {
                var cardHolder = document.getElementById("cards");

                var allTheCards = cardHolder.children;

                var complete = true;
                for (let card of allTheCards) {
                    there = card.classList.contains("flipped");

                    if (there == false) {
                        complete = false;
                    }
                }

                if (complete == true && timeComplete == false) {
                    console.log("I'm done");  

                    //one decimal place - each 10% = 1 point
                    var timeDifference = (timeRemaining/timeAllocated).toFixed(1);
                    var extraTimePoints = timeDifference * 10;
                    var extraGussesPoints = guessesLeft;

                    //ROUND COMPLETE message with extra points
                    scoreIncrease((extraTimePoints + extraGussesPoints));
                    document.getElementById("round-complete-msg").innerHTML = "ROUND COMPLETE<br>Time bonus points = <span style='color: white'>" + extraTimePoints + "</span><br>Guesses bonus points = <span style='color: white'>" + extraGussesPoints + "</span>";

                    scorePerRound.push(score-scoreAtStartOfRound);
                    
                    console.log(scorePerRound);
                      
                    clearInterval(countDownInterval);
                    round_game_over = true;
                    document.getElementById("round-complete-msg").style.display = "block";
                    document.getElementById("round-complete-msg-countdown").style.display = "block";
                    time = 10;
                    document.getElementById("round-complete-msg-countdown").innerHTML = "Next Round in: " + time;
                    NextRoundInterval = setInterval(NextRound, 1000);
                 
                    
                } else {
                    console.log("NOT done");
                }

            }

            function NextRound() {
                time -= 1;
                document.getElementById("round-complete-msg-countdown").innerHTML = "Next Round in: " + time;
                if (time == 0) {
                    clearInterval(NextRoundInterval);
                    setup_round();
                }
            }

            function game_over(message) {
                //make it so that cards not flipped cant be hovered
                var cardHolder = document.getElementById("cards");
                var allTheCards = cardHolder.children;
                for (let card of allTheCards) {
                    there = card.classList.contains("flipped");

                    if (there == false) {
                        card.style.transform = "translateY(0px)";
                        card.style.boxShadow = "none";
                    }
                }

                round_game_over = true;                
                clearInterval(countDownInterval);
                document.getElementById("active-game").style.opacity = "0.6";
                //game over elements
                document.getElementById("end-text").style.display = "block";

                document.getElementById("end-choice").style.display = "block";
                
                document.getElementById("message").innerHTML = message;

                scorePerRound.push(score-scoreAtStartOfRound);
                    
                console.log(scorePerRound);

                <?php 
                    if (isset($_COOKIE['highScore'])) {
                    echo 'var previousHighScore = ' . $_COOKIE['highScore']. ';';
                } ?>
                <?php 
                    if (isset($_COOKIE['username']) && !isset($_COOKIE['highScore'])) { ?>
                    document.cookie = "highScore = " + score;
                <?php } else if (isset($_COOKIE['username']) && isset($_COOKIE['highScore'])) {?>
                    if (previousHighScore < score) {
                        document.cookie = "highScore = " + score;
                    }                    
                <?php } ?>
            }

			
            function generate_pairs(amount) {
                var new_skin_index;
                var new_eye_index;
                var new_mouth_index;
                var pair_list = [];

                for (i=0; i < amount; i++) {
                    var used = true;
                    while (used == true) {
                        new_skin_index = Math.floor(Math.random() * 3);
                        new_eye_index = Math.floor(Math.random() * 6);
                        new_mouth_index = Math.floor(Math.random() * 6);
                        
                        used = false;
                        //does the list have an face already
                        if (pair_list.length != 0) {
                            //check if the faces already created match the generated one
                            for (i=0; i < pair_list.length; i++) {
                                if (pair_list[i].skin_index == new_skin_index) {
                                    if (pair_list[i].eye_index == new_eye_index) {
                                        if (pair_list[i].mouth_index == new_mouth_index) {
                                            used = true;
                                        } 
                                    } 
                                } 
                            }
                        }

                    }

                    pair_list.push({skin_index: new_skin_index, eye_index: new_eye_index, mouth_index: new_mouth_index, name: new_skin_index.toString() + new_eye_index.toString() + new_mouth_index.toString()});
                    console.log("card number = " + i);
                    console.log(pair_list[i].skin_index);
                    console.log(pair_list[i].eye_index);
                    console.log(pair_list[i].mouth_index);
					console.log(pair_list[i].name);
                }
				
				//duplicate each card
                console.log("duplicate");
				var card_list = [];
                var newName;
                var changeName;
				for (i=0; i < pair_list.length; i++) {
                    newName = pair_list[i].name;
                    
                    //duplicate 1
                    changeName = pair_list[i];
                    changeName.name = newName + "1";
					card_list.push(changeName);
                    
                    for (counter=2; counter <= cards_to_pair; counter++) {
                        var tempObj = Object.assign({}, changeName);
                        tempObj.name = newName + counter;
                        card_list.push(tempObj);
                    }
                                        
				}
                
                for (let card of card_list) {
                    console.log(card);
                }

				
                return card_list;
            }

            function scoreIncrease(amount) {
                score += amount;
                document.getElementById("current-score-display").innerHTML = "Your Score = " + score;
                newHighScore();
            }

            function newHighScore() {

                <?php 
                    if (isset($_COOKIE['highScore'])) {
                    echo 'var previousHighScore = ' . $_COOKIE['highScore'] . ';';
                    echo 'var previousHighScoreExists = true;';
                } else {
                    echo 'var previousHighScore = 10000000;';
                    echo 'var previousHighScoreExists = false;';
                }    
                ?>
                if (previousHighScoreExists == true && previousHighScore < score) {
                    document.getElementById("game-area").classList.add("winning");
                }
            }
        </script>
    </body>
</html>