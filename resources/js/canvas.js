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
    canvas.setAttribute("width", width * scale);
    canvas.setAttribute("height", height * scale);

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

    // window.addEventListener("resize", function () {
    //     state = configSize(state);
    //     configCanvas(state);
    // });

    return state;
}
