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
        var h = game.seaRadius + 150 + Math.random()*200;
        c.mesh.position.y = Math.sin(a)*h;
        c.mesh.position.x = Math.cos(a)*h;
        c.mesh.position.z = -300-Math.random()*500;
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
        this.mesh.add(m);
    }
}

Sky.prototype.moveClouds = function(){
    this.mesh.rotation.z += game.speed*deltaTime;
}
