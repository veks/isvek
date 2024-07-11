/**
 * --------------------------------------------------------------------------
 * Isvek (v1.0.0): tooltip.js
 * Licensed under MIT
 * --------------------------------------------------------------------------
 */

import SelectorEngine from 'bootstrap/js/src/dom/selector-engine.js'
import EventHandler from 'bootstrap/js/src/dom/event-handler.js'

EventHandler.on(window, 'load', () => {
  const elements = SelectorEngine.find('[data-bs-toggle="tooltip"]')

  if (elements) {
    for (const element of elements) {
      new bootstrap.Tooltip(element)
    }
  }
})
