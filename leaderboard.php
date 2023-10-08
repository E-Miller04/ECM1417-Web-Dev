<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['totalScore']) && !empty($_POST['rounds']) && isset($_COOKIE['username']) && !empty($_COOKIE['username'])) {
            uploadResultsTotal();
			uploadResultsRound();
            //see if post request and they are values
        } 
    }

    
    function uploadResultsTotal() {
        $myfile = fopen("bestScoreTotal.txt", "r") or die("Unable to open file");
		$totalScoreWritten = false;
		$newfileContents = "";
		while(!feof($myfile)) {
			$linecontent = fgets($myfile);
			$arrfields = explode(',', $linecontent);

			//user already exists in board
			if ($arrfields[0] == $_COOKIE['username']) {
				//echo $arrfields[0];
				//echo $_COOKIE['username'];
				//echo ' equal ';
				//this is better than previous submit
				if ((int)$arrfields[4] < (int)$_POST['totalScore'] && $totalScoreWritten == false) {
					$newfileContents = true;
					$newfileContents .= $_COOKIE['username'] . "," . $_COOKIE['javascriptSkin'] . "," . $_COOKIE['javascriptEyes'] . "," . $_COOKIE['javascriptMouth'] . "," . $_POST['totalScore'] . "\n";
					//echo ' better f ';
					//better than previous submit but already written so don't write
				} else if ((int)$arrfields[4] < (int)$_POST['totalScore'] && $totalScoreWritten == true) {
					//echo ' better t ';

					//worse than before - don't write
				} else if ((int)$arrfields[4] > (int)$_POST['totalScore']) {
					$totalScoreWritten = true;
					//echo ' worse ';
					//they are equal so just keep file
				} else {
					//echo ' equal ';
					$newfileContents .= $arrfields[0] . "," .$arrfields[1]. ",".$arrfields[2]. ",".$arrfields[3]. ",".$arrfields[4];
				}
			} else {
				//BELOW WORKS - integration with user already existing still in development
				//score from game is less than score at this index
				if ((int)$arrfields[4] > (int)$_POST['totalScore']) {
					$newfileContents .= $arrfields[0] . "," .$arrfields[1]. ",".$arrfields[2]. ",".$arrfields[3]. ",".$arrfields[4];
					//echo ' smaller ';
					//score from game is more than index score and not written yet
				} else if ((int)$arrfields[4] < (int)$_POST['totalScore'] && $totalScoreWritten == false) {
					$newfileContents .= $_COOKIE['username'] . "," . $_COOKIE['javascriptSkin'] . "," . $_COOKIE['javascriptEyes'] . "," . $_COOKIE['javascriptMouth'] . "," . $_POST['totalScore'] . "\n";
					$newfileContents .= $arrfields[0] . "," .$arrfields[1]. ",".$arrfields[2]. ",".$arrfields[3]. ",".$arrfields[4];
					$totalScoreWritten = true;
					//echo ' larger ';
					//score from game is equal to the index score and not written yet - goes after
				} else if ((int)$arrfields[4] == (int)$_POST['totalScore'] && $totalScoreWritten == false) {
					$newfileContents .= $arrfields[0] . "," .$arrfields[1]. ",".$arrfields[2]. ",".$arrfields[3]. ",".$arrfields[4];
					$newfileContents .= $_COOKIE['username'] . "," . $_COOKIE['javascriptSkin'] . "," . $_COOKIE['javascriptEyes'] . "," . $_COOKIE['javascriptMouth'] . "," . $_POST['totalScore'] . "\n";
					$totalScoreWritten = true;
					//echo ' same ';
				} else {
					$newfileContents .= $arrfields[0] . "," .$arrfields[1]. ",".$arrfields[2]. ",".$arrfields[3]. ",".$arrfields[4];
					//echo ' meh ';
				}
			}
			
		}
		if ($totalScoreWritten == false) {
			$newfileContents .= "\n" . $_COOKIE['username'] . "," . $_COOKIE['javascriptSkin'] . "," . $_COOKIE['javascriptEyes'] . "," . $_COOKIE['javascriptMouth'] . "," . $_POST['totalScore'];
			//echo ' end ';
		}
		fclose($myfile);
		//echo $newfileContents;

		$myfile = fopen("bestScoreTotal.txt", "w") or die("Unable to open file!");
		fwrite($myfile, $newfileContents);
		fclose($myfile);

    }

	function uploadResultsRound() {
		//echo ' inside ';
		$myfile = fopen("bestScorePerRound.txt", "r") or die("Unable to open file");
		$arrayRoundstemp = $_POST['rounds'];
		$arrayRounds = array($arrayRoundstemp);
		//echo $arrayRounds;
		$newfileContents = "";
		$indexArr = 0;
		$arrLength = count($arrayRounds) - 1;
		//echo ' arrLength = ' . $arrLength;
		while(!feof($myfile)) {
			$linecontent = fgets($myfile);
			$arrfields = explode(',', $linecontent);

			//echo 'indexArr = ' . $indexArr;			

			//no more scores in array
			if ((int)$indexArr > (int)$arrLength) {
				//echo ' no more score in array ';
				$newfileContents .= $arrfields[0] . "," .$arrfields[1]. ",".$arrfields[2]. ",".$arrfields[3]. ",".$arrfields[4];

			} else {
				$val = $arrayRounds[(int)$indexArr];			
				//echo ' array score = ' . $val . ' ';
				//better
				if ((int)$arrfields[4] < (int)$val) {
					$newfileContents .= $_COOKIE['username'] . "," . $_COOKIE['javascriptSkin'] . "," . $_COOKIE['javascriptEyes'] . "," . $_COOKIE['javascriptMouth'] . "," . $val . "\n";
					//echo 'b';
					//not better
				} else {
					$newfileContents .= $arrfields[0] . "," .$arrfields[1]. ",".$arrfields[2]. ",".$arrfields[3]. ",".$arrfields[4];
					//echo 'w';
				}

			}		
			
			$indexArr++;
		}
		//file ran out so continue adding
		if ($indexArr < $arrLength) {
			//echo ' still more ';
			while ($indexArr <= $arrLength) {
				//echo ' index Array = ' . $indexArr . '  arrLength = ' . $arrLength . ' ';
				$newfileContents .= "\n" . $_COOKIE['username'] . "," . $_COOKIE['javascriptSkin'] . "," . $_COOKIE['javascriptEyes'] . "," . $_COOKIE['javascriptMouth'] . "," .  $val . "\n";

				$indexArr++;
			}
		}

		fclose($myfile);
		//echo $newfileContents;

		$myfile = fopen("bestScorePerRound.txt", "w") or die("Unable to open file!");
		fwrite($myfile, $newfileContents);
		fclose($myfile);
	}
