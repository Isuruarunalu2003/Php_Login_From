<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>3D Parallax + Loader Homepage</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

.preloader {
    position: fixed;
    inset: 0;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: loaderFadeOut 1s ease forwards;
    animation-delay: 2.3s;
    pointer-events: none;
}

.loader-logo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    animation: pulseLoader 2s infinite ease-in-out;
}

@keyframes pulseLoader {
    0%   { transform: scale(1); box-shadow: 0 0 10px #00eaff; }
    50%  { transform: scale(1.25); box-shadow: 0 0 40px #00eaff; }
    100% { transform: scale(1); box-shadow: 0 0 10px #00eaff; }
}

@keyframes loaderFadeOut {
    to { opacity: 0; visibility: hidden; }
}

.parallax {
    position: fixed;
    inset: 0;
    overflow: hidden;
    z-index: -10;
}

.parallax img {
    position: absolute;
    width: 120%;
    height: 120%;
    object-fit: cover;
    transition: transform 0.15s ease-out;
}

.layer-back {
    z-index: -3;
    filter: brightness(0.8);
}

.layer-mid {
    z-index: -2;
    opacity: 0.9;
}

.layer-front {
    z-index: -1;
    opacity: 1;
}
.overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.3);
    z-index: -1;
}

nav {
    width: 100%;
    padding: 15px 50px;
    background: rgba(0,0,0,0.25);
    display: flex;
    justify-content: space-between;
    align-items: center;
    backdrop-filter: blur(10px);
    position: relative;
    z-index: 10;
    animation: slideDown 1.4s ease forwards;
}

nav .logo {
    width: 80px;
    height: 50px;
    animation: logoGlow 3s infinite alternate;
}

.register-btn {
    padding: 10px 25px;
    border-radius: 20px;
    background: linear-gradient(90deg, #34bfd7, #5a00ff);
    color: white;
    text-decoration: none;
    font-weight: 500;
}

.hero {
    position: absolute;
    top: 23%;
    left: 7%;
    color: white;
    z-index: 5;
}

.hero h1 {
    font-size: 70px;
    font-weight: 700;
    line-height: 1.15;
    background: linear-gradient(90deg, #ffffff, #91eaff, #009dff);
    background-size: 300%;
    -webkit-background-clip: text;
    color: transparent;
    animation: textGradient 5s ease-in-out infinite,
               fadeUp 1.4s ease forwards;
}

.hero p {
    margin-top: 25px;
    font-size: 22px;
    max-width: 500px;
    opacity: 0;
    animation: fadeUp 1.8s ease forwards;
    animation-delay: 0.4s;
}

.join-btn {
    display: inline-block;
    margin-top: 60px;
    padding: 17px 50px;
    background: linear-gradient(90deg, #00bbff, #0044ff);
    border-radius: 40px;
    color: white;
    text-decoration: none;
    font-size: 22px;
    font-weight: 600;
    opacity: 0;
    animation: fadeUp 2s ease forwards;
    animation-delay: 0.7s;
    box-shadow: 0 0 25px rgba(0,140,255,0.7);
}

.clock-container {
    position: absolute;
    top: 33%;
    right: 7%;
    text-align: center;
    color: white;
    opacity: 0;
    animation: fadeUp 2s ease forwards;
    animation-delay: 0.9s;
}

.clock-time {
    font-size: 95px;
    font-weight: 700;
    text-shadow: 0 0 25px #00d9ff;
    animation: floatClock 4s ease-in-out infinite;
}

.clock-date {
    margin-top: 15px;
    font-size: 30px;
}

@keyframes floatClock { 0% { transform: translateY(0); } 50% { transform: translateY(-18px); } 100% { transform: translateY(0); } }
@keyframes fadeUp { from { transform: translateY(40px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes textGradient { 0% {background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
@keyframes logoGlow { from{filter:drop-shadow(0 0 2px #00eaff);} to{filter:drop-shadow(0 0 12px #00eaff);} }

#neonCanvas {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    z-index: -5;  
    pointer-events: none;
}

</style>
</head>

<body>

<div class="preloader">
    <img src="./src/logo.svg" class="loader-logo">
</div>
<div class="parallax">
    <img src="./src/parallax-back.png" class="layer-back">
    <img src="./src/parallax-mid.png" class="layer-mid">
    <img src="./src/parallax-front.png" class="layer-front">
</div>

<div class="overlay"></div>

<nav>
    <img src="./src/logo.svg" class="logo">
    <a href="./src/about.html" class="register-btn">About us</a>
</nav>

<div class="hero">
    <h1>UNLOCK YOUR<br>POTENTIAL</h1>
    <p>Technology is your advantage. We build scalable, secure IT systems 
        that maximize your business potential. JOIN NOW.</p>

    <?php if (!isset($_SESSION['user'])): ?>
        <a href="register.php" class="join-btn">JOIN NOW</a>
    <?php endif; ?>
</div>
<canvas id="neonCanvas"></canvas>
<div class="clock-container">
    <div class="clock-time" id="clock-time">00:00:00</div>
    <div class="clock-date" id="clock-date">Loading...</div>
</div>

<script>

function updateClock() {
    const now = new Date();
    document.getElementById("clock-time").innerText =
        now.toLocaleTimeString("en-US", {hour12:false});
    document.getElementById("clock-date").innerText =
        now.toLocaleDateString("en-US", { weekday:"long", year:"numeric", month:"long", day:"numeric" });
}
setInterval(updateClock, 1000);
updateClock();


const back  = document.querySelector(".layer-back");
const mid   = document.querySelector(".layer-mid");
const front = document.querySelector(".layer-front");

document.addEventListener("mousemove", (e) => {
    let x = (window.innerWidth / 2 - e.pageX) / 80;
    let y = (window.innerHeight / 2 - e.pageY) / 80;

    back.style.transform  = `translate(${x/2}px, ${y/2}px) scale(1.05)`;
    mid.style.transform   = `translate(${x}px, ${y}px) scale(1.08)`;
    front.style.transform = `translate(${x*1.6}px, ${y*1.6}px) scale(1.12)`;
});
const canvas = document.getElementById("neonCanvas");
const ctx = canvas.getContext("2d");

function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}
resizeCanvas();
window.addEventListener("resize", resizeCanvas);

class NeonLine {
    constructor() {
        this.reset();
    }

    reset() {
        this.x = Math.random() * canvas.width;
        this.y = -10;
        this.length = 20 + Math.random() * 40;
        this.speed = 4 + Math.random() * 6;
        this.opacity = 0.3 + Math.random() * 0.7;

        const colors = ["#ff00ff", "#00eaff", "#ff0080", "#7700ff"];
        this.color = colors[Math.floor(Math.random() * colors.length)];
    }

    update() {
        this.y += this.speed;
        if (this.y > canvas.height + this.length) {
            this.reset();
        }
    }

    draw() {
        ctx.beginPath();
        ctx.strokeStyle = this.color;
        ctx.lineWidth = 2;
        ctx.globalAlpha = this.opacity;
        ctx.moveTo(this.x, this.y);
        ctx.lineTo(this.x, this.y + this.length);
        ctx.stroke();
        ctx.globalAlpha = 1;
    }
}

const lines = [];
for (let i = 0; i < 70; i++) {
    lines.push(new NeonLine());
}

function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    lines.forEach(line => {
        line.update();
        line.draw();
    });

    requestAnimationFrame(animate);
}

animate();
</script>

</body>
</html>
