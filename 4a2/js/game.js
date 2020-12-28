var Colors = {
    red:0xf25346,
    white:0xd8d0d1,
    brown:0x59332e,
    brownDark:0x23190f,
    pink:0xF5986E,
    yellow:0xf4ce93,
    blue:0x68c3c0,
};

var deltaTime = 0;
var newTime = new Date().getTime();
var oldTime = new Date().getTime();
var ennemiesPool = [];
var particlesPool = [];

const distanceForEnnemiesSpawn = 50;
const ennemiesSpeed = .6;
const ennemyValue = 10;
const ennemyDistanceTolerance = 10;
const distanceForCoinsSpawn = 100;
const coinDistanceTolerance = 15;
const coinValue = 3;
const coinsSpeed = .5;
const planeDefaultHeight = 100;
const planeAmpHeight = 80;
const planeAmpWidth = 75;
const planeMoveSensivity = 0.005;
const planeRotXSensivity = 0.0008;
const planeRotZSensivity = 0.0004;
const ratioSpeedDistance = 50;
const ratioSpeedEnergy = 3;
const distanceForLevelUpdate = 1000;
const seaRadius = 600;

function resetGame(){
  game = {
    speed:0,
    baseSpeed:.00035,
    distance:0,
    energy:100,
    level:1,
    levelLastUpdate:0,
    planeFallSpeed:.001,
    planeSpeed:0,
    planeCollisionDisplacementX:0,
    planeCollisionSpeedX:0,
    planeCollisionDisplacementY:0,
    planeCollisionSpeedY:0,
    coinLastSpawn:0,
    ennemyLastSpawn:0,
    status : "playing",
  };
  fieldLevel.innerHTML = Math.floor(game.level);
}

function handleMouseUp(event){
  if (game.status == "waitingReplay"){
    resetGame();
    replayMessage.style.display="none";
  }
}

function handleTouchEnd(event){
  if (game.status == "waitingReplay"){
    resetGame();
    replayMessage.style.display="none";
  }
}

var sea;
var airplane;

function createPlane(){
  airplane = new AirPlane();
  airplane.mesh.scale.set(.25,.25,.25);
  airplane.mesh.position.y = planeDefaultHeight;
  scene.add(airplane.mesh);
}

function createSea(){
  sea = new Sea();
  sea.mesh.position.y = -seaRadius;
  scene.add(sea.mesh);
}

function createSky(){
  sky = new Sky();
  sky.mesh.position.y = -seaRadius;
  scene.add(sky.mesh);
}

function createCoins(){
  coinsHolder = new CoinsHolder(20);
  scene.add(coinsHolder.mesh)
}

function createEnnemies(){
  for (var i=0; i<10; i++){
    var ennemy = new Ennemy();
    ennemiesPool.push(ennemy);
  }
  ennemiesHolder = new EnnemiesHolder();
  scene.add(ennemiesHolder.mesh)
}

function createParticles(){
  for (var i=0; i<10; i++){
    var particle = new Particle();
    particlesPool.push(particle);
  }
  particlesHolder = new ParticlesHolder();
  scene.add(particlesHolder.mesh)
}

function loop(){
  newTime = new Date().getTime();
  deltaTime = newTime-oldTime;
  oldTime = newTime;

  if (game.status=="playing"){
    // Add energy coins every 100m;
    if (Math.floor(game.distance) % distanceForCoinsSpawn == 0 && Math.floor(game.distance) > game.coinLastSpawn){
      game.coinLastSpawn = Math.floor(game.distance);
      coinsHolder.spawnCoins();
    }

    if (Math.floor(game.distance) % distanceForEnnemiesSpawn == 0 && Math.floor(game.distance) > game.ennemyLastSpawn){
      game.ennemyLastSpawn = Math.floor(game.distance);
      ennemiesHolder.spawnEnnemies();
    }
    // tang lv
    if (Math.floor(game.distance)% distanceForLevelUpdate == 0 && Math.floor(game.distance) > game.levelLastUpdate){
      game.levelLastUpdate = Math.floor(game.distance);
      game.level++;
      fieldLevel.innerHTML = Math.floor(game.level);

      $('#question-display').trigger('click');
      game.status = "waitingAnswer";
    }
    updatePlane();
    updateDistance();
    updateEnergy();
    game.baseSpeed += (.00035 - game.baseSpeed) * deltaTime * 0.02;
    game.speed = game.baseSpeed * game.planeSpeed;

    airplane.propeller.rotation.x +=.2 + game.planeSpeed * deltaTime*.005;
  } else if(game.status=="gameover"){
    game.speed *= .99;
    airplane.mesh.rotation.z += (-Math.PI/2 - airplane.mesh.rotation.z)*.0002*deltaTime;
    airplane.mesh.rotation.x += 0.0003*deltaTime;
    game.planeFallSpeed *= 1.05;
    airplane.mesh.position.y -= game.planeFallSpeed*deltaTime;

    if (airplane.mesh.position.y <-200){
      replayMessage.style.display="block";
      game.status = "waitingReplay";
    }
  } else if (game.status=="waitingAnswer"){
    requestAnimationFrame(loop);
    return;
  }

  sea.mesh.rotation.z += game.speed*deltaTime;
  if (sea.mesh.rotation.z > 2*Math.PI)  sea.mesh.rotation.z -= 2*Math.PI;

  coinsHolder.rotateCoins();
  ennemiesHolder.rotateEnnemies();

  sky.moveClouds();
  sea.moveWaves();

  renderer.render(scene, camera);
  requestAnimationFrame(loop);
}

