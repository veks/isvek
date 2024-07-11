/**
 * --------------------------------------------------------------------------
 * Isvek (v1.0.0): toasts.js
 * Licensed under MIT
 * --------------------------------------------------------------------------
 */

import {
  setCookie,
  getCookie,
  removeCookie,
  stringToBoolean
} from './util'

document.addEventListener('DOMContentLoaded', () => {
  let toastCookie = document.getElementById('toast-cookie')
  let toast = bootstrap.Toast.getOrCreateInstance(toastCookie, { autohide: false, animation: false })
  let cookieAgree = document.querySelector('.cookie-agree')

  if (toastCookie) {
    if (stringToBoolean(getCookie('cookie-agree'))) {
      toastCookie.classList.add('d-none')
      toast.hide()
    } else {
      toastCookie.classList.remove('d-none')
      toast.show()
    }

    cookieAgree.addEventListener('click', (event) => {
      event.preventDefault()

      setCookie('cookie-agree', 'true')

      toast.hide()
    })
  }
})
