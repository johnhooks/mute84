import * as THREE from "three";

import { ElementResizeObserver } from "./canvas.js";

const loader = new THREE.FileLoader();

let scene, camera, renderer, analyser, uniforms;

/**
 * @param {HTMLAudioElement} mediaElement
 * @param {HTMLElement} container
 */
export async function init(mediaElement, container) {
  const fftSize = 512;

  const resizeObserver = new ElementResizeObserver(container);
  const u_resolution = new THREE.Vector2(resizeObserver.width, resizeObserver.height);

  renderer = new THREE.WebGLRenderer({
    antialias: true,
  });

  const [vertexShader, fragmentShader] = await Promise.all([
    loadFile("/shaders/visualizer.vert"),
    loadFile("/shaders/visualizer-02.frag"),
  ]);

  {
    const rect = container.getBoundingClientRect();
    renderer.setSize(Math.floor(rect.width), Math.floor(rect.height));
  }

  renderer.setClearColor(0x000000);
  renderer.setPixelRatio(window.devicePixelRatio);
  container.appendChild(renderer.domElement);

  scene = new THREE.Scene();
  camera = new THREE.Camera();

  const listener = new THREE.AudioListener();
  const audio = new THREE.Audio(listener);

  // TODO First thing to change back is this if the audio doesn't play.
  // mediaElement.play();
  audio.setMediaElementSource(mediaElement);

  analyser = new THREE.AudioAnalyser(audio, fftSize);

  const format = renderer.capabilities.isWebGL2 ? THREE.RedFormat : THREE.LuminanceFormat;

  uniforms = {
    tAudioData: {
      value: new THREE.DataTexture(analyser.data, fftSize / 2, 1, format),
    },
    u_resolution: {
      value: u_resolution,
    },
  };

  resizeObserver.onresize = ({ width, height }) => {
    renderer.setSize(width, height);
    u_resolution.x = width * window.devicePixelRatio;
    u_resolution.y = height * window.devicePixelRatio;
    uniforms.u_resolution.value.needsUpdate = true;
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

  animate();
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
