require("./bootstrap.js");

//@ts-ignore
import Alpine from "alpinejs";

import * as levels from "./levels.js";

window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
  const audio = new Audio();

  let visualizer;

  Alpine.store("player", {
    url: null,

    playing: false,

    play(url) {
      if (!url) {
        if (this.playing) {
          audio.pause();
          this.playing = false;
        } else {
          audio.play();
          this.playing = true;
        }
        return;
      }
      if (url === this.url) {
        if (audio.paused) {
          audio.play();
          if (!visualizer) visualizer = levels.init(audio, document.querySelector("#visualizer"));
          this.playing = true;
        } else {
          audio.pause();
          this.playing = false;
        }
        return;
      }
      this.url = url;
      audio.src = url;
      if (!visualizer) visualizer = levels.init(audio, document.querySelector("#visualizer"));
      audio.play();
      this.playing = true;
    },
  });

  Alpine.data("audio", url => {
    return {
      url: url,
      play() {
        Alpine.store("player").play(url);
      },
      /**
       *
       * @param {SubmitEvent} e
       */
      confirm(e) {
        if (confirm("Are you really sure you want to do this?!?") === false) {
          // Stop the click event from propagating to the player.
          e.stopImmediatePropagation();
          // Prevent the form submit.
          e.preventDefault();
        }
      },
    };
  });

  Alpine.data("visualizer", () => {
    return {
      running: false,

      init() {
        // const dispose = levels.init(audio, this.$root);
      },

      toggle() {
        Alpine.store("player").play();
      },
    };
  });
});

Alpine.start();
