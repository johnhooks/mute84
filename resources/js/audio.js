// https://wesbos.com/javascript/15-final-round-of-exercise/85-audio-visualization
import { initCanvas } from './canvas';

let analyzer;
let bufferLength;

const canvasState = initCanvas()

const ctx = canvasState.context
const WIDTH = canvasState.width;
const HEIGHT = canvasState.height;

async function getAudio() {
    const stream = await navigator.mediaDevices
        .getUserMedia({
            audio: true,
        })
        .catch(handleError);
    const audioCtx = new AudioContext();
    analyzer = audioCtx.createAnalyser();
    // console.log(analyzer)
    const source = audioCtx.createMediaStreamSource(stream);
    source.connect(analyzer);
    // How much data should we collect
    analyzer.fftSize = 2 ** 10; // 32768;
    // pull the data off the audio
    // how many pieces of data are there?!?
    bufferLength = analyzer.frequencyBinCount;
    const timeData = new Uint8Array(bufferLength);
    const frequencyData = new Uint8Array(bufferLength);
    drawTimeData(timeData);
}

function drawTimeData(timeData) {
    // inject the time data into our timeData array
    analyzer.getByteTimeDomainData(timeData);
    // now that we have the data, lets turn it into something visual
    // 1. Clear the canvas
     ctx.clearRect(0, 0, WIDTH, HEIGHT);
    // 2. setup some canvas drawing
    ctx.lineWidth = 5;
    ctx.strokeStyle = "#ffc600";
    ctx.beginPath();
    const sliceWidth = WIDTH * canvasState.scale / bufferLength;
    let x = 0;
    timeData.forEach((data, i) => {
        const v = data / 128;
        const y = (v * HEIGHT) / 2;
        // draw our lines
        if (i === 0) {
            ctx.moveTo(x, y);
        } else {
            ctx.lineTo(x, y);
        }
        x += sliceWidth;
    });
    ctx.stroke();
    // call itself as soon as possible
    requestAnimationFrame(() => drawTimeData(timeData));
}

function handleError(err) {
    console.log("You must give access to your mic in order to proceed");
}
getAudio();
