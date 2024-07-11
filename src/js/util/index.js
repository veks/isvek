/**
 * --------------------------------------------------------------------------
 * Isvek (v1.0.0): util/index.js
 * Licensed under MIT
 * --------------------------------------------------------------------------
 */

/**
 * To type
 *
 * @param obj
 * @returns {string}
 */
const toType = obj => {
    if (obj === null || obj === undefined) {
        return `${obj}`
    }

    return {}.toString.call(obj).match(/\s([a-z]+)/i)[1].toLowerCase()
}

/**
 * Is element
 *
 * @param obj
 * @returns {boolean}
 */
const isElement = obj => {
    if (!obj || typeof obj !== 'object') {
        return false
    }

    return typeof obj.nodeType !== 'undefined'
}

/**
 * Check config
 *
 * @param config
 * @param configTypes
 * @param configOptions
 */
const checkConfig = (config, configTypes, configOptions) => {
    getObjectKey(configTypes, key => {
        const expectedTypes = configTypes[key]
        const value = config[key]
        const valueType = value && isElement(value) ? 'element' : toType(value)

        if (!new RegExp(expectedTypes).test(valueType)) {
            throw new TypeError(`isvek-theme console: Опция "${key}" предоставленный тип "${valueType}", ожидаемый тип "${expectedTypes}".`,)
        }
    })

    getObjectKey(configOptions, key => {
        const expectedOptions = configOptions[key]
        const value = config[key]

        if (!new RegExp(expectedOptions).test(value)) {
            throw new TypeError(`isvek-theme console: Опция "${key}" параметр "${value}", ожидаемый параметр "${expectedOptions}".`,)
        }
    })
}

/**
 * Plural at word
 *
 * @param number
 * @param text
 * @returns {`${string} ${string}`}
 */
const pluralAtWord = (number, text = ['пиксель', 'пикселя', 'пикселей']) => {
    if (number % 10 === 1 && number % 100 !== 11) {
        return `${number} ${text[0]}`
    } else if (number % 10 >= 2 && number % 10 <= 4 && (number % 100 < 10 || number % 100 >= 20)) {
        return `${number} ${text[1]}`
    } else {
        return `${number} ${text[2]}`
    }
}

/**
 * String to boolean
 *
 * @param string
 * @returns {boolean}
 */
const stringToBoolean = string => {
    switch (string) {
        case 'on':
        case 'true':
        case '1':
            return true
        default:
            return false
    }
}

/**
 * wrapInner
 *
 * @param parent
 * @param wrapper
 * @param className
 */
const wrapInner = (parent, wrapper, className) => {
    if (typeof wrapper === 'string') {
        wrapper = document.createElement(wrapper)
    }

    parent.appendChild(wrapper).className = className

    while (parent.firstChild !== wrapper) {
        wrapper.appendChild(parent.firstChild)
    }
}

/**
 * Unwrap
 *
 * @param wrapper
 */
const unwrap = wrapper => {
    let docFrag = document.createDocumentFragment()

    if (!wrapper) return

    while (wrapper.firstChild) {
        docFrag.appendChild(wrapper.removeChild(wrapper.firstChild))
    }

    wrapper.parentNode.replaceChild(docFrag, wrapper)
}

/**
 * Get object key
 *
 * @param object
 * @param callback
 */
const getObjectKey = (object, callback) => Object.keys(object).forEach(key => typeof callback === 'function' ? callback(key) : null)

/**
 * Get object value
 *
 * @param object
 * @param callback
 */
const getObjectValue = (object, callback) => typeof callback === 'function' ? getObjectKey(object, key => callback(object[key])) : null

/**
 * Get array
 *
 * @param array
 * @param callback
 */
const getArrayKey = (array, callback) => Array.from(array).forEach(key => typeof callback === 'function' ? callback(key) : null)

/**
 * Text transform upper case
 *
 * @param string
 * @returns {string|string}
 */
const textTransformUpperCase = string => (string && string.charAt(0).toUpperCase() + string.slice(1)) || ''

/**
 * Text transform lower case
 *
 * @param string
 * @returns {string|string}
 */
const textTransformLowerCase = string => (string && string.charAt(0).toLowerCase() + string.slice(1)) || ''

/**
 * In array
 *
 * @param needle
 * @param haystack
 * @returns {boolean}
 */
const inArray = (needle, haystack) => {
    for (let i = 0; i < haystack.length; i++) {
        if (haystack[i] === needle) {
            return true
        }
    }

    return false
}

const setCookie = function (name = '', value = '') {
    let now = new Date()
    let time = now.getTime()
    time += 24 * 60 * 60 * 1000
    now.setTime(time)
    document.cookie = `isvek-theme-${name}=${value};path=/;expires=${now.toUTCString()};domain=${location.host}`
}

const getCookie = function (name = '') {
    name = `isvek-theme-${name}=`
    let decodedCookie = decodeURIComponent(document.cookie)
    let cookies = decodedCookie.split(';')

    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].trim()

        if (cookie.indexOf(name) !== -1) {
            return cookie.substring(name.length, cookie.length)
        }
    }
}

const removeCookie = function (name = '') {
    document.cookie = `isvek-theme-${name}=;path=/;expires=Thu, 01 Jan 1970 00:00:01 GMT;domain=${location.host}`
}

const ajax = async (input, body, callback) => {
    if (typeof callback === 'function') {
        callback()
    }

    return await fetch(
        input,
        {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache',
                'charset': 'UTF-8',
            },
            body: new URLSearchParams(body),
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
}

const addEvent = (parent, evt, selector, handler) => {
    parent.addEventListener(evt, (event) => {
        if (event.target.matches(selector + ', ' + selector + ' *')) {
            handler.apply(event.target.closest(selector), arguments)
        }
    }, false)
}

export {
    isElement,
    pluralAtWord,
    checkConfig,
    stringToBoolean,
    wrapInner,
    unwrap,
    getObjectKey,
    getArrayKey,
    getObjectValue,
    inArray,
    textTransformLowerCase,
    getCookie,
    setCookie,
    removeCookie,
    ajax,
    addEvent
}
