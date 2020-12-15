var Colors = {
    red:0xf25346,
    white:0xd8d0d1,
    brown:0x59332e,
    pink:0xF5986E,
    brownDark:0x23190f,
    blue:0x68c3c0,
    yellow:0xf4ce93,
};

var scene, camera, renderer;
var HEIGHT, WIDTH;
var game;
var sea, sky, airplane;
var mousePos = { x: 0, y: 0 };
var deltaTime = 0;
var newTime = new Date().getTime();
var oldTime = new Date().getTime();

function loop(){
  newTime = new Date().getTime();
  deltaTime = newTime-oldTime;
  oldTime = newTime;

  game.speed = game.initSpeed;

  updatePlane();
  sea.moveWaves();
  sky.moveClouds();

  renderer.render(scene, camera);
  requestAnimationFrame(loop);
}

function updatePlane(){
  var targetY = normalize(mousePos.y,-.75,.75,25, 175);
  var targetX = normalize(mousePos.x,-.75,.75,-100, 100);
  airplane.mesh.position.y += (targetY-airplane.mesh.position.y)*0.1;
  airplane.mesh.rotation.z = (targetY-airplane.mesh.position.y)*0.0128;
  airplane.mesh.rotation.x = (airplane.mesh.position.y-targetY)*0.0064;
  airplane.propeller.rotation.x += 0.3;
}

function resetGame(){
  game = {
    planeDefaultHeight:100, // Độ cao ban đầu của máy bay
    initSpeed:.01,
    speed: 0,


    level:1,
    baseSpeed:.00035,
    targetBaseSpeed:.00035,
    incrementSpeedByTime:.0000025,
    incrementSpeedByLevel:.000005,
    planeAmpHeight:80,
    seaRadius:600,
    ratioSpeedDistance:50,
    distance:0,
    distanceForCoinsSpawn:100,
    coinDistanceTolerance:15,
    coinsSpeed:.5,
    coinLastSpawn:0,
  };
}

function init(){
  document.addEventListener('mousemove', handleMouseMove, false); // Bắt sự kiện di chuyển chuột
  resetGame();

  createScene();
  createLights();

  createPlane();
  createSea();
  createSky();

  loop();
}
window.addEventListener('load', init, false);
