export class Player {
    /** @type {AudioContext} */
    ctx;

    /** @type {AnalyserNode} */
    analyser;

    /** @type {MediaElementAudioSourceNode} */
    bufferSource;

    /** @type {Uint8Array} */
    timeDataBuffer;

    /**
     * @param {HTMLAudioElement} bufferElement
     */
    constructor(bufferElement) {
        this.bufferElement = bufferElement;
        this.ctx = new AudioContext();

        this.bufferSource = this.ctx.createMediaElementSource(
            this.bufferElement
        );

        this.analyser = this.ctx.createAnalyser();

        this.analyser.fftSize = 2 ** 11; // 32768;
        this.timeDataBuffer = new Uint8Array(this.analyser.frequencyBinCount);

        this.bufferSource.connect(this.analyser);
        this.analyser.connect(this.ctx.destination);
    }

    /**
     *
     * @returns {Uint8Array} The analyser byte time domain data
     */
    getTimeData() {
        this.analyser.getByteTimeDomainData(this.timeDataBuffer);
        return this.timeDataBuffer;
    }
}
