import {EventEmitter} from "events";
import { Cookie } from "./Cookie";

class Theme extends EventEmitter {

    _CookieName;
    _Cookie;
    _Event;
    constructor(name = 'theme') {
        super();
        this._CookieName = name;
        this._Cookie = new Cookie();
        // this._Event = new Event('theme');
    }

    define(theme, duration = 30){
        this._Cookie.write(this._CookieName, theme, duration);
        $(document).trigger('theme', [theme]);
    }

    getTheme(){
        return this._Cookie.read(this._CookieName);
    }
}

export {Theme};