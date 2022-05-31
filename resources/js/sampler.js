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

import { Sampler } from "./sampler/sampler.js";
import { FullscreenCanvas } from "./canvas.js";

const canvas = new FullscreenCanvas(document.querySelector("main"));

/** @type {HTMLButtonElement} */
const record = document.querySelector("#record-btn");
/** @type {HTMLButtonElement} */
const play = document.querySelector("#play-btn");
/** @type {HTMLAudioElement} */
const buffer = document.querySelector("#buffer");

// console.log(MediaRecorder.isTypeSupported("audio/wav;codecs=MS_PCM"));

let sampler = new Sampler(buffer);

function startRecord() {
  record.classList.remove("bg-red-500", "hover:bg-red-700");
  record.classList.add("bg-red-700");
}

function stopRecord() {
  record.classList.remove("bg-red-700");
  record.classList.add("bg-red-500", "hover:bg-red-700");
}

async function getAudio() {
  await sampler.initialize();

  visualize();

  record.onclick = function () {
    if (sampler.recording) {
      stopRecord();
      sampler.stopRecord();
      console.log(sampler.recorder.state);
      console.log("recorder stopped");
      play.disabled = false;
    } else {
      startRecord();
      sampler.startRecord();
      play.disabled = true;
      console.log(sampler.recorder.state);
      console.log("recorder started");
    }
  };

  play.onclick = function () {
    // mediaRecorder.stop();
    // console.log(mediaRecorder.state);
    // console.log("recorder stopped");

    // play.disabled = true;
    // record.disabled = true;
    if (!sampler.recording && sampler.buffered) {
      // const track = audioCtx.createMediaElementSource(buffer);
      // track.connect(audioCtx.destination);
      if (sampler.playing) {
        sampler.stopPlayback();
      } else {
        sampler.startPlayback();
      }
    }
  };
}

/**
 *
 * @param {MediaRecorder} recorder
 * @returns
 */
// function wait(recorder) {
//     return new Promise((resolve, reject) => {
//         recorder.addEventListener('stop')
//     })
// }

/**
 *
 */
function visualize() {
  // const frequencyData = new Uint8Array(bufferLength);
  drawTimeData();
}

function drawTimeData() {
  const ctx = canvas.context;
  // inject the time data into our timeData array
  const timeData = sampler.getTimeData();
  // now that we have the data, lets turn it into something visual
  // 1. Clear the canvas
  ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  // ctx.clearRect(0, 0, WIDTH, HEIGHT);
  // 2. setup some canvas drawing
  ctx.lineWidth = 2;
  ctx.strokeStyle = "#ffc600";
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
  requestAnimationFrame(() => drawTimeData());
}

getAudio();

// class Visualizer {
//   active = false;

//   /**  @type {CanvasState} */
//   state;

//   /** @type {(state: CanvasState) => void} */
//   update;

//   /**
//    *
//    * @param {CanvasState} state
//    * @param {(state: CanvasState) => void} update
//    */
//   constructor(state, update) {
//     this.state = state;
//     this.update = update;
//   }

//   stop() {
//     this.active = false;
//   }

//   loop() {
//     if (this.active) {
//     }
//   }
// }

// /**
//  *
//  * @param {(delta: number) => void} render
//  * @returns {() => void} Stop the loop
//  */
// function startLoop(render) {
//   // limit update and render by target rates
//   let stop = false;
//   let last = 0;
//   let delta = 0;
//   let id;

//   /**
//    *
//    * @param {number} now
//    */
//   function loop(now) {
//     if (stop) return;
//     delta += now - last;
//     if (delta >= FRAMERATE) {
//       render(delta);
//       delta = 0;
//     }
//     last = now;
//     id = window.requestAnimationFrame(loop);
//   }

//   loop(delta); // not passing loop a number results in delta === NaN

//   return () => {
//     stop = true;
//     window.cancelAnimationFrame(id);
//   };
// }
