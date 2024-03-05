// Import knihovny PixiJS
const PIXI = require('pixi.js');

// Vytvoření Pixi aplikace
const app = new PIXI.Application({ width: 800, height: 600 });
document.body.appendChild(app.view);

// Paddle
const paddle = new PIXI.Graphics();
paddle.beginFill(0xFFFFFF);
paddle.drawRect(0, 0, 20, 1000);
paddle.endFill();
paddle.x = 10;
paddle.y = app.screen.height / 2 - paddle.height / 2;
app.stage.addChild(paddle);

// Ball
const ball = new PIXI.Graphics();
ball.beginFill(0xFFFFFF);
ball.drawCircle(0, 0, 10);
ball.endFill();
ball.x = app.screen.width / 2;
ball.y = app.screen.height / 2;
app.stage.addChild(ball);

// Player
const player = new PIXI.Graphics();
player.beginFill(0xFF0000);
player.drawRect(0, 0, 20, 100);
player.endFill();
player.x = app.screen.width - 30;
player.y = app.screen.height / 2 - player.height / 2;
app.stage.addChild(player);

// Variables
let ballSpeedX = 5;
let ballSpeedY = 5;
const playerSpeed = 5;

// Game Loop
app.ticker.add(() => {
    // Move Ball
    ball.x += ballSpeedX;
    ball.y += ballSpeedY;

    // Collision with top/bottom walls
    if (ball.y <= 0 || ball.y >= app.screen.height) {
        ballSpeedY *= -1;
    }

    // Collision with left paddle
    if (ball.x <= paddle.width && ball.y + ball.height >= paddle.y && ball.y <= paddle.y + paddle.height) {
        ballSpeedX *= -1;
    }

    // Collision with right paddle (player)
    if (ball.x + ball.width >= player.x && ball.y + ball.height >= player.y && ball.y <= player.y + player.height) {
        ballSpeedX *= -1;
    }

    // Game Over
    if (ball.x <= 0 || ball.x >= app.screen.width) {
        resetBall();
    }
});

// Reset Ball
function resetBall() {
    ball.x = app.screen.width / 2;
    ball.y = app.screen.height / 2;
    ballSpeedX *= -1;
}

// Keyboard Input
const keys = {};
document.addEventListener('keydown', event => {
    keys[event.key] = true;
});

document.addEventListener('keyup', event => {
    keys[event.key] = false;
});

// Player Movement
function movePlayer() {
    if (keys['w'] || keys['ArrowUp']) {
        player.y -= playerSpeed;
    }
    if (keys['s'] || keys['ArrowDown']) {
        player.y += playerSpeed;
    }
}

// Game Loop
app.ticker.add(() => {
    movePlayer();
});
