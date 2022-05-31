/**
 * Class representing a canvas element.
 */
export class FullscreenCanvas {
  /** @type {HTMLCanvasElement} */
  canvas;

  /** @type {CanvasRenderingContext2D} */
  context;

  /** @type {number} */
  width;

  /** @type {number} */
  height;

  /** @type {number} */
  pixelWidth;

  /** @type {number} */
  pixelHeight;

  /** @type {number} */
  pixelRatio = window.devicePixelRatio === 2 ? 2 : 1;

  /** @type {((width: number, height: number) => void)}  */
  onresize;

  /**
   * @param {HTMLElement} parent
   */
  constructor(parent) {
    const canvas = document.createElement("canvas");
    const context = canvas.getContext("2d");

    canvas.id = "fullscreen";
    parent.appendChild(canvas);

    this.canvas = canvas;
    this.context = context;

    this.resize();

    window.addEventListener("resize", () => {
      this.resize();
      if (this.onresize ?? null) {
        this.onresize(this.width, this.height);
      }
    });
  }

  /**
   * Resize the canvas to fit the window.
   */
  resize() {
    const width = window.innerWidth;
    const height = window.innerHeight;
    const pixelWidth = width * this.pixelRatio;
    const pixelHeight = height * this.pixelRatio;

    // Set canvas size and adjust for high res displays using jqueryMap references
    this.canvas.setAttribute("width", String(pixelWidth));
    this.canvas.setAttribute("height", String(pixelHeight));

    // Resize of style is the same despite scale
    this.canvas.style.width = width + "px";
    this.canvas.style.height = height + "px";

    // Configuring the canvas resets the context somehow
    this.context.scale(this.pixelRatio, this.pixelRatio);

    this.width = width;
    this.height = height;
    this.pixelWidth = pixelWidth;
    this.pixelHeight = pixelHeight;
  }
}
