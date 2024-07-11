/**
 * --------------------------------------------------------------------------
 * Isvek (v1.0.0): scroll-top.js
 * Licensed under MIT
 * --------------------------------------------------------------------------
 */

import SelectorEngine from 'bootstrap/js/src/dom/selector-engine.js'
import EventHandler from 'bootstrap/js/src/dom/event-handler.js'

EventHandler.on(window, 'load', () => {
  let backTopSelector =  SelectorEngine.findOne('.scroll-top')

  if (backTopSelector) {
    EventHandler.on(backTopSelector, 'click', event => {
      event.preventDefault()

      window.scroll({ top: 0, left: 0, behavior: 'smooth' })
    }, false)


    EventHandler.on(window,'scroll', () => {
      let scrolled = document.scrollingElement.scrollTop || 0

      if (scrolled > 300) {
        backTopSelector.classList.add('show')
      } else {
        backTopSelector.classList.remove('show')
      }
    })
  }
})
