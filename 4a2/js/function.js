/*

Các em thân mến, hiện nay virus Corona đang tạo ra một dịch bệnh trên "toàn cầu". Ở Việt Nam, nó cũng đang hoành hành và khiến cho nhiều người dân mắc bệnh. Chính vì vậy, hiện nay,  tất cả người dân đang ở trong thời kì "phòng tránh" bệnh bằng nhiều phương pháp. Trong đó, tại TPHCM và các tỉnh thành khác, để có thể phòng dịch thì giáo viên và học sinh đều được nghỉ để có thể bảo vệ mình khỏi nguy cơ mắc bệnh.
Nhiệm vụ ở nhà của mọi người, nhất là học sinh là phải tìm hiểu những thông tin, những con số "thực" về dịch bệnh dể có thể nắm vững về nó, có đủ kiến thức để phòng tránh dịch bệnh trong thời điểm hiện tại. Chính vì vậy, Thầy đã quyết định lập ra một bài tập trắc nghiệm có liên quan đến dịch bệnh để có thể:
(1) Về kiến thức:
-  Trình bày được một số thông tin llên quan đến virus Corona và cách phòng chống;
- Nắm được những số liệu cơ bản về dịch bệnh tại Việt nam và trên Thế giới.
(2) Về kĩ năng:
- Kỹ năng phòng chống dịch bệnh .
(3) Thái độ:
- Có ý thức bảo vệ sức khỏe của mình và cộng đồng;
- Tìm hiểu và tuyên truyền với mọi người những thông tin chính xác, đáng tin cậy về dịch bệnh.
Thầy mong rằng các em có thể tìm hiểu những thông tin đáng tin cậy và hoàn thành bài tập này thậ tốt nhé.
THẦY ĐON.
 */

const QUESTION_LIST = [
  {
    question : 'Rửa tay như nào sẽ đảm bảo đã rửa tay sạch?',
    answer : [
      {content : 'A. Miễn rửa tay với nước và xà phòng là được, bất kể trong bao lâu', result : '0'},
      {content : 'B. Theo quy trình rửa tay thường quy 6 bước khuyến cáo bởi Bộ Y Tế để không bỏ sót bất cứ vị trí nào trên tay', result : '1'},
      {content : 'C. Miễn có rửa tay là được', result : '0'},
    ]
  },
  {
    question : 'Vị trí nào dễ bị bỏ qua khi rửa tay?',
    answer : [
      {content : 'Giữa các đường chỉ tay', result : '0'},
      {content : 'Kẽ ngón tay', result : '1'},
      {content : 'Giữa móng và ngón tay', result : '0'},
    ]
  },
  {
    question : 'Đeo nhiều khẩu trang cùng lúc có an toàn hơn?',
    answer : [
      {content : 'Không', result : '1'},
      {content : 'Có', result : '0'},
    ]
  },
  {
    question : 'Sau khi sử dụng, để đảm bảo an toàn, không được xử lý khẩu trang theo cách nào?',
    answer : [
      {content : 'Rửa tay sau khi vứt bỏ khẩu trang để phòng bệnh', result : '0'},
      {content : 'Có thể dùng tay cầm trực tiếp vào bề mặt khẩu trang để tháo ra.', result : '1'},
      {content : 'Chỉ cầm vào dây quai đeo qua tai để tháo.', result : '0'},
      {content : 'Với khẩu trang y tế dùng một lần, vứt bỏ vào thùng rác có nắp đậy.', result : '0'},
    ]
  },
  {
    question : 'Bắt tay với người đang có triệu chứng nghi nhiễm Vi rút COVID-19 có nguy cơ lây nhiễm virus corona không, nếu tôi đã đeo khẩu trang?',
    answer : [
      {content : 'Chắc chắn không', result : '0'},
      {content : 'Có nguy cơ', result : '1'},
      {content : 'Chắc chắn có', result : '0'},
    ]
  },
  {
    question : 'Nếu đi trên xe (ô tô, xe khách, xe bus...) đã từng hoặc đang chở người bị nhiễm virus Corona thì tôi có nguy cơ bị lây nhiễm không?',
    answer : [
      {content : 'Chắc chắn do virus lây nhiễm không lây qua đường không khí', result : '0'},
      {content : 'Có nguy cơ', result : '1'},
      {content : 'Không', result : '0'},
    ]
  },
  {
    question : 'Độ tuổi nào dễ mắc nhất?',
    answer : [
      {content : 'Mọi lứa tuổi đều có thể bị mắc virus Corona mới', result : '1'},
      {content : 'Trẻ nhỏ dễ mắc virus Corona mới nhất', result : '0'},
      {content : 'Người cao tuổi dễ mắc virus Corona mới nhất', result : '0'},
    ]
  },
  {
    question : 'Có nên tiếp tục mở máy lạnh (điều hòa không khí) trong lớp học vào thời điểm đang có dịch?',
    answer : [
      {content : 'Mở điều hoà bình thường', result : '0'},
      {content : 'Không mở điều hoà', result : '0'},
      {content : 'Hạn chế mở điều hoà', result : '1'},
    ]
  },
  {
    question : 'Ăn tỏi có giúp tôi tránh bị lây nhiễm virus corona không?',
    answer : [
      {content : 'Không', result : '0'},
      {content : ' Chưa có bằng chứng cho thấy có tác dụng', result : '1'},
      {content : 'Có', result : '0'},
    ]
  },
  {
    question : 'Câu 1: Triệu chứng khi nhiễm Virus Corona là gì?',
    answer : [
      {content : 'A. Đau nhức đầu, khó chịu', result : '0'},
      {content : 'B. Sốt cao trên 38 độ C', result : '0'},
      {content : 'C. Ho hoặc đau họng', result : '0'},
      {content : 'D. Chảy nước mũi, Khó thở', result : '0'},
      {content : 'E. Đau mỏi cơ', result : '0'},
      {content : 'F. Tất cả', result : '1'},
    ]
  },
  {
    question : 'Nếu tôi có triệu chứng ho nặng, nhưng sau 5 ngày không thấy sốt, có nghĩa là tôi không bị nhiễm virus đúng không?',
    answer : [
      {content : 'Chắc chắn là không an toàn', result : '0'},
      {content : 'Chắc chắn là an toàn', result : '0'},
      {content : 'Vẫn nên đi khám, xét nghiệm để kiểm tra', result : '1'},
    ]
  },
];
const QUESTION_NUMBER = QUESTION_LIST.length;
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

/*********************************************************************/
let HEIGHT, WIDTH,
    mousePos = { x: 0, y: 0 };
let scene, camera, renderer;
let game;
var sea, airplane;


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