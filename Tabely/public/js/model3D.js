import * as THREE from "https://cdn.skypack.dev/three@0.129.0/build/three.module.js";
import { OrbitControls } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js";
import { GLTFLoader } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js";

const scene = new THREE.Scene();

const container = document.getElementById("container3D");
const width = container.clientWidth;
const height = container.clientHeight;

const camera = new THREE.PerspectiveCamera(50, width / height, 0.1, 1000);
camera.position.set(-2, 1.25, 3);

const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
renderer.setSize(width, height);
renderer.setPixelRatio(window.devicePixelRatio);
container.appendChild(renderer.domElement);

const topLight = new THREE.DirectionalLight(0xffffff, 1);
topLight.position.set(5, 5, 5);
scene.add(topLight);

scene.add(new THREE.AmbientLight(0xffffff, 0.6));

const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;

let desktop, frame;
let legTopL, legTopR;
let legMidL, legMidR;

let currentHeight = 0;
let targetHeight = 0;

let DESK_OFFSET = 2;
let BEAM_OFFSET = 0.8;
let TOP_OFFSET = 0;
let MID_OFFSET = 0.2;

new GLTFLoader().load("/models/table.glb", glb => {
    const root = glb.scene;
    root.scale.set(1, 1, 1);
    scene.add(root);

    root.traverse(child => {
        if (child.type !== "Mesh") return;

        if (child.name === "desktop") desktop = child;
        if (child.name === "beam_1") frame = child;

        if (child.name === "leg_topL") legTopL = child;
        if (child.name === "leg_topR_1") legTopR = child;

        if (child.name === "leg_middleL") legMidL = child;
        if (child.name === "leg_middleR") legMidR = child;

    });

    desktop.position.y += DESK_OFFSET;
    frame.position.y += BEAM_OFFSET;

    legTopL.position.y += TOP_OFFSET;
    legTopR.position.y += TOP_OFFSET;

    legMidL.position.y += MID_OFFSET;
    legMidR.position.y += MID_OFFSET;

    const defaultHeight = Number(document.getElementById("height").value || 0) / 100;
    currentHeight = defaultHeight;
    targetHeight = defaultHeight;
    applyHeightInstant(currentHeight);
});

function applyHeightInstant(h) {
    const extTop = h;
    const extMid = h * 0.5;

    if (desktop) desktop.position.y = DESK_OFFSET + h;
    if (frame) frame.position.y = BEAM_OFFSET + h;

    if (legTopL) legTopL.position.y = TOP_OFFSET + extTop;
    if (legTopR) legTopR.position.y = TOP_OFFSET + extTop;

    if (legMidL) legMidL.position.y = MID_OFFSET + extMid;
    if (legMidR) legMidR.position.y = MID_OFFSET + extMid;
}

function setTableHeight(value) {
    targetHeight = value / 100;
}

document.getElementById("increase").addEventListener("click", () => {
    const input = document.getElementById("height");
    input.value = Number(input.value);
    setTableHeight(Number(input.value));
});

document.getElementById("height").addEventListener("input", e => {
    setTableHeight(Number(e.target.value));
});

document.getElementById("decrease").addEventListener("click", () => {
    const input = document.getElementById("height");
    input.value = Number(input.value);
    setTableHeight(Number(input.value));
});

window.addEventListener("resize", () => {
    const w = container.clientWidth;
    const h = container.clientHeight;
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    renderer.setSize(w, h);
    console.log(desktop.position.y)
});

function animate() {
    requestAnimationFrame(animate);

    currentHeight += (targetHeight - currentHeight) * 0.1;
    applyHeightInstant(currentHeight);

    controls.update();
    renderer.render(scene, camera);
}

animate();
