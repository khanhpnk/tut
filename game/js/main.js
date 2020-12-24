var scene, camera, renderer;
var HEIGHT, WIDTH;
var sea, sky, airplane;
var mousePos = { x: 0, y: 0 };

var deltaTime = 0;
var newTime = new Date().getTime();
var oldTime = new Date().getTime();

var fieldDistance, energyBar, replayMessage, fieldLevel, levelCircle;

function loop(){
  newTime = new Date().getTime();
  deltaTime = newTime-oldTime;
  oldTime = newTime;

  game.distance += game.speed*deltaTime
  fieldDistance.innerHTML = Math.floor(game.distance);

  if (game.distance < 10000 || game.distance > 20000)
  {
    updatePlane();
    sea.moveWaves();
    sky.moveClouds();
    airplane.movePropeller();
    renderer.render(scene, camera);
  }

  requestAnimationFrame(loop);
}

function updatePlane(){
  //var targetX = normalize(mousePos.x, -1, 1, -100, 100);
  var targetY = normalize(mousePos.y, -1, 1, 25, 175);

  //airplane.mesh.position.x = targetX;
  airplane.mesh.rotation.z = (targetY-airplane.mesh.position.y)*0.0128;
  airplane.mesh.position.y += (targetY-airplane.mesh.position.y)*0.1;

}

function resetGame(){

}

function init(){
  fieldDistance = document.getElementById("distValue");

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
