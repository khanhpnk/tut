var Colors = {
    red:0xf25346,
    white:0xd8d0d1,
    pink:0xF5986E,
    brown:0x59332e,
    brownDark:0x23190f,
    blue:0x68c3c0,
};

var scene, camera, renderer;
var HEIGHT, WIDTH;
var game;
var sea, sky, airplane;

var mousePos = { x: 0, y: 0 };

function loop(){
  updatePlane();
  updateCameraFov();
  sea.moveWaves();
  sky.moveClouds();
  renderer.render(scene, camera);
  requestAnimationFrame(loop);
}

function updatePlane(){
  var targetY = normalize(mousePos.y,-.75,.75,25, 175);
  airplane.mesh.position.y += (targetY-airplane.mesh.position.y)*0.1;
  airplane.mesh.rotation.z = (targetY-airplane.mesh.position.y)*0.0128;
  airplane.mesh.rotation.x = (airplane.mesh.position.y-targetY)*0.0064;
  airplane.propeller.rotation.x += 0.3;
}

function updateCameraFov(){
  camera.fov = normalize(mousePos.x,-1,1,40, 80);
  camera.updateProjectionMatrix();
}

function resetGame(){
  game = {
    speed: .01
  };
}

function init(){
  document.addEventListener('mousemove', handleMouseMove, false);
  resetGame();
  createScene();
  createLights();
  createPlane();
  createSea();
  createSky();
  loop();
}
window.addEventListener('load', init, false);
