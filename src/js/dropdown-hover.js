/**
 * --------------------------------------------------------------------------
 * Isvek (v1.0.0): dropdown-hover.js
 * Licensed under MIT (https://isvek.ru/main/LICENSE.md)
 * --------------------------------------------------------------------------
 */
import EventHandler from 'bootstrap/js/src/dom/event-handler.js'
import BaseComponent from 'bootstrap/js/src/base-component.js'
import SelectorEngine from 'bootstrap/js/src/dom/selector-engine.js'

/**
 * Constants
 */
const NAME = 'dropdown'
const DATA_KEY = 'bs.dropdown'
const EVENT_KEY = `.${DATA_KEY}`
const DATA_API_KEY = '.data-api'

const EVENT_CLICK = 'click'
const EVENT_MOUSEOVER = `mouseover`
const EVENT_MOUSELEAVE = `mouseleave`
const EVENT_TAB = `Tab`
const EVENT_KEYDOWN = `keydown`
const EVENT_FOCUS = `focus`
const EVENT_CLICK_DATA_API = `click${EVENT_KEY}${DATA_API_KEY}`
const EVENT_LOAD_DATA_API = `load${EVENT_KEY}${DATA_API_KEY}`

const SELECTOR_OFFCANVAS = '.offcanvas'
const SELECTOR_DATA_API = '[data-bs-toggle="dropdown"][data-bs-trigger="hover"]'

const CLASS_NAME_DROPEND = 'dropend'
const CLASS_NAME_DROPSTART = 'dropstart'

class DropdownHover extends BaseComponent {
  constructor (element) {
    super(element)

    this.offcanvas = SelectorEngine.parents(this._element, SELECTOR_OFFCANVAS)[0]
    this.bsDropdown = new bootstrap.Dropdown(this._element)

    this._handler()
  }

  // Getters
  static get NAME () {
    return NAME
  }

  _handler () {
    EventHandler.on(this._element, EVENT_CLICK, event => {
      if (event.currentTarget.getAttribute('href') === '#') {
        event.preventDefault()
      }
    })
    EventHandler.on(this._element, EVENT_MOUSEOVER, () => this._show())
    EventHandler.on(this._element.parentNode, EVENT_MOUSELEAVE, () => this._hide())
  }

  _show () {
    if (!(this.offcanvas && this.offcanvas.classList.contains('show'))) {
      this._element.dataset.bsToggle = 'dropdown-hover'
      this.bsDropdown.show()
      this._element.blur()
      this._dropdownSubmenuHandler()
    }
  }

  _hide () {
    if (!(this.offcanvas && this.offcanvas.classList.contains('show'))) {
      this._element.dataset.bsToggle = 'dropdown'
      this.bsDropdown.hide()
      this._dropdownSubmenuHandler()
    }
  }

  _dropdownSubmenuHandler () {
    if (this.bsDropdown._menu.classList.contains('dropdown-menu-submenu')) {

      this.bsDropdown._parent.classList.add(CLASS_NAME_DROPEND)
      this.bsDropdown._parent.classList.remove(CLASS_NAME_DROPSTART)

      if (!this._elementVisible(this.bsDropdown._menu)) {
        this.bsDropdown._parent.classList.remove(CLASS_NAME_DROPEND)
        this.bsDropdown._parent.classList.add(CLASS_NAME_DROPSTART)
      }
    } else {
      this.bsDropdown._menu.classList.remove('dropdown-menu-end')

      if (!this._elementVisible(this.bsDropdown._menu)) {
        this.bsDropdown._menu.classList.add('dropdown-menu-end')
      }
    }
  }

  _elementVisible (el) {
    let rect = el.getBoundingClientRect()

    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <=
      (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <=
      (window.innerWidth || document.documentElement.clientWidth)
    )
  }
}

/**
 * Data API implementation
 */

EventHandler.on(window, EVENT_LOAD_DATA_API, () => {
  for (const selector of SelectorEngine.find(SELECTOR_DATA_API)) {
    DropdownHover.getOrCreateInstance(selector)
  }
})

export default DropdownHover
