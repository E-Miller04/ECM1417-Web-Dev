landing page = http://ml-lab-4d78f073-aa49-4f0e-bce2-31e5254052c7.ukwest.cloudapp.azure.com:53026/game/index.php
made using chrome browser

All pages:
Images used are either from emoji_assets or custom made in powerpoint
navbar	- if not registered then a blank profile photo 
	- selected page highlighted and page title changes
stock background


Index:
Animated text

Registration:
complex
name 	- bootstrap
	- invalid characters in name = red text message
avatar selection	
	- customisation on left side
	- avatar shown on right side which changes as buttons clicked
submit button
	- if invalid username submit is disabled
already registered
	- message
	- no form to fill in 
(username cookie set to last 2 hours)

Pairs:
complex
cards 	- custom made
display	- high score of player
	- current score
	- current level
	- cards layout is based on screen size (how many columns)
	- cards have hover and 3d flip affect 
	- once matched cards have silver outline and can't be interacted with
mechanics
	- timer and counter for attempts
	- can't unflip a flipped card until another is chosen
	- can't interact with cards till logic executed
	- on game-over screen
		- cards are no longer clickable/hover
		- message why game is over & decision
	- every 3 rounds = new difficulty
		- intervening rounds = time and guesses decrease
	- round 1 = pairs
	- round 12 = triples
	- round 24 = quads	(can test by changing round=0 to round=23)
	- bonus points on time left (each 10%) and guesses left
	- score and perRound list
	- new highscore = "gold" if they are logged in and have a previous high score

Leaderboard:
complex implementation attempted
	- buttons to switch between the 2 boards
	- read from text files
	- scroll bar
	- writing to files still in development so may be some bugs - look at leaderboard before posting to it in case of bugs
		- high score table should only have 1 instance of a player - should pick highest (new v old score)
		- round score table should replace any scores from game that are better than table scores - ran out of time to figure out array problems (only updates round 1)