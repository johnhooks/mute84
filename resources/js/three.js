import * as THREE from "three";

let scene, camera, renderer, analyser, uniforms;

/** @type {string} */
let audioUrl;

if (/johnhooks\/rush/.test(window.location.href)) {
  audioUrl = "/storage/johnhooks_20220501_rush_take_4.MP3";
} else if (/scottswenson\/it-flows-back/.test(window.location.href)) {
  audioUrl = "/storage/scottswenson_it_flows_back.mp3";
} else if (/scottswenson\/ne2/.test(window.location.href)) {
  audioUrl = "/storage/scottswenson_ne2.mp3";
}
const loader = new THREE.FileLoader();
const audioLoader = new THREE.AudioLoader();

/**
 *
 * @param {string} url
 * @returns {Promise<string>}
 */
function loadFile(url) {
  return new Promise((resolve, reject) => {
    loader.load(
      url,
      data => {
        if (typeof data === "string") {
          resolve(data);
        } else {
          // https://developer.chrome.com/blog/how-to-convert-arraybuffer-to-and-from-string/
          return String.fromCharCode.apply(null, new Uint16Array(data));
        }
      },
      null,
      e => reject(e)
    );
  });
}

/**
 *
 * @param {string} url
 * @returns {Promise<AudioBuffer>}
 */
function loadAudio(url) {
  return new Promise((resolve, reject) => {
    audioLoader.load(
      url,
      data => {
        resolve(data);
      },
      null,
      e => reject(e)
    );
  });
}

const startButton = document.getElementById("startButton");
startButton.addEventListener("click", () => {
  try {
    init();
  } catch (e) {
    console.log(e);
  }
});

async function init() {
  const fftSize = 128;

  const [vertexShader, fragmentShader] = await Promise.all([
    loadFile("/shaders/visualizer.vert"),
    loadFile("/shaders/visualizer.frag"),
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

  if (/(iPad|iPhone|iPod)/g.test(navigator.userAgent)) {
    const buffer = await loadAudio(audioUrl);
    audio.setBuffer(buffer);
    audio.play();
  } else {
    const mediaElement = new Audio(audioUrl);
    mediaElement.play();
    audio.setMediaElementSource(mediaElement);
  }

  analyser = new THREE.AudioAnalyser(audio, fftSize);

  //

  if (/scottswenson/.test(window.location.href)) {
    analyser.analyser.maxDecibels = -50;
    analyser.analyser.minDecibels = -110;
  }

  const format = renderer.capabilities.isWebGL2 ? THREE.RedFormat : THREE.LuminanceFormat;

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
