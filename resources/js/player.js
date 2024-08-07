/**
 * The state of the application
 * stopped - if there is a recorded sample the play button should be enabled
 * recording - if playing, stop playback and start recording, disable play button until recording is stopped
 * playing - disabled if recording. Play pause button otherwise
 */

/**
 * Major components
 *
 * Audio context and sources
 * - analyser
 * - buffer source - an audio element on the page
 * - microphone source - media stream from the users microphone
 * - handle connecting the analyser to different sources
 *
 * Visualizer
 * - canvas element
 * - canvas update and render functions
 * - connection to the audio analyser to get data
 * - control the loop function.
 *
 * Interface
 * - record and playback buttons
 */

import { Player } from "./sampler/player.js";
import { Color } from "./color.js";
import { FullscreenCanvas } from "./canvas.js";

const FRAMERATE = 1000 / 30;

let colorIndex = 0;

const canvas = new FullscreenCanvas(document.querySelector("main"));

/** @type {HTMLAudioElement} */
const buffer = /** @type {HTMLAudioElement} */ (document.querySelector("#audio"));

/** @type {Player} */
let player;

buffer.addEventListener("play", () => {
  if (!player) {
    player = new Player(buffer);
    getAudio();
  }
});

async function getAudio() {
  if (/scottswenson/.test(window.location.href)) {
    player.analyser.maxDecibels = -50;
    player.analyser.minDecibels = -150;
  }
  startLoop(drawTimeData);
}

function drawTimeData() {
  const ctx = canvas.context;
  // inject the time data into our timeData array
  const timeData = player.getTimeData();
  // now that we have the data, lets turn it into something visual
  // 1. Clear the canvas
  ctx.fillStyle = "rgba(0, 0, 0, 0.01)";
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  // ctx.filter = 'blur(4px)';
  shiftContext(ctx, canvas.pixelWidth, canvas.pixelHeight, 0, -8);
  // ctx.clearRect(0, 0, WIDTH, HEIGHT);
  // 2. setup some canvas drawing
  ctx.lineWidth = 2;
  ctx.strokeStyle = Color.wheel(colorIndex).dim(80).stringify();

  // ctx.strokeStyle = "#fff";

  colorIndex += 1;
  if (colorIndex > 255) colorIndex = 0;

  ctx.beginPath();

  const sliceWidth = canvas.pixelWidth / timeData.byteLength;
  let x = 0;

  for (let i = 0; i < timeData.byteLength; i++) {
    const v = timeData[i] / 128;
    const y = (v * canvas.height) / 2;

    if (i === 0) {
      ctx.moveTo(x, y);
    } else {
      ctx.lineTo(x, y);
    }

    x += sliceWidth;
  }

  ctx.stroke();
  // call itself as soon as possible
  // requestAnimationFrame(() => drawTimeData());
}

function shiftContext(ctx, w, h, dx, dy) {
  const clamp = function (high, value) {
    return Math.max(0, Math.min(high, value));
  };
  const imageData = ctx.getImageData(
    clamp(w, -dx),
    clamp(h, -dy),
    clamp(w, w - dx),
    clamp(h, h - dy)
  );
  ctx.clearRect(0, 0, w, h);
  ctx.putImageData(imageData, 0, 0);
}

function startLoop(render) {
  // limit update and render by target rates
  let stop = false;
  let last = 0;
  let delta = 0;
  let id;

  /**
   *
   * @param {number} now
   */
  function loop(now) {
    if (stop) return;
    delta += now - last;
    if (delta >= FRAMERATE) {
      render(delta);
      delta = 0;
    }
    last = now;
    id = window.requestAnimationFrame(loop);
  }

  loop(delta); // not passing loop a number results in delta === NaN

  return () => {
    stop = true;
    window.cancelAnimationFrame(id);
  };
}