?>

<html>
    <head>
		<link rel="stylesheet" type="text/css" href="style.css">
        <style>
            .leaderboard-area {
                width: 70%;
                margin: 50px auto;                
                background-color: rgba(128, 128, 128,.5); 
                border-radius: 30px;
                box-shadow: 5px 5px 4px;
				padding: 30px
			}
			.title {
				color: white;
			}
			.extra {
				margin:auto;
				border-collapse: separate;
				border-spacing: 2px;
				font-size: 1.2em;
			}
			.avatar-area {
				position: relative;
		        height: 100px;
                min-width: 100px;
			}
			.avatar {
                width: 80px;
                height: 80px;
                display: block;
                margin: auto;
                position: absolute;
                top: 0.5em;
	        }
			
			.decision-area {
				margin-bottom: 20px;
			}
			
			.number {
				width: 102px;
			}
			.scroll {
				overflow-y: scroll;
    			height: 347.6;
			}
			#scroll::-webkit-scrollbar {
				width: 8px;
				background-color: #2c3034;
			}


			#scroll::-webkit-scrollbar-track {
				box-shadow: inset 0 0 6px rgba(104, 140, 240, 0.3);
			}

			#scroll::-webkit-scrollbar-thumb {
				background-color: #373b3e;
				outline: 2px solid rgb(184, 184, 184);
			}
        </style>
	</head>
    <body>
        <div id = "main">
            <?php
                $title = 'Leaderboard Page';
                $page = 'leaderboard';
                include_once ('navbar.php');
            ?>
            <div class="leaderboard-area">
				<div class="decision-area">
					<button type="button" class="btn btn-dark" id="total-btn">Total Score</button>
					<button type="button" class="btn btn-dark" id="round-btn">Score per Round</button>
				</div>
				<div class="leaderboard" id="total-leaderboard">
					<div class="h2 font-weight-bold title">Total Score Leaderboard</div>
					<div class="table-responsive-sm scroll" id="scroll">
						<table class="extra table table-bordered align-middle table-dark table-striped table-image">
							<thead style="--bs-table-bg: blue ">
								<tr>
									<th scope="col" class="number">#</th>
									<th scope="col">Avatar</th>
									<th scope="col">Username</th>
									<th scope="col">Score</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$counter = 0;
								$myfile = fopen("bestScoreTotal.txt", "r") or die("Unable to open file");
								// Output one line until end-of-file
								while(!feof($myfile)) {
									$counter++;
									$linecontent = fgets($myfile);
									$arrfields = explode(',', $linecontent);
									echo '<tr><th scope="row">' . $counter . '</th>';
									echo '<td class="avatar-area">';
									echo '<img id="skin-img" class="avatar" src="emoji_assets/skin/' . $arrfields[1] . '" alt="Skin">';
									echo '<img id="skin-img" class="avatar" src="emoji_assets/eyes/' . $arrfields[2] . '" alt="Eyes">';
									echo '<img id="skin-img" class="avatar" src="emoji_assets/mouth/' . $arrfields[3] . '" alt="Mouth">';
									echo '</td>';
									echo '<td>' . $arrfields[0] . '</td>';
									echo '<td>' . $arrfields[4] . '</td></tr>';
								}
								fclose($myfile);
							?>
								
							</tbody>

						</table>		
					</div>
				</div>
				<div class="leaderboard" id="round-leaderboard">
					<div class="h2 font-weight-bold title">Score per Round Leaderboard</div>
					<div class="table-responsive-sm scroll" id="scroll">
						<table class="extra table table-bordered align-middle table-dark table-striped table-image">
							<thead style="--bs-table-bg: blue ">
								<tr>
									<th scope="col" class="number">Round</th>
									<th scope="col">Avatar</th>
									<th scope="col">Username</th>
									<th scope="col">Score</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$counter = 0;
								$myfile = fopen("bestScorePerRound.txt", "r") or die("Unable to open file");
								// Output one line until end-of-file
								while(!feof($myfile)) {
									$counter++;
									$linecontent = fgets($myfile);
									$arrfields = explode(',', $linecontent);
									echo '<tr><th scope="row">' . $counter . '</th>';
									echo '<td class="avatar-area">';
									echo '<img id="skin-img" class="avatar" src="emoji_assets/skin/' . $arrfields[1] . '" alt="Skin">';
									echo '<img id="skin-img" class="avatar" src="emoji_assets/eyes/' . $arrfields[2] . '" alt="Eyes">';
									echo '<img id="skin-img" class="avatar" src="emoji_assets/mouth/' . $arrfields[3] . '" alt="Mouth">';
									echo '</td>';
									echo '<td>' . $arrfields[0] . '</td>';
									echo '<td>' . $arrfields[4] . '</td></tr>';
								}
								fclose($myfile);
							?>
								
							</tbody>

						</table>		
					</div>
				</div>
			</div>
		</div>

        <?php

            //if user already exists on the leaderboard replace their score
            //str_replace($filearrfields[4],$postarrfields[4],$linecontent);

            //else go back through and add them based on score 

            //looks like need to rewrite file either way
        ?>
        
        <script>
			document.getElementById("round-leaderboard").style.display = "none";
			document.getElementById("total-leaderboard").style.display = "none";
			
			const total_Score_leaderboard = document.getElementById("total-btn");
            total_Score_leaderboard.addEventListener("click", display_total);
			
			const round_Score_leaderboard = document.getElementById("round-btn");
            round_Score_leaderboard.addEventListener("click", display_round);
		
		
			function display_total() {
				document.getElementById("round-leaderboard").style.display = "none";
				document.getElementById("total-leaderboard").style.display = "block";
				document.getElementById("round-btn").classList.remove("active");
				document.getElementById("total-btn").classList.add("active");
			}
			
			function display_round() {
				document.getElementById("total-leaderboard").style.display = "none";
				document.getElementById("round-leaderboard").style.display = "block";
				document.getElementById("total-btn").classList.remove("active");
				document.getElementById("round-btn").classList.add("active");
			}
        </script>
    </body>
</html>