uniform sampler2D tAudioData;
uniform vec2 u_resolution;  // Canvas size (width,height)

varying vec2 vUv;
void main() {
  // vec3 backgroundColor = vec3(0.5, 0.5, 0.89);
  float low = texture2D(tAudioData, vec2(0.0, 0.0)).r;
  // vec2 st = gl_FragCoord.xy/u_resolution;
  // vec3 backgroundColor = vec3(st.x / 2.0, st.y, 0.895);

  float f = max(texture2D(tAudioData, vec2(vUv.x, 0.0)).r, 0.025);
  vec3 color = vec3(mix(0.8, 1.0, f), 0.3, mix(0.89, 0.6, f));

  vec2 st = gl_FragCoord.xy/u_resolution;

  float r = smoothstep(0.4, 0.8, low);
  vec3 backgroundColor = vec3(mix(0.1, 0.2, r), 0.1, 0.6);

  float i = step(vUv.y, f) * step(f - 0.025, vUv.y);
  gl_FragColor = vec4(mix(backgroundColor, color, i), 1.0);
}
