import { Controller } from '@hotwired/stimulus';
import { Cookie } from "../lib/Cookie";
import {Theme} from "../lib/Theme";

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */

let theme;
export default class extends Controller {
    static targets = ['wrapper', 'navbar', 'checkbox'];

    connect() {
        theme = new Theme();
    }

    toggle(){
        let self = this;
        let status = $(this.checkboxTarget).is(':checked');
        let toRemove, toAdd;
        if (status){
            toRemove = 'dark';
            toAdd = 'light';
        }
        else{
            toRemove = 'light';
            toAdd = 'dark';
        }

        // let _Cookie = new Cookie();
        // _Cookie.write('theme', toAdd, 30);
        theme.define(toAdd);
        console.debug(toRemove)
        $(this.navbarTarget).removeClass(`navbar-${toRemove}`);
        $(this.navbarTarget).addClass(`navbar-${toAdd}`);
        $(this.wrapperTarget).removeClass(`${toRemove}-mode`);
        $(this.wrapperTarget).addClass(`${toAdd}-mode`);
        // $(document).emit('theme', toAdd);
        // document.addEventListener('theme', toAdd, false)
        // document.dispatchEvent(event)

    }
}