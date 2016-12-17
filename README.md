## Synopsis

Final project code for SCSU Fall 2016 CSC 543. A battleship game written in PHP, MySQL, HTML, and Javascript

## Installation

Prerequisites:
* A xAMP stack (Apache, MySQL, PHP)

1. Create a place to put the project in your public html area. Make a new folder/directory, or create a new virtual site.
2. Download or clone the project and place it in the place you chose from (1)
3. Create the application database using sql/warzone.sql
4. Create a MySQL user named warzone and grant database privileges to it. If you want to set a password, feel free to do so. You will need to update models/database.php with your specifics.

## Contributors

I've broken down the project assignment into a list of requirements in the form of Agile user stories. Some of them have dependenicies, but for the most part they can be worked on in parallel by team members.

### TO DO

- [x] As the Game, I require Players to login with a username and password
    * Basic design and strategy: "light" MVC architecture, using models, controllers/handlers, and views without a router
    * warzone database
    * warzone.user table
    * index.php (launch view)
    * handlers/login.php (SessionModel class)
    * model/database.php (Database interaction class)
- [x] As a Player, if I fail to authenticate, I want to see a message saying so
    * $_SESSION array elements for feedback (I know it's not true MVC)
- [x] As a potential Player, I want to register with Battleship so that I can play
    * signup.php (new user view)
    * handlers/register.php (UserModel class)
    * New Database class method: create
  [ ] Refactor: encrypted password storage
    * Store passwords in users with salt and SHA encryption
    * Repeat encryption scheme when comparing passwords for authentication
  [x] Refactor: SessionModel reorganizaton
    * Separate SessionModel class into its own file
    * Add session state query to constructor
- [x] As the Game, I want Players to ask to sign up from the launch page if they don't have a login already
    * "New Sign Up" button on index.php linking to signup.php  
- [x] As the Game, I shall require all Players to have unique usernames
    * New UserModel method: exists
- [x] As the Game, I want Players to type their password twice exactly the same way in order to complete the signup process
    * New UserModel method: passwordMatches
- [x] As the Game, I shall allow a Player to be logged in only once from a single location or browser instance
- [x] As a Player, I want to completely sign out of the game, by using Logout
    * New handler: handlers/logout.php
    * New SessionModel method logout
    * New Database method delete
    * New home.php page button Logout
- [ ] As a Player, I want to complete sign out of the game by closing my browser window
- [x] As a Player, I want to be taken to the game lobby after successfully logging in
    * New view home.php
    * New session variable userName to indicate login status
    * New login and register flow to direct to home.php
- [x] As a Player, I want to see my name in a greeting in the Lobby
- [x] As a Player, I want to see who else is logged in and not engaged in a game
    * New table: sessions
    * New table: invitations
    * New api: api/OnlinePlayers.php
    * New home.php table for Available Players
- [x] As a Player, I want to invite another unengaged Player to start a game with me
    * New api: api/Invitations.php
    * New model: models/InvitationsModel.php
    * home.php: new function invitePlayer()
    * home.php: invitePlayer() added to "Invite to Play" button
- [x] As the Game, I want to prevent a Player from inviting other available Players to play after making an invitation to one
	* home.php: invitation button click handler disables all other invitation buttons when activated
- [x] As the Game, I want to cancel all pending invitations when the Inviter logs out
	* InvitationModel: new method cancel()
	* logout.php: updated workflow to include checking for and removing open invitations by player
- [x] As an invited Player, I want to receive a notice of the invitation
- [x] As an invited Player, I want to be able to accept the invitation
- [x] As an invited Player, I want to be able to reject the invitation
- [x] As a Player whose invitation to play has been turned down, I want to be able to invite another player
- [x] As a Player whose invitation to play has been turned down, I want to receive notice of the rejection
- [x] As a Player whose invitation to play has not been turned down, I want to receive notice of the acceptance
- [x] As two Players who have agreed to play, we want to be taken into the game arena


