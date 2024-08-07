<template id="media-theme-player">
    <style>
        :host {
            --indigo-500: rgb(99 102 241);
            --indigo-600: rgb(79 70 229);
            --indigo-700: rgb(67 56 202);

            --slate-300: rgb(203, 213, 225);
            --slate-400: rgb(148, 163, 184);
            --slate-500: rgb(100, 116, 139);

            --bg-color: var(--indigo-600);
            --bg-color-hover: var(--indigo-700);

            --fg-primary: rgb(255 255 255);
        }

        media-controller {
            --media-control-background: transparent;
            --media-control-hover-background: transparent;
            --media-control-active;
            --media-text-color: var(--slate-400);
        }

        media-control-bar {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        media-play-button {
            --shadow: 0 0 #0000;
            --ring-inset: ;
            --ring-offset-color: var(--fg-primary);
            --ring-offest-shadow: 0 0 #0000;
            --ring-offset-width: 2px;
            --ring-offset-shadow: var(--ring-inset) 0 0 0 var(--ring-offset-width) var(--ring-offset-color);
            --ring-shadow: var(--ring-inset) 0 0 0 calc(2px + var(--ring-offset-width)) var(--ring-color);

            width: 3rem;
            height: 3rem;

            padding: 0.75rem;

            color: var(--fg-primary);
            background-color: var(--bg-color);

            border-radius: 9999px;
            border-width: 1px;
            border-color: transparent;

            box-shadow: var(--ring-offset-shadow), var(--ring-shadow), var(--shadow, 0 0 #0000);

            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        media-play-button:focus {
            --ring-color: var(--indigo-500);
            --ring-offset-width: 2px;

            outline: none;
        }

        media-play-button svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        media-play-button:hover {
            background-color: var(--bg-color-hover);
        }

        media-time-display {}

        media-time-range {
            --media-range-track-background: var(--slate-500);
            --media-time-buffered-color: rgb(0 0 0 / .02);
            --media-range-bar-color: var(--slate-400);
            --media-range-track-border-radius: 4px;
            --media-range-track-height: .5rem;
            --media-range-thumb-background: var(--slate-400);
            --media-range-thumb-box-shadow: 0 0 0 2px rgb(0 0 0 / .9);
            --media-range-thumb-width: .25rem;
            --media-range-thumb-height: 1rem;
            --media-preview-time-text-shadow: transparent;

            width: 100%;
        }

        media-preview-time-display {
            height: 0.5rem;
            min-height: 0px;
            padding: 0;

            font-size: 0.75rem;
            line-height: 1rem;

            border-radius: 0.375rem
        }

        media-duration-display {
            --shadow: 0 0 #0000;
            --ring-inset: ;
            --ring-color: var(--indigo-500);
            --ring-offset-shadow: 0 0 #0000;
            --ring-offset-width: 0px;
            --ring-offset-shadow: var(--ring-inset) 0 0 0 var(--ring-offset-width) var(--ring-offset-color);
            --ring-shadow: var(--ring-inset) 0 0 0 calc(2px + var(--ring-offset-width)) var(--ring-color);


            font-size: 0.75rem;
            line-height: 1rem;

            border-radius: 0.375rem;

            box-shadow: var(--ring-offset-shadow), var(--ring-shadow), var(--shadow, 0 0 #0000);
        }

        media-duration-display:focus {
            --ring-opacity: 1;

            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        .vstack {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .hstack {
            display: flex;
            gap: 1rem;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .hidden {
            display: none;
        }

        .grow {
            flex-grow: 1;
        }

        .time-container {
            display: flex;
            align-items: stretch;
            justify-content: space-between;
            gap: 0.5rem;

            width: 100%;
            max-width: 600px;
        }
    </style>

    <svg class="hidden">
        <symbol id="play" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0
          3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd"></path>
        </symbol>

        <symbol id="pause" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M6.75 5.25a.75.75 0 01.75-.75H9a.75.75 0 01.75.75v13.5a.75.75 0
        01-.75.75H7.5a.75.75 0 01-.75-.75V5.25zm7.5 0A.75.75 0 0115 4.5h1.5a.75.75 0 01.75.75v13.5a.75.75 0
        01-.75.75H15a.75.75 0 01-.75-.75V5.25z" clip-rule="evenodd"></path>
        </symbol>
    </svg>

    <media-controller audio="" autohide="-1">
        <slot name="media" slot="media"></slot>
        <media-control-bar>
            <media-play-button>
                <svg slot="play" aria-hidden="true">
                    <use href="#play"></use>
                </svg>
                <svg slot="pause" aria-hidden="true">
                    <use href="#pause"></use>
                </svg>
            </media-play-button>

            <div class="time-container">
                <media-time-display></media-time-display>

                <media-time-range>
                    <media-preview-time-display slot="preview"></media-preview-time-display>
                </media-time-range>

                <media-duration-display></media-duration-display>
            </div>
        </media-control-bar>
    </media-controller>
</template>
