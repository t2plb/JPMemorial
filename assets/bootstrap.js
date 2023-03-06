//import $ from 'jquery';
import { startStimulusApp } from '@symfony/stimulus-bridge';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

import {Theme} from "./lib/Theme";

(function($) {

    $(document).on("keydown", "form", function(event) {
        return event.key !== "Enter";
    });

    /*$(document).on('theme', (event, data) => {
        (data === 'dark') ? $('table.table').addClass('table-dark') : $('table.table').removeClass('table-dark');
    });
    if((new Theme).getTheme() === 'dark')
    {
        $('table.table').hasClass('table-dark') ? '' : $('table.table').addClass('table-dark');
    }*/

})(jQuery);