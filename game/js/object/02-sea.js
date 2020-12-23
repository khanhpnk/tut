const SEA_COLOR     = Colors.blue;      // Màu sóng biển
const SEA_ROTATE    = game.speed*2;     // Tốc độ sóng biển

/**
 * Vẽ biển
 * @constructor
 */
Sea = function(){
    var geom = new THREE.CylinderGeometry(600,600,800,40,10);
    geom.applyMatrix(new THREE.Matrix4().makeRotationX(-Math.PI/2));
    geom.mergeVertices();
    var l = geom.vertices.length;

    this.waves = [];
    for (var i=0;i<l;i++){
        var v = geom.vertices[i];
        this.waves.push({y:v.y,
            x:v.x,
            z:v.z,
            ang:Math.random()*Math.PI*2,
            amp: 5 + Math.random()*15, // Độ nhấp nhô của sóng
            speed: SEA_ROTATE
        });
    };
    var mat = new THREE.MeshPhongMaterial({
        color: SEA_COLOR,
        transparent:true,
        opacity:.9,
        shading:THREE.FlatShading,
    });

    this.mesh = new THREE.Mesh(geom, mat);
    this.mesh.receiveShadow = true;
}

/**
 * Di chuyển sóng biển nhấp nhô
 * @public
 */
Sea.prototype.moveWaves = function (){
    var verts = this.mesh.geometry.vertices;
    var l = verts.length;
    for (var i=0; i<l; i++){
        var v = verts[i];
        var vprops = this.waves[i];
        v.x =  vprops.x + Math.cos(vprops.ang)*vprops.amp;
        v.y = vprops.y + Math.sin(vprops.ang)*vprops.amp;
        vprops.ang += vprops.speed;
    }
    this.mesh.geometry.verticesNeedUpdate=true;
}

/**
 * Tạo biển
 * @public
 */
function createSea(){
    sea = new Sea();
    sea.mesh.position.y = -600;
    scene.add(sea.mesh);
}