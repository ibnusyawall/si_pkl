/*
 * Created by Adrian Jost
 * Feel free to use, but please credit me
 *
 * Start the game by calling `ttt()`
 */
function drawBoard(round, board){
    console.group(`Score after round ${round}`);
    console.log(" ");
    console.log(' ' + (board["7"] || '7 ') + " | " + (board["8"] || ' 8 ') + " | " + (board["9"] || ' 9 '));
    console.log("---------------");
    console.log(' ' + (board["4"] || '4 ') + " | " + (board["5"] || ' 5 ') + " | " + (board["6"] || ' 6 '));
    console.log("---------------");
    console.log(' ' + (board["1"] || '1 ') + " | " + (board["2"] || ' 2 ') + " | " + (board["3"] || ' 3 '));
    console.log(" ");
    console.groupEnd();
};

function solutions(board) {
    return false
        // horizontal
        || (board["7"] && (board["7"] == board["8"] && board["7"] == board["9"]))
        || (board["4"] && (board["4"] == board["5"] && board["4"] == board["6"]))
        || (board["1"] && (board["1"] == board["2"] && board["1"] == board["3"]))
        // vertical
        || (board["7"] && (board["7"] == board["4"] && board["7"] == board["1"]))
        || (board["8"] && (board["8"] == board["5"] && board["8"] == board["2"]))
        || (board["9"] && (board["9"] == board["6"] && board["9"] == board["3"]))
        // diagonal
        || (board["7"] && (board["7"] == board["5"] && board["7"] == board["3"]))
        || (board["9"] && (board["9"] == board["5"] && board["9"] == board["1"]));
};

function pc_move(board, playerSymbol, opponentSymbol){
    let testBoard;
    // try to finish, then try to block opponent
    const player = [playerSymbol, opponentSymbol];
    for (var p = 0 ; p < 2; p++){
        for (var i = 1 ; i < 10; i++){
            if(board[i.toString()] !== null){
                continue;
            }
            testBoard = Object.assign({}, board);
            testBoard[i.toString()] = player[p];
            if(solutions(testBoard)){
                return i.toString();
            }
        }    
    }
    
    // guess any other free field
    let guess = undefined;
    while(guess === undefined || board[guess] !== null){
        guess = Math.floor(Math.random() * 10 + 1).toString();
    }
    return guess;
}

var defaultConfig = {
    player1:{
        title: "Player 1",
        symbol: "💚"
    },
    player2:{
        title: "Player 2",
        symbol: "❤️"
    }
};
console.log("Wan't to play a game? Type `ttt()` ;)");
function ttt(config){
    config = Object.assign(defaultConfig, config || {});
    let gameOn = true;
    let player1Move, round, computer, board, ask, currentPlayer, opponentPlayer;

    console.log("%cWELCOME TO Tic Tac Toe", "font-size: x-large");
    console.log(`${config.player1.title}: ${config.player1.symbol}`);
    console.log(`${config.player2.title}: ${config.player2.symbol}`);

    while (gameOn === true){
        // init new game
        round = 0
        player1Move = true
        board = {
            "7": null,
            "8": null,
            "9": null,
            "4": null,
            "5": null,
            "6": null,
            "1": null,
            "2": null,
            "3": null
        };
        computer = prompt('Do you want to play with another person? (yes/NO)') !== 'yes';
        drawBoard(round++, board);
        // for loop for game logic
        for (var i = 0 ; i < 9; i++){
            if (solutions(board)){
                console.log(`%c${currentPlayer.title} )(${currentPlayer.symbol}) wins!`, 'font-size: x-large');
                gameOn = false;
                break;
             }

            currentPlayer = config.player1;
            opponentPlayer = config.player2;
            if(!player1Move)
                currentPlayer = config.player2;
                opponentPlayer = config.player1;

            ask = undefined;
            while(board[ask] !== null || ask === undefined){
                if(player1Move === false && computer === true){
                    ask = pc_move(board, currentPlayer.symbol, opponentPlayer.symbol);
                }else{
                    ask = prompt(`${currentPlayer.title} (${currentPlayer.symbol}) where would you like to go (1-9)? (type "exit" to leave)`);
                    if(ask == 'exit') {
                        gameOn = false;
                        break;
                    }
                }
            }
            if(gameOn == false) {
                break;
            }

            board[ask] = currentPlayer.symbol;
            player1Move = !player1Move;
            drawBoard(round++, board);
        }
        if(gameOn === true) {
            console.log("%cTie Game!", "font-size: x-large");
            gameOn = false;
        }
        if(ask !== 'exit' && prompt("Play again? (YES/no)") !== "no"){
            gameOn = true;
        }
    }
}
ttt()
