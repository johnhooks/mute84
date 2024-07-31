#ifdef GL_ES
precision mediump float;
#endif

uniform sampler2D tAudioData;
uniform vec2 u_resolution;  // Canvas size (width,height)

varying vec2 vUv;
void main() {
  // lowest frequency
  float low = texture2D(tAudioData, vec2(0.0, 0.0)).r;
  // background red
  float r = smoothstep(0.4, 0.9, low);
  // audio data
  float f = max(texture2D(tAudioData, vec2(vUv.x, 0.0)).r, 0.025);
  // levels color
  vec3 color = vec3(mix(0.8, 1.0, f), 0.3, mix(0.89, 0.6, f));
  // modulated by lowest frequency
  vec3 backgroundColor = vec3(mix(0.1, 0.3, r), 0.1, 0.6);
  // inside of level check
  float i = step(vUv.y, f) * step(f - 0.025, vUv.y);

  gl_FragColor = vec4(mix(backgroundColor, color, i), 1.0);
}