function updateDistance(){
  game.distance += game.speed*deltaTime * ratioSpeedDistance;
  fieldDistance.innerHTML = Math.floor(game.distance);
  var d = 502*(1-(game.distance % distanceForLevelUpdate) / distanceForLevelUpdate);
  levelCircle.setAttribute("stroke-dashoffset", d);
}

function updateEnergy(){
  game.energy -= game.speed*deltaTime * ratioSpeedEnergy;
  game.energy = Math.max(0, game.energy);
  energyBar.style.right = (100-game.energy)+"%";
  energyBar.style.backgroundColor = (game.energy<50)? "#f25346" : "#68c3c0";

  if (game.energy<30){
    energyBar.style.animationName = "blinking";
  }else{
    energyBar.style.animationName = "none";
  }

  if (game.energy <1){
    game.status = "gameover";
  }
}

function addEnergy(){
  game.energy += coinValue;
  game.energy = Math.min(game.energy, 100);
}

function removeEnergy(){
  game.energy -= ennemyValue;
  game.energy = Math.max(0, game.energy);
}

function updatePlane(){
  game.planeSpeed = 1.4;
  var targetY = normalize(mousePos.y,-.75,.75,planeDefaultHeight- planeAmpHeight, planeDefaultHeight+planeAmpHeight);
  var targetX = normalize(mousePos.x,-1,1,- planeAmpWidth *.7, -planeAmpWidth);

  game.planeCollisionDisplacementX += game.planeCollisionSpeedX;
  targetX += game.planeCollisionDisplacementX;

  game.planeCollisionDisplacementY += game.planeCollisionSpeedY;
  targetY += game.planeCollisionDisplacementY;

  airplane.mesh.position.y += (targetY-airplane.mesh.position.y)*deltaTime* planeMoveSensivity;
  airplane.mesh.position.x += (targetX-airplane.mesh.position.x)*deltaTime* planeMoveSensivity;

  airplane.mesh.rotation.z = (targetY-airplane.mesh.position.y)*deltaTime* planeRotXSensivity;
  airplane.mesh.rotation.x = (airplane.mesh.position.y-targetY)*deltaTime* planeRotZSensivity;
  camera.fov = normalize(mousePos.x,-1,1,40, 80);
  camera.updateProjectionMatrix ()
  camera.position.y += (airplane.mesh.position.y - camera.position.y)*deltaTime* 0.002;

  game.planeCollisionSpeedX += (0-game.planeCollisionSpeedX)*deltaTime * 0.03;
  game.planeCollisionDisplacementX += (0-game.planeCollisionDisplacementX)*deltaTime *0.01;
  game.planeCollisionSpeedY += (0-game.planeCollisionSpeedY)*deltaTime * 0.03;
  game.planeCollisionDisplacementY += (0-game.planeCollisionDisplacementY)*deltaTime *0.01;
}

var fieldDistance, energyBar, replayMessage, fieldLevel, levelCircle;
function init(event){
  fieldDistance = document.getElementById("distValue");
  energyBar = document.getElementById("energyBar");
  replayMessage = document.getElementById("replayMessage");
  fieldLevel = document.getElementById("levelValue");
  levelCircle = document.getElementById("levelCircleStroke");

  resetGame();
  createScene();

  createLights();
  createPlane();
  createSea();
  createSky();
  createCoins();
  createEnnemies();
  createParticles();

  document.addEventListener('mousemove', handleMouseMove, false);
  document.addEventListener('touchmove', handleTouchMove, false);
  document.addEventListener('mouseup', handleMouseUp, false);
  document.addEventListener('touchend', handleTouchEnd, false);

  loop();
}
window.addEventListener('load', init, false);
