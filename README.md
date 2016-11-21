## Synopsis

Final project code for SCSU Fall 2016 CSC 543. A battleship game written in PHP, MySQL, HTML, and Javascript

## Installation

Prerequisites:
* A xAMP stack (Apache, MySQL, PHP)

1. Create a place to put the project in your public html area. Make a new folder/directory, or create a new virtual site.
2. Download or clone the project and place it in the place you chose from (1)
3. Create the application database using sql/warzone.sql
4. Create a MySQL user named warzone and grant database privileges to it. If you want to set a password, feel free to do so. You will need to update models/database.php with your specifics.

## Project Requirements 
I've broken down the project assignment into a list of requirements in the form of Agile user stories. Some of them have dependenicies, but for the most part they can be worked on in parallel by team members.
- [x] As the Game, I require Players to login with a username and password
    * Basic design and strategy: "light" MVC architecture, using models, controllers/handlers, and views without a router
    * warzone database
    * warzone.user table
    * index.php (launch view)
    * handlers/login.php
    * model/database.php
- [x] As a Player, if I fail to authenticate, I want to see a message saying so
    * $_SESSION array elements for feedback (I know it's not true MVC)
- [ ] As a potential Player, I want to register with Battleship so that I can play
- [ ] As the Game, I want Players to ask to sign up from the launch page if they don't have a login already
- [ ] As the Game, I shall require all Players to have unique usernames
- [ ] As the Game, I want Players to type their password twice exactly the same way in order to complete the signup process
- [ ] As the Game, I shall allow a Player to be logged in only once from a single location or browser instance
- [ ] As a Player, I want to completely sign out of the game, by using Sign Out
- [ ] As a Player, I want to complete sign out of the game by closing my browser window
- [ ] As a Player, I want to be taken to the game lobby after successfully logging in
- [ ] As a Player, I want to see my name in a greeting in the Lobby
- [ ] As a Player, I want to see who else is logged in and not engaged in a game
- [ ] As a Player, I want to invite another unengaged Player to start a game with me
- [ ] As the Game, I want to prevent a Player from inviting other available Players to play after making an invitation to one
- [ ] As the Game, I want to cancel all pending invitations when the Inviter logs out
- [ ] As an invited Player, I want to receive a notice of the invitation
- [ ] As an invited Player, I want to be able to accept the invitation
- [ ] As an invited Player, I want to be able to reject the invitation
- [ ] As a Player whose invitation to play has been turned down, I want to be able to invite another player
- [ ] As a Player whose invitation to play has been turned down, I want to receive notice of the rejection
- [ ] As a Player whose invitation to play has been turned down, I want to receive notice of the acceptance
- [ ] As two Players who have agreed to play, we want to be taken into the game arena

## Contributors

TO DO

