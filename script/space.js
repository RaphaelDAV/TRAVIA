import * as THREE from 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.module.js';
import { GLTFLoader } from '../node_modules/.vite/deps/three_addons_loaders_GLTFLoader__js.js';

let scene, camera, renderer, starGeo, stars, falconMesh;


function init() {
    scene = new THREE.Scene();

    // Camera and renderer
    camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 1000);
    camera.position.set(0, 2, 10); 
    camera.lookAt(0, 1, 0); 

    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.querySelector('.main-screen').appendChild(renderer.domElement);

    // Light
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5); 
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8); 
    directionalLight.position.set(0, 10, 10);
    scene.add(directionalLight);


    // Load 3d model
    const loader = new GLTFLoader().setPath('assets/home/millennium_falcon/');
    loader.load('scene.gltf', (gltf) => {
        falconMesh = gltf.scene;

        falconMesh.traverse((child) => {
            if (child.isMesh) {
                child.castShadow = true;
                child.receiveShadow = true;
            }
        });
        scene.add(falconMesh);
    });

    // Stars
    starGeo = new THREE.BufferGeometry();
    const starVertices = [];
    const starVelocities = [];

    for (let i = 0; i < 6000; i++) {
        starVertices.push(
            Math.random() * 600 - 300, 
            Math.random() * 600 - 300, 
            Math.random() * 600 - 300  
        );
        starVelocities.push(0);
    }

    starGeo.setAttribute('position', new THREE.Float32BufferAttribute(starVertices, 3));
    starGeo.velocities = starVelocities;

    const sprite = new THREE.TextureLoader().load('assets/home/star.png');
    const starMaterial = new THREE.PointsMaterial({
        color: 0xffffff, 
        size: 0.7,
        map: sprite, 
        blending: THREE.AdditiveBlending,
    });

    stars = new THREE.Points(starGeo, starMaterial);
    scene.add(stars);

    animate();
}

// Responsive
function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
}

// Animation
function animate() {
    const positions = starGeo.attributes.position.array;
    const velocities = starGeo.velocities;

    for (let i = 0; i < positions.length; i += 3) {
        velocities[i / 3] += 0.002;  
        positions[i + 2] += velocities[i / 3];  

        if (positions[i + 2] > 300) {  
            positions[i + 2] = -300;
            velocities[i / 3] = 0;
        }
    }

    starGeo.attributes.position.needsUpdate = true;

    // Falcon animation
    if (falconMesh) {
        falconMesh.position.y = Math.sin(Date.now() * 0.01) * 0.01; 
        falconMesh.position.x = (-8) + Math.sin(Date.now() * 0.001) * 0.1; 
        falconMesh.position.z= (-2*(1440/window.innerWidth) ) + Math.sin(Date.now() * 0.001) * 2;
        falconMesh.rotation.set(0.2, Math.PI, Math.sin(Date.now() * 0.001) * 0.1);       
    }

    renderer.render(scene, camera);

    requestAnimationFrame(animate);
}

// Initialization
init();
window.addEventListener('resize', onWindowResize);
