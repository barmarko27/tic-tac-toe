<p align="center">
    <a href="https://en.wikipedia.org/wiki/Tic-tac-toe" target="_blank">
        <img src="https://w7.pngwing.com/pngs/244/874/png-transparent-3d-tic-tac-toe-game-multiplayer-tictactoe-artificial-intelligence-toes-game-angle-leaf.png" width="350" alt="Tic Tac Toe Game">
    </a>
</p>

## Backend TEST

The backend will be used by a frontend built by a separate team, but they have provided us with a set of product level requirements that we must meet, exposed as an API. The requirements are as follows:

1. Need an endpoint to call to start a new game. The response should give me some kind of ID for me to use in other endpoints calls to tell the backend what game I am referring to.
2. Need an endpoint to call to play a move in the game. The endpoint should take as inputs the Game ID (from the first endpoint), a player number (either 1 or 2, and the position of the move being played. The response should include a data structure with the representation of the full board so that the UI can update itself with the latest data on the server. The response should also include a flag indicating whether someone has won the game or not and who that winner is if so.
3. The endpoint that handles moves being played should perform some basic error handling to ensure the move is valid, and that it is the right players turn (ie. a player cannot play two moves in a row, or place a piece on top of another player’s piece)

## Requirements

1. Docker up & Running

## Installation

Pull this repository and run this command: `docker compose up -d`

## Consuming APIs

This project contains three endpoints:

1. Create a new game
2. Play
3. Get Game status

You can find the swagger opening your browser at: [Swagger UI URL](https://localhost/api/doc)

## Endpoints

#### Start a new game

> curl -X 'POST' \
  'https://localhost/api/game/start-game' \
  -H 'accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{}'
  
#### Play
> curl -X 'POST' \
  'https://localhost/api/game/play' \
  -H 'accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{
  "gameId": 62,
  "player": "X",
  "x": 2,
  "y": 2
}'

#### Game status

> curl -X 'GET' \
  'https://localhost/api/game/62/status' \
  -H 'accept: application/json'