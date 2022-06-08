import * as THREE from "three";

const LABEL_TEXT = "mute84";

const clock = new THREE.Clock();
const scene = new THREE.Scene();

// Create a new framebuffer we will use to render to
// the video card memory
let renderBufferA = new THREE.WebGLRenderTarget(
  innerWidth * devicePixelRatio,
  innerHeight * devicePixelRatio
);

// Create a second framebuffer
let renderBufferB = new THREE.WebGLRenderTarget(
  innerWidth * devicePixelRatio,
  innerHeight * devicePixelRatio
);

// Create a threejs renderer:
// 1. Size it correctly
// 2. Set default background color
// 3. Append it to the page
const renderer = new THREE.WebGLRenderer();
renderer.setClearColor(0x222222);
renderer.setClearAlpha(0);
renderer.setSize(innerWidth, innerHeight);
renderer.setPixelRatio(devicePixelRatio || 1);
document.querySelector("main").appendChild(renderer.domElement);

// Create an orthographic camera that covers the entire screen
// 1. Position it correctly in the positive Z dimension
// 2. Orient it towards the scene center
const orthoCamera = new THREE.OrthographicCamera(
  -innerWidth / 2,
  innerWidth / 2,
  innerHeight / 2,
  -innerHeight / 2,
  0.1,
  10
);

orthoCamera.position.set(0, 0, 1);
orthoCamera.lookAt(new THREE.Vector3(0, 0, 0));

// Create a plane geometry that spawns either the entire
// viewport height or width depending on which one is bigger
const labelMeshSize = innerWidth > innerHeight ? innerHeight : innerWidth;
const labelGeometry = new THREE.PlaneBufferGeometry(labelMeshSize, labelMeshSize);

// TODO This is where I would create the audio visualizer.
// Programmaticaly create a texture that will hold the text
let labelTextureCanvas;
{
  // Canvas and corresponding context2d to be used for
  // drawing the text
  labelTextureCanvas = document.createElement("canvas");
  const labelTextureCtx = labelTextureCanvas.getContext("2d");

  // Dynamic texture size based on the device capabilities
  const textureSize = Math.min(renderer.capabilities.maxTextureSize, 2048);
  const relativeFontSize = 20;
  // Size our text canvas
  labelTextureCanvas.width = textureSize;
  labelTextureCanvas.height = textureSize;
  labelTextureCtx.textAlign = "center";
  labelTextureCtx.textBaseline = "middle";

  // Dynamic font size based on the texture size
  // (based on the device capabilities)
  labelTextureCtx.font = `${relativeFontSize}px Helvetica`;
  const textWidth = labelTextureCtx.measureText(LABEL_TEXT).width;
  const widthDelta = labelTextureCanvas.width / textWidth;
  const fontSize = relativeFontSize * widthDelta;
  labelTextureCtx.font = `${fontSize}px Helvetica`;
  labelTextureCtx.fillStyle = "white";
  labelTextureCtx.fillText(LABEL_TEXT, labelTextureCanvas.width / 2, labelTextureCanvas.height / 2);
}

// Create a material with our programmaticaly created text
// texture as input
const labelMaterial = new THREE.MeshBasicMaterial({
  map: new THREE.CanvasTexture(labelTextureCanvas),
  transparent: true,
});

// Create a plane mesh, add it to the scene
const labelMesh = new THREE.Mesh(labelGeometry, labelMaterial);
scene.add(labelMesh);

// Create a second scene that will hold our fullscreen plane
const postFXScene = new THREE.Scene();

// Create a plane geometry that covers the entire screen
const postFXGeometry = new THREE.PlaneBufferGeometry(innerWidth, innerHeight);

