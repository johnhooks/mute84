import _ from "lodash";
import axios from "axios";
import filesize from "filesize";
import { Alpine as AlpineType } from "alpinejs";

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

export {};

declare global {
  var Alpine: AlpineType;

  interface Window {
    _: _;
    axios: axios;
    filesize: filesize;
  }
}
