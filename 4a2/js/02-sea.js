
Sea = function(){
    var geom = new THREE.CylinderGeometry(seaRadius,seaRadius,800,40,10);
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
            amp: 5 + Math.random()*(20 - 5),
            speed: 0.002
        });
    };
    var mat = new THREE.MeshPhongMaterial({
        color:Colors.blue,
        transparent:true,
        opacity:.8,
        shading:THREE.FlatShading,

    });

    this.mesh = new THREE.Mesh(geom, mat);
    this.mesh.name = "waves";
    this.mesh.receiveShadow = true;

}

Sea.prototype.moveWaves = function (){
    var verts = this.mesh.geometry.vertices;
    var l = verts.length;
    for (var i=0; i<l; i++){
        var v = verts[i];
        var vprops = this.waves[i];
        v.x =  vprops.x + Math.cos(vprops.ang)*vprops.amp;
        v.y = vprops.y + Math.sin(vprops.ang)*vprops.amp;
        vprops.ang += vprops.speed*deltaTime;
        this.mesh.geometry.verticesNeedUpdate=true;
    }
}