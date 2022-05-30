import * as THREE from "three";

let scene, camera, renderer, analyser, uniforms;
const loader = new THREE.FileLoader();

/**
 *
 * @param {string} url
 * @returns {Promise<string>}
 */
function load(url) {
    return new Promise((resolve, reject) => {
        loader.load(
            url,
            (data) => resolve(data),
            null,
            (e) => reject(e)
        );
    });
}

const startButton = document.getElementById("startButton");
startButton.addEventListener("click", init);

async function init() {
    const fftSize = 128;

    const [vertexShader, fragmentShader] = await Promise.all([
        load("/shaders/visualizer.vert"),
        load("/shaders/visualizer.frag"),
    ]);

    const overlay = document.getElementById("overlay");
    overlay.remove();

    //

    const container = document.getElementById("container");

    renderer = new THREE.WebGLRenderer({
        antialias: true,
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(0x000000);
    renderer.setPixelRatio(window.devicePixelRatio);
    container.appendChild(renderer.domElement);

    scene = new THREE.Scene();

    camera = new THREE.Camera();

    //

    const listener = new THREE.AudioListener();

    const audio = new THREE.Audio(listener);
    const url = "/storage/johnhooks_20220501_rush_take_4.MP3";

    if (/(iPad|iPhone|iPod)/g.test(navigator.userAgent)) {
        const loader = new THREE.AudioLoader();
        loader.load(url, function (buffer) {
            audio.setBuffer(buffer);
            audio.play();
        });
    } else {
        const mediaElement = new Audio(url);
        mediaElement.play();

        audio.setMediaElementSource(mediaElement);
    }

    analyser = new THREE.AudioAnalyser(audio, fftSize);

    //

    const format = renderer.capabilities.isWebGL2
        ? THREE.RedFormat
        : THREE.LuminanceFormat;

    uniforms = {
        tAudioData: {
            value: new THREE.DataTexture(analyser.data, fftSize / 2, 1, format),
        },
    };

    // Info about `uv`
    // http://www.opengl-tutorial.org/beginners-tutorials/tutorial-5-a-textured-cube/

    const material = new THREE.ShaderMaterial({
        uniforms: uniforms,
        vertexShader,
        fragmentShader,
    });

    // The below code made a smaller plane that only used a quarter of the screen.
    // const geometry = new THREE.PlaneGeometry(1, 1);
    const geometry = new THREE.PlaneGeometry(2, 2);

    const mesh = new THREE.Mesh(geometry, material);
    scene.add(mesh);

    //

    window.addEventListener("resize", onWindowResize);

    animate();
}

function onWindowResize() {
    renderer.setSize(window.innerWidth, window.innerHeight);
}

// https://stackoverflow.com/a/51942991

let clock = new THREE.Clock();
let delta = 0;
// 30 fps
let interval = 1 / 30;

function animate() {
    requestAnimationFrame(animate);
    delta += clock.getDelta();

    if (delta > interval) {
        // The draw or time dependent code are here
        render();

        delta = delta % interval;
    }
}

function render() {
    analyser.getFrequencyData();

    uniforms.tAudioData.value.needsUpdate = true;

    renderer.render(scene, camera);
}
