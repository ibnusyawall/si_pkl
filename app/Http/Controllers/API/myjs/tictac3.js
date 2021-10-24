//Tic Tac Toe - Jack Carrick

//Game Code
let gameData, gameBoard, currentPlayer

const COMBOS = [
    [0,3,6],
    [1,4,7],
    [2,5,8],
    [0,1,2],
    [3,4,5],
    [6,7,8],
    [0,4,8],
    [2,4,6],
]

const isWinner = (gameData, player) => {
    for (let i=0;i<COMBOS.length;i++){
        let won = true
        for (let j = 0; j<COMBOS[i].length; j++){
            id = COMBOS[i][j]
            playerHasChecked = (gameData[id] === player)
            won = playerHasChecked && won
        }
        if(won) return true
    }
    return false
}

const isTie = (gameData) => {
    let isBoardFull = true
    for (let i=0; i<gameData.length; i++){
        isBoardFull = gameData[i] && isBoardFull
    }
    if(isBoardFull){
        return true
    }
    return false
}

const checkGameOver = (gameData, player) => {
    if(isWinner(gameData, currentPlayer)){
        displayGameOver(`The winner is ${currentPlayer}!`)
        gameOver = true
    }
    if(isTie(gameData)){
        displayGameOver("Tie game!")
        gameOver = true
    }
}

const updateGameBoard = (player, space) => {
    gameData[space] = player
    let updatedBoard = gameBoard.replace(space, player)
    gameBoard = updatedBoard
    console.log(gameBoard)
}

const playMove = (player, space) => {
    updateGameBoard(player, space)
    checkGameOver(gameData, currentPlayer)
    
    //switch players each turn
    if(currentPlayer === "X"){
        currentPlayer = "O"
    } else {
        currentPlayer = "X"
    }
}

//Interface
const readline = require("readline")
const rl = readline.createInterface( 
    process.stdin, process.stdout)

const prompt = () =>{
    rl.question(`It is ${currentPlayer}'s move. Where would you like to play?`, answer => {
        const lcAnswer = answer.toLowerCase()
        if(lcAnswer === "restart" || lcAnswer === "r"){
            console.log("You've cleared the board!")
            init()
            prompt()
            return
        }
        if(lcAnswer === "quit" || lcAnswer === "q"){
            displayGameOver("")
            return
        }
        const newNumber = +answer
        const floorNumber = Math.floor(newNumber)
        if(floorNumber>9 || floorNumber < 0){
            console.log("Please enter a number between 0 and 9")
            prompt()
            return
        }
        if(isNaN(newNumber)){
            console.log("This is not a number!")
            prompt()
            return
        } else {
            if(gameData[floorNumber]){
                console.log("This space has already been played! Chose another.")
                prompt()
                return
            }
            playMove(currentPlayer, floorNumber)
            prompt()
            return
        }
    })
}

const init = () => {
    gameData = new Array(9)
    gameBoard = `0|1|2\n3|4|5\n6|7|8`
    currentPlayer = 'X'
    const greetingMessage = 
        `Welcome to Tic Tac Toe!\n\n${gameBoard}\n\nType restart or r to clear the board`
    console.log(greetingMessage)
    prompt()
}
init()

const displayGameOver = (message) => {
    rl.question(`${message} Would you like to start a new game?`, answer => {

        lcAnswer = answer.toLowerCase()
        if(lcAnswer === "yes" || lcAnswer === "y"){
            init()
            prompt()
        }
        else if(lcAnswer === "no" || answer === "n"){
            console.log("Thanks for playing! Have a great day. Goodbye.")
            rl.close()
        } else {
            displayGameOver("I didn't understand your message")
        }
    })
}
