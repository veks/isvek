/**
 * --------------------------------------------------------------------------
 * Isvek (v1.0.1): search.js
 * Licensed under MIT
 * --------------------------------------------------------------------------
 */

document.addEventListener('DOMContentLoaded', () => {
  let searchForm = document.querySelector('.isvek-theme-search-form')

  const ajax = async event => {
    if (event.target.value.length > 3) {
      return await fetch(
        isvek_theme_search.url_ajax,
        {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Cache-Control': 'no-cache',
            'charset': 'UTF-8'
          },
          body: new URLSearchParams({
            action:  isvek_theme_search.action,
            s: event.target.value,
            security: isvek_theme_search.security
          })
        },
      ).then(response => response.json().then(data => ({
        ok: response.ok,
        status: response.status,
        statusText: response.statusText,
        ...data,
      }))).then(object => {
        if (object.ok === true && object.status === 200) {
          if (object.success === true) {
            return object.data
          }
          return false
        }
        return false
      }).catch(error => error)
    } else {
      return false
    }
  }

  if (searchForm) {
    let searchInput = searchForm.querySelector('.search-input')
    searchForm.addEventListener('mouseover', event => event.stopImmediatePropagation())
    searchInput.addEventListener('keyup', event => {
      let searchDataList = searchForm.querySelector('#isvek-theme-search-data-list')

      ajax(event).then(data => {
        Array.from(searchDataList.children).forEach(option => option.remove())

        if (Object.keys(data).length !== 0) {
          data.query.forEach((q) => {
            let option = document.createElement('option')
            option.value = q.title
            searchDataList.appendChild(option)
          })
        }
      })
    })
  }
})
