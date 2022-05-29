export class Sampler {
    /** @type {AudioContext} */
    ctx;

    /** @type {MediaRecorder} */
    recorder;

    /** @type {AnalyserNode} */
    analyser;

    /** @type {MediaStreamAudioSourceNode} */
    micSource;

    /** @type {MediaElementAudioSourceNode} */
    bufferSource;

    /** @type {HTMLAudioElement} */
    bufferElement;

    /** @type {Array<Blob>} */
    chunks = [];

    /** @type {Uint8Array} */
    timeDateBuffer;

    recording = false;

    buffered = false;

    /**
     * @param {HTMLAudioElement} bufferElement
     */
    constructor(bufferElement) {
        this.bufferElement = bufferElement;
        this.initialize();
    }

    async initialize() {
        const stream = await navigator.mediaDevices
            .getUserMedia({
                audio: true,
            })
            .catch(handleError);

        if (!stream)
            throw new Error(
                "Unable to acquire permission to use the microphone"
            );

        this.ctx = new AudioContext();

        this.bufferSource = this.ctx.createMediaElementSource(
            this.bufferElement
        );

        this.recorder = new MediaRecorder(stream);

        this.recorder.onstop = (_) => {
            console.log("data available after MediaRecorder.stop() called.");

            const blob = new Blob(this.chunks, {
                type: "audio/ogg; codecs=opus",
            });

            this.chunks = [];

            const audioURL = window.URL.createObjectURL(blob);
            this.bufferElement.src = audioURL;
            console.log("recorder stopped");

            // const track = audioCtx.createMediaElementSource(buffer);
            // track.connect(audioCtx.destination);
            this.buffered = true;
        };

        this.recorder.ondataavailable = (e) => {
            this.chunks.push(e.data);
        };

        this.analyser = this.ctx.createAnalyser();
        this.analyser.fftSize = 2 ** 12; // 32768;

        this.timeDateBuffer = new Uint8Array(this.analyser.frequencyBinCount);
    }
}

function handleError(err) {
    console.log("You must give access to your mic in order to proceed");
}
