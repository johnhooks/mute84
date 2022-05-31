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
  timeDataBuffer;

  recording = false;

  playing = false;

  buffered = false;

  /**
   * @param {HTMLAudioElement} bufferElement
   */
  constructor(bufferElement) {
    this.bufferElement = bufferElement;
  }

  async initialize() {
    const stream = await navigator.mediaDevices
      .getUserMedia({
        audio: true,
      })
      .catch(handleError);

    if (!stream) throw new Error("Unable to acquire permission to use the microphone");

    this.ctx = new AudioContext();

    this.micSource = this.ctx.createMediaStreamSource(stream);
    this.bufferSource = this.ctx.createMediaElementSource(this.bufferElement);

    // * Important! No play back without this
    // this.bufferSource.connect(this.ctx.destination);

    this.recorder = new MediaRecorder(stream);

    this.recorder.onstop = _ => {
      console.log("data available after MediaRecorder.stop() called.");

      console.log(this.recorder.mimeType);
      const blob = new Blob(this.chunks, {
        // type: "audio/wav; codecs=audio/wav",
        // just using the default mimeType seems to work better
        type: this.recorder.mimeType,
      });

      this.chunks = [];

      const audioURL = window.URL.createObjectURL(blob);
      this.bufferElement.src = audioURL;
      console.log("recorder stopped");

      // const track = audioCtx.createMediaElementSource(buffer);
      // track.connect(audioCtx.destination);
      this.buffered = true;
    };

    this.recorder.ondataavailable = e => {
      this.chunks.push(e.data);
    };

    this.analyser = this.ctx.createAnalyser();
    this.analyser.fftSize = 2 ** 12; // 32768;

    this.timeDataBuffer = new Uint8Array(this.analyser.frequencyBinCount);
  }

  startRecord() {
    this.recording = true;
    this.micSource.connect(this.analyser);
    this.recorder.start();
  }

  stopRecord() {
    this.recording = false;
    this.buffered = false;
    this.micSource.disconnect(this.analyser);
    this.recorder.stop();
  }

  startPlayback() {
    this.playing = true;
    //  this.bufferSource.connect(this.ctx.destination);
    this.bufferSource.connect(this.analyser);
    this.analyser.connect(this.ctx.destination);
    this.bufferElement.play();
  }

  stopPlayback() {
    this.playing = false;
    this.bufferSource.disconnect(this.analyser);
    this.analyser.disconnect(this.ctx.destination);
    this.bufferElement.pause();
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

function handleError(_err) {
  console.log("You must give access to your mic in order to proceed");
}
