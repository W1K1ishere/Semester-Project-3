import * as THREE from "https://cdn.skypack.dev/three@0.129.0/build/three.module.js";
import { OrbitControls } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js";
import { FBXLoader } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/FBXLoader.js";

const scene = new THREE.Scene();

const container = document.getElementById("container3D");
const width = container.clientWidth;
const height = container.clientHeight;

const camera = new THREE.PerspectiveCamera(50, width / height, 0.1, 1000);

let object = null;
let desktop = null;
let legs = [];

const fbxLoader = new FBXLoader();

fbxLoader.load(`/models/table.fbx`, (fbx) => {
    object = fbx;
    object.scale.set(0.01, 0.01, 0.01);

    object.traverse((child) => {
        if (child.name === "desktop") desktop = child;
        if (child.isBone && child.name === "leg_topR") {
            legs.push(child);
        }
        if (child.isBone && child.name === "leg_topL") {
            legs.push(child);
        }
    });
    scene.add(object);

    const defaultHeight = Number(document.getElementById("height").value);
    desktop.position.y = defaultHeight / 100;
    legs.forEach(leg => {
        leg.position.y = defaultHeight / 100;
    });

});

const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
renderer.setSize(width, height);
renderer.setPixelRatio(window.devicePixelRatio);
container.appendChild(renderer.domElement);

camera.position.set(-2, 1.25, 3);

const topLight = new THREE.DirectionalLight(0xffffff, 1);
topLight.position.set(500, 500, 500);
scene.add(topLight);

const ambientLight = new THREE.AmbientLight(0x333333, 5);
scene.add(ambientLight);

const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;


window.addEventListener("resize", () => {
    const newWidth = container.clientWidth;
    const newHeight = container.clientHeight;
    camera.aspect = newWidth / newHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(newWidth, newHeight);
});

function setTableHeight(value) {
    if (!desktop) return;
    const height = value / 100;
    desktop.position.y = height ;
    legs.forEach(leg => {
        leg.position.y = height;
    });
    const v = new THREE.Vector3();

    desktop.getWorldPosition(v);
    console.log("Desktop WORLD Y:", v.y);

    legs.forEach((leg, i) => {
        leg.getWorldPosition(v);
        console.log(`Leg ${i} WORLD Y:`, v.y);
    });
}

document.getElementById("increase").addEventListener("click", (e) => {
    const heightInput = document.getElementById("height");
    heightInput.value = Number(heightInput.value);
    setTableHeight(Number(heightInput.value));
});

document.getElementById("height").addEventListener("input", (e) => {
    setTableHeight(Number(e.target.value));
});

document.getElementById("decrease").addEventListener("click", (e) => {
    const heightInput = document.getElementById("height");
    heightInput.value = Number(heightInput.value);
    setTableHeight(Number(heightInput.value));
});

function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}

animate();
