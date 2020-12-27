const AIRPLANE_CABIN_COLOR       = Colors.red;              // Thân máy bay
const AIRPLANE_ENGINE_COLOR      = Colors.white;            // Đầu máy bay
const AIRPLANE_TAIL_COLOR        = Colors.red;              // Đuôi máy bay
const AIRPLANE_WING_COLOR        = Colors.red;              // Cánh máy bay
const AIRPLANE_PROPELLER_COLOR   = Colors.brown;            // Cánh quạt máy bay
const AIRPLANE_WHEEL_TIRE_COLOR  = Colors.brownDark;        // Lốp máy bay
const AIRPLANE_WHEEL_AXIS_COLOR  = Colors.brown;            // Bánh xe máy bay

/**
 * Vẽ máy bay
 */
var AirPlane = function(){
    this.mesh = new THREE.Object3D();
    this.mesh.name = "airPlane";

    // Cabin - Thân máy bay
    var geomCabin = new THREE.BoxGeometry(80,50,50,1,1,1);
    var matCabin = new THREE.MeshPhongMaterial({color:AIRPLANE_CABIN_COLOR, shading:THREE.FlatShading});
    geomCabin.vertices[4].y-=10;
    geomCabin.vertices[4].z+=20;
    geomCabin.vertices[5].y-=10;
    geomCabin.vertices[5].z-=20;
    geomCabin.vertices[6].y+=30;
    geomCabin.vertices[6].z+=20;
    geomCabin.vertices[7].y+=30;
    geomCabin.vertices[7].z-=20;

    var cabin = new THREE.Mesh(geomCabin, matCabin);
    cabin.castShadow = true;
    cabin.receiveShadow = true;
    this.mesh.add(cabin);

    var wheelProtecGeom = new THREE.BoxGeometry(30,15,10,1,1,1);
    var wheelProtecMat = new THREE.MeshPhongMaterial({color:AIRPLANE_CABIN_COLOR, shading:THREE.FlatShading});
    var wheelProtecR = new THREE.Mesh(wheelProtecGeom,wheelProtecMat);
    wheelProtecR.position.set(25,-20,25);
    this.mesh.add(wheelProtecR);
    var wheelProtecL = wheelProtecR.clone();
    wheelProtecL.position.z = -wheelProtecR.position.z ;
    this.mesh.add(wheelProtecL);

    // Engine - Đầu máy bay
    var geomEngine = new THREE.BoxGeometry(20,50,50,1,1,1);
    var matEngine = new THREE.MeshPhongMaterial({color:AIRPLANE_ENGINE_COLOR, shading:THREE.FlatShading});
    var engine = new THREE.Mesh(geomEngine, matEngine);
    engine.position.x = 50;
    engine.castShadow = true;
    engine.receiveShadow = true;
    this.mesh.add(engine);

    // Tail Plane - Đuôi máy bay
    var geomTailPlane = new THREE.BoxGeometry(15,20,5,1,1,1);
    var matTailPlane = new THREE.MeshPhongMaterial({color:AIRPLANE_TAIL_COLOR, shading:THREE.FlatShading});
    var tailPlane = new THREE.Mesh(geomTailPlane, matTailPlane);
    tailPlane.position.set(-40,20,0);
    tailPlane.castShadow = true;
    tailPlane.receiveShadow = true;
    this.mesh.add(tailPlane);

    // Wings - Cánh máy bay
    var geomSideWing = new THREE.BoxGeometry(30,5,120,1,1,1);
    var matSideWing = new THREE.MeshPhongMaterial({color:AIRPLANE_WING_COLOR, shading:THREE.FlatShading});
    var sideWing = new THREE.Mesh(geomSideWing, matSideWing);
    sideWing.position.set(0,15,0);
    sideWing.castShadow = true;
    sideWing.receiveShadow = true;
    this.mesh.add(sideWing);

    var geomPropeller = new THREE.BoxGeometry(20,10,10,1,1,1);
    geomPropeller.vertices[4].y-=5;
    geomPropeller.vertices[4].z+=5;
    geomPropeller.vertices[5].y-=5;
    geomPropeller.vertices[5].z-=5;
    geomPropeller.vertices[6].y+=5;
    geomPropeller.vertices[6].z+=5;
    geomPropeller.vertices[7].y+=5;
    geomPropeller.vertices[7].z-=5;
    var matPropeller = new THREE.MeshPhongMaterial({color:AIRPLANE_PROPELLER_COLOR, shading:THREE.FlatShading});
    this.propeller = new THREE.Mesh(geomPropeller, matPropeller);

    this.propeller.castShadow = true;
    this.propeller.receiveShadow = true;

    var geomBlade = new THREE.BoxGeometry(1,80,10,1,1,1);
    var matBlade = new THREE.MeshPhongMaterial({color:AIRPLANE_PROPELLER_COLOR, shading:THREE.FlatShading});
    var blade1 = new THREE.Mesh(geomBlade, matBlade);
    blade1.position.set(8,0,0);
    blade1.castShadow = true;
    blade1.receiveShadow = true;
    var blade2 = blade1.clone();
    blade2.rotation.x = Math.PI/2;
    blade2.castShadow = true;
    blade2.receiveShadow = true;

    this.propeller.add(blade1);
    this.propeller.add(blade2);
    this.propeller.position.set(60,0,0);
    this.mesh.add(this.propeller);

    // 2 Bánh xe trước
    var wheelTireGeom = new THREE.BoxGeometry(24,24,4);
    var wheelTireMat = new THREE.MeshPhongMaterial({color:AIRPLANE_WHEEL_TIRE_COLOR, shading:THREE.FlatShading});
    var wheelTireR = new THREE.Mesh(wheelTireGeom,wheelTireMat);
    wheelTireR.position.set(25,-28,25);

    var wheelAxisGeom = new THREE.BoxGeometry(10,10,6);
    var wheelAxisMat = new THREE.MeshPhongMaterial({color:AIRPLANE_WHEEL_AXIS_COLOR, shading:THREE.FlatShading});
    var wheelAxis = new THREE.Mesh(wheelAxisGeom,wheelAxisMat);

    wheelTireR.add(wheelAxis);
    this.mesh.add(wheelTireR);

    var wheelTireL = wheelTireR.clone();
    wheelTireL.position.z = -wheelTireR.position.z;
    this.mesh.add(wheelTireL);

    // Bánh sau
    var wheelTireB = wheelTireR.clone();
    wheelTireB.scale.set(.5,.5,.5);
    wheelTireB.position.set(-35,-5,0);
    this.mesh.add(wheelTireB);

    this.mesh.castShadow = true;
    this.mesh.receiveShadow = true;
};