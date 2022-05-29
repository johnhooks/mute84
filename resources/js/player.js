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

import { Player } from "./sampler/player";
import { Color } from "./color";

const FRAMERATE = 1000 / 60;

let colorIndex = 0;
let sineIndex = 100;

const canvasState = initCanvas();

const ctx = canvasState.context;
const WIDTH = canvasState.width;
const HEIGHT = canvasState.height;

/** @type {HTMLAudioElement} */
const buffer = document.querySelector("#tapeloop");

// console.log(MediaRecorder.isTypeSupported("audio/wav;codecs=MS_PCM"));

/** @type {Player} */
let player;

buffer.onplay = () => {
    player = new Player(buffer);
    getAudio();
};

async function getAudio() {
    visualize();

    player.bufferSource.connect(player.analyser);
    player.analyser.connect(player.ctx.destination);
}

/**
 *
 */
function visualize() {
    // const frequencyData = new Uint8Array(bufferLength);
    drawTimeData();
}

let background = "rgb(29, 43, 100)";
let stepTwo = "rgb(248, 205, 218)";

function drawTimeData() {
    // inject the time data into our timeData array
    const timeData = player.getTimeData();
    // now that we have the data, lets turn it into something visual
    // 1. Clear the canvas
    ctx.fillStyle = "rgba(0, 0, 0, 0.01)";
    ctx.fillRect(0, 0, WIDTH, HEIGHT);

    // ctx.filter = 'blur(4px)';
    shiftContext(
        ctx,
        canvasState.width * canvasState.scale,
        canvasState.height * canvasState.scale,
        0,
        -4
    );
    // ctx.clearRect(0, 0, WIDTH, HEIGHT);
    // 2. setup some canvas drawing
    ctx.lineWidth = 2;
    // ctx.strokeStyle = Color.wheel(colorIndex).dim(80).stringify();

    ctx.strokeStyle = "#fff";

    sineIndex += 1;
    if (sineIndex > 255) sineIndex = 100;

    ctx.beginPath();

    const sliceWidth = (WIDTH * canvasState.scale) / timeData.byteLength;
    let x = 0;

    for (let i = 0; i < timeData.byteLength; i++) {
        const v = timeData[i] / 128;
        const y = (v * HEIGHT) / 2;

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

/**
 * Canvas State Object
 * @typedef {Object} CanvasState
 * @property {number} width - Indicates whether the Courage component is present.
 * @property {number} height - Indicates whether the Power component is present.
 * @property {number} scale - Indicates whether the Wisdom component is present.
 * @property {HTMLCanvasElement} canvas
 * @property {CanvasRenderingContext2D} context
 */

/**
 *
 * @param {HTMLCanvasElement} canvas
 * @param {CanvasRenderingContext2D} context
 * @returns {CanvasState}
 */
function initState(canvas, context) {
    return configSize({
        canvas,
        context,
        scale: window.devicePixelRatio === 2 ? 2 : 1,
        width: 0,
        height: 0,
    });
}

/**
 *
 * @param {CanvasState} state - The canvas state object
 * @returns {CanvasState}
 */
function configSize(state) {
    return { ...state, width: window.innerWidth, height: window.innerHeight };
}

/**
 *
 * @param {CanvasState} state - The canvas state object
 */
function configCanvas({ canvas, context, width, height, scale }) {
    // Set canvas size and adjust for high res displays using jqueryMap references
    canvas.setAttribute("width", String(width * scale));
    canvas.setAttribute("height", String(height * scale));

    // Resize of style is the same despite scale
    canvas.style.width = width + "px";
    canvas.style.height = height + "px";

    // Configuring the canvas resets the context somehow
    context.scale(scale, scale);
}

/**
 * @returns {CanvasState}
 */
export function initCanvas() {
    const canvas = document.createElement("canvas");
    const context = canvas.getContext("2d");
    let state = initState(canvas, context);

    canvas.id = "fullscreen";
    document.body.appendChild(canvas);
    configCanvas(state);

    window.addEventListener("resize", function () {
        state = configSize(state);
        configCanvas(state);
    });

    return state;
}

const shiftContext = function (ctx, w, h, dx, dy) {
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

    // const pixels = imageData.data;
    // const numPixels = pixels.length;
    // for (var i = 0; i < numPixels; i++) {
    //     var average =
    //         (pixels[i * 4] + pixels[i * 4 + 1] + pixels[i * 4 + 2]) / 3;
    //     // set red green and blue pixels to the average value
    //     pixels[i * 4] = average;
    //     pixels[i * 4 + 1] = average;
    //     pixels[i * 4 + 2] = average;
    // }
    ctx.putImageData(imageData, 0, 0);
};
