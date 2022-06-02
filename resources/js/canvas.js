/**
 * @typedef {(data: {width: number, height: number}) => void} ResizeListener
 */

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

/**
 * Interface for classes that represent a resizer.
 *
 * @interface
 */
export class Resizer {
  /**
   * @type {number}
   * @protected
   */
  _width;

  /**
   * @type {number}
   * @protected
   * */
  _height;

  /**
   * @type {ResizeListener}
   * @public
   */
  onresize;

  /**
   * Implementation required
   * @abstract
   * @returns {void}
   */
  dispose() {
    throw new Error("You have to implement the method dispose!");
  }

  /**
   * @type {number}
   * @public
   * */
  get width() {
    return this._width;
  }

  /**
   * @type {number}
   * @public
   */
  get height() {
    return this._height;
  }
}

/**
 * Class to observe window resize.
 * @implements {Resizer}
 */
export class WindowResizeObserver extends Resizer {
  constructor() {
    super();

    window.addEventListener("resize", this.handleResize);
  }

  handleResize = () => {
    this._width = window.innerWidth;
    this._height = window.innerHeight;
    if (this.onresize !== undefined) {
      this.onresize({ width: this.width, height: this.height });
    }
  };

  dispose = () => {
    window.removeEventListener("resize", this.handleResize);
  };
}

/**
 * Class to observe element resize.
 * @implements {Resizer}
 */
export class ElementResizeObserver extends Resizer {
  /**
   * @type {HTMLElement}
   * @private
   */
  _element;

  /** @type {ResizeObserver} */
  _resizeObserver;

  /**
   * @param {HTMLElement} element
   */
  constructor(element) {
    super();

    this._element = element;

    // TODO allow selection of just one direction to observe
    this._height = element.getBoundingClientRect().height;
    this._width = element.getBoundingClientRect().width;

    /** @type {ResizeObserverCallback} */
    const observer = entries => {
      const entry = entries[0];

      if (entry.contentBoxSize) {
        // Firefox implements `contentBoxSize` as a single content rect, rather than an array
        const contentBoxSize = Array.isArray(entry.contentBoxSize)
          ? entry.contentBoxSize[0]
          : entry.contentBoxSize;

        this._width = contentBoxSize.inlineSize;
        this._height = contentBoxSize.blockSize;
      } else {
        this._width = entry.contentRect.width;
        this._height = entry.contentRect.height;
      }

      if (this.onresize !== undefined) {
        this.onresize({ width: this._width, height: this._height });
      }
    };

    this._resizeObserver = new ResizeObserver(observer);

    this._resizeObserver.observe(element);
  }

  dispose = () => {
    this._resizeObserver.unobserve(this._element);
  };
}