// Create a plane material that expects a sampler texture input
// We will pass our generated framebuffer texture to it
const postFXMaterial = new THREE.ShaderMaterial({
  uniforms: {
    sampler: { value: null },
    time: { value: 0 },
    mousePos: { value: new THREE.Vector2(0, 0) },
  },
  // vertex shader will be in charge of positioning our plane correctly
  vertexShader: `
      varying vec2 v_uv;

      void main () {
        // Set the correct position of each plane vertex
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);

        // Pass in the correct UVs to the fragment shader
        v_uv = uv;
      }
    `,
  fragmentShader: `
  // Pass in time
  uniform float time;

        // Pass in normalised mouse coordinates
  uniform vec2 mousePos;

        // Declare our texture input as a "sampler" variable
  uniform sampler2D sampler;

        // Consume the correct UVs from the vertex shader to use
        // when displaying the generated texture
  varying vec2 v_uv;

        //	Simplex 3D Noise
        //	by Ian McEwan, Ashima Arts
        //
  vec4 permute(vec4 x) {
    return mod(((x * 34.0) + 1.0) * x, 289.0);
  }
  vec4 taylorInvSqrt(vec4 r) {
    return 1.79284291400159 - 0.85373472095314 * r;
  }

  float snoise(vec3 v) {
    const vec2 C = vec2(1.0 / 6.0, 1.0 / 3.0);
    const vec4 D = vec4(0.0, 0.5, 1.0, 2.0);

        // First corner
    vec3 i = floor(v + dot(v, C.yyy));
    vec3 x0 = v - i + dot(i, C.xxx);

        // Other corners
    vec3 g = step(x0.yzx, x0.xyz);
    vec3 l = 1.0 - g;
    vec3 i1 = min(g.xyz, l.zxy);
    vec3 i2 = max(g.xyz, l.zxy);

          //  x0 = x0 - 0. + 0.0 * C
    vec3 x1 = x0 - i1 + 1.0 * C.xxx;
    vec3 x2 = x0 - i2 + 2.0 * C.xxx;
    vec3 x3 = x0 - 1. + 3.0 * C.xxx;

        // Permutations
    i = mod(i, 289.0);
    vec4 p = permute(permute(permute(i.z + vec4(0.0, i1.z, i2.z, 1.0)) + i.y + vec4(0.0, i1.y, i2.y, 1.0)) + i.x + vec4(0.0, i1.x, i2.x, 1.0));

        // Gradients
        // ( N*N points uniformly over a square, mapped onto an octahedron.)
    float n_ = 1.0 / 7.0; // N=7
    vec3 ns = n_ * D.wyz - D.xzx;

    vec4 j = p - 49.0 * floor(p * ns.z * ns.z);  //  mod(p,N*N)

    vec4 x_ = floor(j * ns.z);
    vec4 y_ = floor(j - 7.0 * x_);    // mod(j,N)

    vec4 x = x_ * ns.x + ns.yyyy;
    vec4 y = y_ * ns.x + ns.yyyy;
    vec4 h = 1.0 - abs(x) - abs(y);

    vec4 b0 = vec4(x.xy, y.xy);
    vec4 b1 = vec4(x.zw, y.zw);

    vec4 s0 = floor(b0) * 2.0 + 1.0;
    vec4 s1 = floor(b1) * 2.0 + 1.0;
    vec4 sh = -step(h, vec4(0.0));

    vec4 a0 = b0.xzyw + s0.xzyw * sh.xxyy;
    vec4 a1 = b1.xzyw + s1.xzyw * sh.zzww;

    vec3 p0 = vec3(a0.xy, h.x);
    vec3 p1 = vec3(a0.zw, h.y);
    vec3 p2 = vec3(a1.xy, h.z);
    vec3 p3 = vec3(a1.zw, h.w);

        //Normalise gradients
    vec4 norm = taylorInvSqrt(vec4(dot(p0, p0), dot(p1, p1), dot(p2, p2), dot(p3, p3)));
    p0 *= norm.x;
    p1 *= norm.y;
    p2 *= norm.z;
    p3 *= norm.w;

        // Mix final noise value
    vec4 m = max(0.6 - vec4(dot(x0, x0), dot(x1, x1), dot(x2, x2), dot(x3, x3)), 0.0);
    m = m * m;
    return 42.0 * dot(m * m, vec4(dot(p0, x0), dot(p1, x1), dot(p2, x2), dot(p3, x3)));
  }

  void main() {
    float a = snoise(vec3(v_uv * 1.0, time * 0.1)) * 0.0032;
    float b = snoise(vec3(v_uv * 1.0, time * 0.1 + 100.0)) * 0.0032;

          // Sample the correct color from the generated texture
    vec4 inputColor = texture2D(sampler, v_uv + vec2(a, b) + mousePos * 0.005);
          // Set the correct color of each pixel that makes up the plane
    gl_FragColor = vec4(inputColor * 0.975);
  }

    `,
});

const postFXMesh = new THREE.Mesh(postFXGeometry, postFXMaterial);
postFXScene.add(postFXMesh);

// Start out animation render loop
// renderer.setAnimationLoop(onAnimLoop);
animate();
// Attach mousemove event listener
document.addEventListener("mousemove", onMouseMove);

function onMouseMove(e) {
  // Normalise horizontal mouse pos from -1 to 1
  const x = (e.pageX / innerWidth) * 2 - 1;

  // Normalise vertical mouse pos from -1 to 1
  const y = (1 - e.pageY / innerHeight) * 2 - 1;

  // Pass normalised mouse coordinates to fragment shader
  postFXMesh.material.uniforms.mousePos.value.set(x, y);
}

function onAnimLoop() {
  // Do not clear the contents of the canvas on each render
  // In order to achieve our effect, we must draw the new frame
  // on top of the previous one!
  renderer.autoClearColor = false;

  // Explicitly set renderBufferA as the framebuffer to render to
  renderer.setRenderTarget(renderBufferA);

  // On each new frame, render the scene to renderBufferA
  renderer.render(postFXScene, orthoCamera);
  renderer.render(scene, orthoCamera);

  // Set the device screen as the framebuffer to render to
  // In WebGL, framebuffer "null" corresponds to the default framebuffer!
  renderer.setRenderTarget(null);

  // Assign the generated texture to the sampler variable used
  // in the postFXMesh that covers the device screen
  postFXMesh.material.uniforms.sampler.value = renderBufferA.texture;

  // Render the postFX mesh to the default framebuffer
  renderer.render(postFXScene, orthoCamera);

  // Ping-pong our framebuffers by swapping them
  // at the end of each frame render
  const temp = renderBufferA;
  renderBufferA = renderBufferB;
  renderBufferB = temp;
}

// https://stackoverflow.com/a/51942991

let delta = 0;
// 30 fps
let interval = 1 / 30;

function animate() {
  requestAnimationFrame(animate);

  delta += clock.getDelta();

  if (delta > interval) {
    // The draw or time dependent code are here
    onAnimLoop();

    delta = delta % interval;
  }
}
