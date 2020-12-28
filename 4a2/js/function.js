const QUESTION_LIST = [
  {
    question : 'Which of the following country has largest population 1?',
    answer : [
      {content : 'Which', result : '1'},
      {content : 'Which', result : '1'},
      {content : 'Which', result : '1'},
      {content : 'Which', result : '1'},
    ]
  },
  {
    question : 'Which of the following country has largest population 3?',
    answer : [
      {content : 'Which', result : '1'},
      {content : 'Which', result : '1'},
      {content : 'Which', result : '1'},
      {content : 'Which', result : '1'},
    ]
  },
  {
    question : 'Which of the following country has largest population 4?',
    answer : [
      {content : 'Which', result : '1'},
      {content : 'Which', result : '1'},
      {content : 'Which', result : '1'},
      {content : 'Which', result : '1'},
    ]
  },
];
const QUESTION_NUMBER = QUESTION_LIST.length;

let HEIGHT, WIDTH,
    mousePos = { x: 0, y: 0 };
let scene, camera, renderer;
let game;

function random (min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function handleWindowResize() {
  HEIGHT = window.innerHeight;
  WIDTH = window.innerWidth;
  renderer.setSize(WIDTH, HEIGHT);
  camera.aspect = WIDTH / HEIGHT;
  camera.updateProjectionMatrix();
}

function handleMouseMove(event) {
  var tx = -1 + (event.clientX / WIDTH)*2;
  var ty = 1 - (event.clientY / HEIGHT)*2;
  mousePos = {x:tx, y:ty};
}

function handleTouchMove(event) {
  event.preventDefault();
  var tx = -1 + (event.touches[0].pageX / WIDTH)*2;
  var ty = 1 - (event.touches[0].pageY / HEIGHT)*2;
  mousePos = {x:tx, y:ty};
}

function createLights() {
  let hemisphereLight = new THREE.HemisphereLight(0xaaaaaa,0x000000, .9)
  let ambientLight = new THREE.AmbientLight(0xdc8874, .5);
  let shadowLight = new THREE.DirectionalLight(0xffffff, .9);
  shadowLight.position.set(150, 350, 350);
  shadowLight.castShadow = true;
  shadowLight.shadow.camera.left = -400;
  shadowLight.shadow.camera.right = 400;
  shadowLight.shadow.camera.top = 400;
  shadowLight.shadow.camera.bottom = -400;
  shadowLight.shadow.camera.near = 1;
  shadowLight.shadow.camera.far = 1000;
  shadowLight.shadow.mapSize.width = 4096;
  shadowLight.shadow.mapSize.height = 4096;
  scene.add(hemisphereLight);
  scene.add(shadowLight);
  scene.add(ambientLight);
}

function createScene() {
  HEIGHT = window.innerHeight;
  WIDTH = window.innerWidth;

  scene = new THREE.Scene();
  camera = new THREE.PerspectiveCamera(50, WIDTH / HEIGHT, .1, 10000);
  scene.fog = new THREE.Fog(0xf7d9aa, 100,950);
  camera.position.x = 0;
  camera.position.z = 200;
  camera.position.y = planeDefaultHeight;
  renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
  renderer.setSize(WIDTH, HEIGHT);
  renderer.shadowMap.enabled = true;
  document.getElementById('world').appendChild(renderer.domElement);
  window.addEventListener('resize', handleWindowResize, false);
}

function normalize(v,vmin,vmax,tmin, tmax){
  var nv = Math.max(Math.min(v,vmax), vmin);
  var dv = vmax-vmin;
  var pc = (nv-vmin)/dv;
  var dt = tmax-tmin;
  var tv = tmin + (pc*dt);
  return tv;
}