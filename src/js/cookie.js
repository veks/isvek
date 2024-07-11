/**
 * --------------------------------------------------------------------------
 * Isvek (v1.0.0): cookie.js
 * Licensed under MIT (https://isvek.ru/main/LICENSE.md)
 * --------------------------------------------------------------------------
 */

import SelectorEngine from 'bootstrap/js/src/dom/selector-engine.js'
import EventHandler from 'bootstrap/js/src/dom/event-handler.js'
import { setCookie, getCookie, stringToBoolean } from './util/index'

EventHandler.on(window, 'load', () => {
  let toastCookie = SelectorEngine.findOne('#toast-cookie')
  let toast = bootstrap.Toast.getOrCreateInstance(toastCookie, { autohide: false, animation: true })
  let cookieAgree = SelectorEngine.findOne('.cookie-agree')

  if (toastCookie) {
    if (stringToBoolean(getCookie('cookie-agree'))) {
      toastCookie.classList.add('d-none')
      toast.hide()
    } else {
      toastCookie.classList.remove('d-none')
      toast.show()
    }

    if(cookieAgree){
      EventHandler.on(cookieAgree, 'click', event => {
        event.preventDefault()

        setCookie('cookie-agree', 'true')

        toast.hide()
      })
    }
  }
})
