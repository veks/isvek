/**
 * --------------------------------------------------------------------------
 *  (v1.0.0): navbar.js
 * Licensed under MIT
 * --------------------------------------------------------------------------
 */

import { stringToBoolean } from './util'

document.addEventListener('DOMContentLoaded', () => {
  const navbarElementList = document.querySelectorAll('[data-bs-navbar]')

  if (navbarElementList) {
    navbarElementList.forEach(navbarEl => {
      const offcanvasNavbar = document.getElementById('offcanvas-navbar')
      const dropdownElementList = navbarEl.querySelectorAll('.dropdown-toggle')
      const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl, { 'data-bs-display': 'none' }))
      const dataNavbarVisible = stringToBoolean(navbarEl.getAttribute('data-bs-visible'))
      const elementVisible = el => {
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

      const dropdown = event => {
        const instance = bootstrap.Dropdown.getInstance(event.target)

        if (instance) {
          if (instance._menu.classList.contains('dropdown-submenu')) {

            instance._parent.classList.add('dropend')
            instance._parent.classList.remove('dropstart')

            if (dataNavbarVisible && !elementVisible(instance._menu)) {
              instance._parent.classList.remove('dropend')
              instance._parent.classList.add('dropstart')
            }

          } else {
            instance._menu.classList.remove('dropdown-menu-end')

            if (dataNavbarVisible && !elementVisible(instance._menu)) {
              instance._menu.classList.add('dropdown-menu-end')
            }
          }
        }
      }
      const navbar = el => {
        if (el._menu) {
          el._element.addEventListener('mouseover', event => {
            dropdown(event)
          })

          el._element.addEventListener('keydown', event => {
            dropdown(event)
          })
        }
      }

      if (dropdownList) {
        dropdownList.map(dropdown => {

          window.addEventListener('resize', () => {
            navbar(dropdown)
          })

          navbar(dropdown)

          if (offcanvasNavbar) {
            offcanvasNavbar.addEventListener('hide.bs.offcanvas', event => {
              dropdown.hide()

              dropdown._menu.setAttribute('data-bs-popper', 'none')
            })

            offcanvasNavbar.addEventListener('hidden.bs.offcanvas', event => {
              dropdown.hide()

              dropdown._menu.setAttribute('data-bs-popper', 'none')
            })
          }
        })
      }
    })
  }
})
