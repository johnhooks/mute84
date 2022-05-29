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

const FRAMERATE = 1000 / 60;

let analyzer;
let bufferLength;

/** @type {AudioContext} */
let audioCtx;
/** @type {MediaStreamAudioSourceNode | MediaElementAudioSourceNode} */
let micSource;
/** @type {MediaElementAudioSourceNode} */
let bufferSource;

const canvasState = initCanvas();

const ctx = canvasState.context;
const WIDTH = canvasState.width;
const HEIGHT = canvasState.height;

let chunks = [];

/** @type {HTMLButtonElement} */
const record = document.querySelector("#record-btn");
/** @type {HTMLButtonElement} */
const play = document.querySelector("#play-btn");
/** @type {HTMLAudioElement} */
const buffer = document.querySelector("#buffer");

// console.log(MediaRecorder.isTypeSupported("audio/wav;codecs=MS_PCM"));

let recording = false;
let sampleReady = false;

function startRecord() {
    record.classList.remove("bg-red-500", "hover:bg-red-700");
    record.classList.add("bg-red-700");
}

function stopRecord() {
    record.classList.remove("bg-red-700");
    record.classList.add("bg-red-500", "hover:bg-red-700");
}

async function getAudio() {
    const stream = await navigator.mediaDevices
        .getUserMedia({
            audio: true,
        })
        .catch(handleError);

    if (!stream) return;

    audioCtx = new AudioContext();
    bufferSource = audioCtx.createMediaElementSource(buffer);

    const mediaRecorder = new MediaRecorder(stream);

    visualize(stream);

    record.onclick = function () {
        if (recording) {
            stopRecord();
            mediaRecorder.stop();
            console.log(mediaRecorder.state);
            console.log("recorder stopped");
            play.disabled = false;
        } else {
            sampleReady = false;
            startRecord();
            mediaRecorder.start();
            play.disabled = true;
            console.log(mediaRecorder.state);
            console.log("recorder started");
        }
        recording = !recording;
    };

    play.onclick = function () {
        // mediaRecorder.stop();
        // console.log(mediaRecorder.state);
        // console.log("recorder stopped");

        // play.disabled = true;
        // record.disabled = true;
        if (!recording && sampleReady) {
            // const track = audioCtx.createMediaElementSource(buffer);
            // track.connect(audioCtx.destination);
            buffer.play();
        }
    };

    mediaRecorder.onstop = function (e) {
        console.log("data available after MediaRecorder.stop() called.");

        // buffer.setAttribute('controls', '');

        const blob = new Blob(chunks, { type: "audio/ogg; codecs=opus" });
        chunks = [];
        const audioURL = window.URL.createObjectURL(blob);
        buffer.src = audioURL;
        console.log("recorder stopped");

        // const track = audioCtx.createMediaElementSource(buffer);
        // track.connect(audioCtx.destination);
        sampleReady = true;
    };

    mediaRecorder.ondataavailable = function (e) {
        chunks.push(e.data);
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
 * @param { MediaStream} stream
 */
function visualize(stream) {
    analyzer = audioCtx.createAnalyser();
    // console.log(analyzer)
    micSource = audioCtx.createMediaStreamSource(stream);
    micSource.connect(analyzer);
    // How much data should we collect
    analyzer.fftSize = 2 ** 12; // 32768;
    // pull the data off the audio
    // how many pieces of data are there?!?
    bufferLength = analyzer.frequencyBinCount;
    const timeData = new Uint8Array(bufferLength);
    // const frequencyData = new Uint8Array(bufferLength);
    drawTimeData(timeData);
}

function drawTimeData(timeData) {
    // inject the time data into our timeData array
    analyzer.getByteTimeDomainData(timeData);
    // now that we have the data, lets turn it into something visual
    // 1. Clear the canvas
    ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
    ctx.fillRect(0, 0, WIDTH, HEIGHT);
    // ctx.clearRect(0, 0, WIDTH, HEIGHT);
    // 2. setup some canvas drawing
    ctx.lineWidth = 2;
    ctx.strokeStyle = "#ffc600";
    ctx.beginPath();

    const sliceWidth = (WIDTH * canvasState.scale) / bufferLength;
    let x = 0;

    for (let i = 0; i < bufferLength; i++) {
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
    requestAnimationFrame(() => drawTimeData(timeData));
}

function handleError(err) {
    console.log("You must give access to your mic in order to proceed");
}

getAudio();

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

class Visualizer {
    active = false;

    /**  @type {CanvasState} */
    state;

    /** @type {(state: CanvasState) => void} */
    update;

    /**
     *
     * @param {CanvasState} state
     * @param {(state: CanvasState) => void} update
     */
    constructor(state, update) {
        this.state = state;
        this.update = update;
    }

    stop() {
        this.active = false;
    }

    loop() {
        if (this.active) {
        }
    }
}

/**
 *
 * @param {(delta: number) => void} render
 * @returns {() => void} Stop the loop
 */
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
