const CLOUD_ROTATE    = game.speed;      // Tốc độ quay của mây
const CLOUD_NUMBER    = 20;              // Số chùm mây
const CLOUD_COLOR     = Colors.white;    // Màu chùm mây
const CLOUD_FNUMBER   = 3                // Số đám mây trong mỗi chùm mây (từ)
const CLOUD_TNUMBER   = 6                // Số đám mây trong mỗi chùm mây (đến)

/**
 * Vẽ bầu trời
 */
Sky = function(){
    this.mesh = new THREE.Object3D();
    this.nClouds = CLOUD_NUMBER;
    this.clouds = [];
    var stepAngle = Math.PI*2 / this.nClouds;
    for(var i=0; i<this.nClouds; i++){
        var c = new Cloud();
        this.clouds.push(c);
        var a = stepAngle*i;
        var h = 750 + Math.random()*200;
        c.mesh.position.y = Math.sin(a)*h;
        c.mesh.position.x = Math.cos(a)*h;
        c.mesh.position.z = -400-Math.random()*400;
        c.mesh.rotation.z = a + Math.PI/2;
        var s = 1+Math.random()*2;
        c.mesh.scale.set(s,s,s);
        this.mesh.add(c.mesh);
    }
}

/**
 * Vẽ một chùm mây
 */
Cloud = function(){
    this.mesh = new THREE.Object3D();
    this.mesh.name = "cloud";
    var geom = new THREE.CubeGeometry(20,20,20); // Mây hình khối lập phương
    var mat = new THREE.MeshPhongMaterial({
        color: CLOUD_COLOR
    });

    var nBlocs = random(CLOUD_FNUMBER, CLOUD_TNUMBER);
    for (var i=0; i<nBlocs; i++ ){
        var m = new THREE.Mesh(geom.clone(), mat);
        m.position.x = i*15;
        m.position.y = Math.random()*10;
        m.position.z = Math.random()*10;
        m.rotation.z = Math.random()*Math.PI*2;
        m.rotation.y = Math.random()*Math.PI*2;
        var s = .1 + Math.random()*.9;
        m.scale.set(s,s,s);
        m.castShadow = true;
        m.receiveShadow = true;
        this.mesh.add(m);
    }
}

/**
 * Xoay các đám mây trong một chùm mây
 */
Cloud.prototype.rotate = function(){
    var l = this.mesh.children.length;
    for(var i=0; i<l; i++){
        var m = this.mesh.children[i];
        m.rotation.z+= Math.random()*.005*(i+1);
        m.rotation.y+= Math.random()*.002*(i+1);
    }
}

/**
 * Tạo bầu trời
 * @public
 */
function createSky(){
    sky = new Sky();
    sky.mesh.position.y = -600;
    scene.add(sky.mesh);
}

/**
 * Xoay tất cả chùm mây trên bầu trời
 * @public
 */
Sky.prototype.moveClouds = function(){
    for(var i=0; i<this.nClouds; i++){
        var c = this.clouds[i];
        c.rotate();
    }
    this.mesh.rotation.z += CLOUD_ROTATE;
}