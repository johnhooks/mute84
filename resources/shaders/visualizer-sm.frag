uniform sampler2D tAudioData;
// uniform vec2 u_resolution;  // Canvas size (width,height)

varying vec2 vUv;
void main() {
  vec3 backgroundColor = vec3(0.31, 0.27, 0.895);
  vec3 color = vec3(0.36, 0.84, 0.31);
  float f = texture2D(tAudioData, vec2(vUv.x, 0.0)).r;
  float i = step(vUv.y, f) * step(f - 0.075, vUv.y);
  gl_FragColor = vec4(mix(backgroundColor, color, i), 1.0);
}
