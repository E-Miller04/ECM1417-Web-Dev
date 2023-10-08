<html lang="en">
	<head>
    <title><?php echo $title ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		
		<style>
			.nav-background {
				background: blue;
				height: 80px;
				box-shadow: 0px 3px 5px #000;
			}
			.nav-link {
				color: white !important;
				font: Verdana;
				font-size: 12px;
				font-weight: bold;
				display: block;
				text-align: center;
			}
			.selected {
				background: #0064FF;
				border-radius: 50%;
			}
			.ms-auto {
				
			}
			.profile-area {
				height: 50px;
				width: 50px;
				padding: 0px;
			}
			.profile{
				position: absolute;
				background-position: center center;	
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg nav-background">
			<div class="container-fluid">			
				<?php
				if (isset($_COOKIE["username"])) {
					echo '<a class="navbar-brand profile-area">';
					echo '<img src="emoji_assets/skin/'.$_COOKIE['javascriptSkin'].'" alt="User Image" width="50" height="50" class="d-inline-block align-text-top profile">';
					echo '<img src="emoji_assets/eyes/'.$_COOKIE['javascriptEyes'].'" alt="User Image" width="50" height="50" class="d-inline-block align-text-top profile">';
					echo '<img src="emoji_assets/mouth/'.$_COOKIE['javascriptMouth'].'" alt="User Image" width="50" height="50" class="d-inline-block align-text-top profile"></a>';
				} else {
					echo '<a class="navbar-brand">';
					echo '<img src="Default-User-Image.png" alt="User Image" width="50" height="50" class="d-inline-block align-text-top"></a>';
				}
				?>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav">
						<li class="nav-item">
							  <a class="nav-link <?php if ($page == 'index') {echo 'selected';} ?>" href="index.php" name = "home">Home</a>
						</li>
						
					</ul>
					<ul class="navbar-nav ms-auto">
						<li class="nav-item">
							  <a class="nav-link <?php if ($page == 'pairs') {echo 'selected';} ?>" href="pairs.php" name = "memory">Play Pairs</a>
						</li>
						<?php
						if (isset($_COOKIE["username"])) {
							echo '<li class="nav-item"><a class="nav-link Register-or-Leaderboard ';
							if ($page == "leaderboard") {echo "selected";}
							echo '" href="leaderboard.php" name = "leaderboard">Leaderboard</a></li>';
						} else {
							echo '<li class="nav-item"><a class="nav-link Register-or-Leaderboard ';
							if ($page == "registration") {echo "selected";}
							echo '" href="registration.php" name = "register">Register</a></li>';
						}
						?>
					</ul>
				</div>
			</div>
		</nav>
	
	</body>
</html>