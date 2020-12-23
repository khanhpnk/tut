var scene, camera, renderer;
var HEIGHT, WIDTH;
var sea, sky, airplane;
var mousePos = { x: 0, y: 0 };

function loop(){
  updatePlane();
  sea.moveWaves();
  sky.moveClouds();
  airplane.movePropeller();

  renderer.render(scene, camera);
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
