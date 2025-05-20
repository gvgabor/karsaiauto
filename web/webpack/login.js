/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./helpers/class.login.ts":
/*!********************************!*\
  !*** ./helpers/class.login.ts ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   ClassLogin: () => (/* binding */ ClassLogin)\n/* harmony export */ });\n/* harmony import */ var _class_util__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./class.util */ \"./helpers/class.util.ts\");\n\nclass ClassLogin extends _class_util__WEBPACK_IMPORTED_MODULE_0__.ClassUtil {\n    init() {\n        const loginForm = document.getElementById(\"login-form\");\n        const url = \"/index/login\";\n        const loginBtn = this.button(\"login-btn\");\n        loginBtn.onclick = async () => {\n            const formData = new FormData(loginForm);\n            const response = await this.fetchForm(url, formData);\n            if (response.success) {\n                this.navigate(response.url);\n            }\n            else {\n                this.showFormError(\"felhasznalok\", loginForm, response.errors);\n            }\n        };\n    }\n}\n\n\n//# sourceURL=webpack://karsaiauto/./helpers/class.login.ts?");

/***/ }),

/***/ "./helpers/class.util.ts":
/*!*******************************!*\
  !*** ./helpers/class.util.ts ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   ClassUtil: () => (/* binding */ ClassUtil)\n/* harmony export */ });\nclass ClassUtil {\n    url(action) {\n        console.log({\n            origin: window.location.origin,\n            pathname: window.location.pathname,\n        });\n        const endPoint = (window.location.origin + window.location.pathname).replace(/\\/+$/, '');\n        return `${endPoint}/${action}`;\n    }\n    get schema() {\n        return {\n            model: {\n                id: \"id\",\n                fields: {\n                    id: { type: \"number\" }\n                }\n            },\n            data: (response) => response.data || [],\n            total: (response) => response.total || 0\n        };\n    }\n    input(id) {\n        return document.getElementById(id) ?? document.createElement(\"button\");\n    }\n    /**\n     *\n     * @param {string} model\n     * @param {HTMLFormElement} form\n     * @param {Object} errors\n     */\n    showFormError(model, form, errors) {\n        form.querySelectorAll(`div.error-box`).forEach(item => item.remove());\n        for (const [key, value] of Object.entries(errors)) {\n            /**@type {HTMLDivElement | null} **/\n            const fieldBox = form.querySelector(`div.field-${model}-${key}`);\n            const errorBox = document.createElement(\"div\");\n            errorBox.classList.add(\"error-box\");\n            errorBox.innerHTML = value[0];\n            if (fieldBox) {\n                fieldBox.appendChild(errorBox);\n                requestAnimationFrame(() => errorBox.classList.add(\"show\"));\n            }\n        }\n    }\n    async fetchDelete(url, id) {\n        const response = await fetch(`${url}/${id}`, {\n            method: \"DELETE\",\n            headers: {\n                \"X-Requested-With\": \"XMLHttpRequest\",\n                \"X-CSRF-Token\": yii.getCsrfToken(),\n            },\n        });\n        const contentType = response.headers.get(\"content-type\");\n        if (contentType?.includes(\"application/json\")) {\n            return await response.json();\n        }\n        else {\n            return await response.text();\n        }\n    }\n    async fetchForm(url, formData, form, addlayer = true) {\n        const layer = document.createElement(\"div\");\n        if (addlayer) {\n            layer.classList.add(\"popup-layer\");\n            layer.style.zIndex = (this.maxZIndex + 1).toString();\n            document.body.appendChild(layer);\n            layer.classList.add(\"animate\");\n        }\n        formData.append(\"_csrf\", yii.getCsrfToken());\n        let response = await fetch(url, {\n            method: \"POST\",\n            body: formData\n        });\n        const success = [200, 201];\n        if (success.includes(response.status)) {\n            return response.json();\n        }\n        else {\n            alert(\"OK\");\n        }\n        console.log(response);\n        // let responseData;\n        // const contentType = response.headers.get(\"content-type\");\n        // if (contentType && contentType.includes(\"application/json\")) {\n        //     responseData = await response.json();\n        // } else {\n        //     responseData = await response.text();\n        // }\n        //\n        // if (addlayer) {\n        //     layer.remove();\n        // }\n    }\n    async fetchData(url, data = {}, addlayer = true) {\n        const def = jQuery.Deferred();\n        const formData = new FormData();\n        const layer = document.createElement(\"div\");\n        if (addlayer) {\n            layer.classList.add(\"popup-layer\");\n            layer.style.zIndex = (this.maxZIndex + 1).toString();\n            document.body.appendChild(layer);\n            layer.classList.add(\"animate\");\n        }\n        formData.append(\"_csrf\", yii.getCsrfToken());\n        for (const [key, value] of Object.entries(data)) {\n            formData.append(key, value);\n        }\n        const response = await fetch(url, {\n            headers: {\n                'X-Requested-With': 'XMLHttpRequest' // Ezzel mondjuk meg, hogy ajax kérés\n            },\n            body: formData,\n            method: \"POST\"\n        });\n        let responseData;\n        const contentType = response.headers.get(\"content-type\");\n        if (typeof contentType === \"string\" && contentType.includes(\"application/json\")) {\n            responseData = await response.json();\n        }\n        else {\n            responseData = await response.text();\n        }\n        if (layer) {\n            layer.remove();\n        }\n        def.resolve(responseData);\n        return def;\n    }\n    urlPart(action) {\n        const path = new URL(window.location.href);\n        const pathmame = path.pathname;\n        return `${pathmame}/${action}`;\n    }\n    /**\n     * @return {Object}\n     */\n    get transport() {\n        const data = {};\n        data._csrf = yii.getCsrfToken(); // Feltételezi, hogy a \"yii\" globális objektumot használhatja\n        return {\n            read: {\n                type: \"POST\",\n                url: null, // Alapértelmezett érték null\n                data: data,\n                dataType: \"json\"\n            }\n        };\n    }\n    confirm(text, element) {\n        const def = jQuery.Deferred();\n        const popover = jQuery(element).kendoPopover({\n            body: () => {\n                return `<div class=\"confirm-body\"><i class=\"fa fa-question-circle\"></i><div>${text}</div><div><button class=\"btn btn-primary btn\" data-name=\"no-btn\">Nem</button><button class=\"btn btn-danger btn\" data-name=\"yes-btn\">Igen</button></div></div>`;\n            },\n            width: 400,\n            position: \"left\",\n            header: () => {\n                return \"Megerősítés\";\n            },\n            showOn: \"click\",\n            show: event => {\n                const noBtn = event.sender.popup.element?.[0]?.querySelector(`button[data-name=\"no-btn\"]`);\n                if (noBtn) {\n                    noBtn.onclick = () => {\n                        event.sender.hide();\n                    };\n                }\n                const yesBtn = event.sender.popup.element?.[0]?.querySelector(`button[data-name=\"yes-btn\"]`);\n                if (yesBtn) {\n                    yesBtn.onclick = () => {\n                        def.resolve();\n                        event.sender.hide();\n                    };\n                }\n            },\n            hide: () => {\n                document.body.querySelectorAll(`div.confirm-body`).forEach(item => {\n                    item.closest(`div.k-animation-container`)?.remove();\n                });\n            }\n        }).data(\"kendoPopover\");\n        if (popover) {\n            // @ts-ignore\n            popover.show();\n        }\n        return def;\n    }\n    button(id) {\n        return document.getElementById(id);\n    }\n    div(id) {\n        return document.getElementById(id);\n    }\n    async delete(url, id) {\n        const urlWithParams = new URL(window.location.origin + \"/\" + this.pascalToKebab(url));\n        urlWithParams.searchParams.append(\"id\", id.toString());\n        try {\n            const response = await fetch(urlWithParams.toString(), {\n                method: \"DELETE\",\n                headers: {\n                    'X-CSRF-Token': yii.getCsrfToken(),\n                    'Accept': 'application/json'\n                }\n            });\n            const data = await response.json();\n            if (!response.ok) {\n                // A hibát előbb naplózzuk, majd kidobjuk újra (felsőbb rétegek számára biztosítva)\n                console.error(\"Hiba a válaszban:\", data.message || 'Ismeretlen hiba történt.');\n                throw new Error(data.message || 'Ismeretlen hiba történt.');\n            }\n            return data;\n        }\n        catch (error) {\n            console.error(\"DELETE hiba:\", error.message);\n            // Továbbadjuk a hibát\n            throw error;\n        }\n    }\n    get maxZIndex() {\n        let maxZ = 0;\n        const elements = document.getElementsByTagName('*');\n        for (let i = 0; i < elements.length; i++) {\n            const z = window.getComputedStyle(elements[i]).zIndex;\n            const zIndex = parseInt(z, 10);\n            if (!isNaN(zIndex)) {\n                maxZ = Math.max(maxZ, zIndex);\n            }\n        }\n        return maxZ;\n    }\n    navigate(url, target = \"_self\") {\n        const link = document.createElement(\"a\");\n        link.href = url;\n        document.body.appendChild(link);\n        link.target = target;\n        link.click();\n        link.remove();\n    }\n    pascalToKebab(str) {\n        return str.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();\n    }\n    /**\n     * @param element HTML elem\n     * @param url adat URL\n     * @param autoBind automatikus kötés\n     * @param columns\n     * @return {Promise<kendo.ui.Grid>}\n     */\n    grid(element, url, autoBind = true, columns = []) {\n        return new Promise((resolve) => {\n            const schema = this.schema;\n            const transport = this.transport;\n            transport.read.url = url;\n            const dataSource = new kendo.data.DataSource({\n                pageSize: 100,\n                transport: transport,\n                schema: schema\n            });\n            const grid = jQuery(element).kendoGrid({\n                columns: columns,\n                dataSource: dataSource,\n                filterable: this.filterable,\n                height: \"100%\",\n                pageable: {\n                    refresh: true\n                },\n                autoBind: autoBind,\n            }).data(\"kendoGrid\");\n            if (!grid) {\n                throw new Error(\"Failed to initialize kendoGrid.\");\n            }\n            if (autoBind) {\n                grid.bind(\"dataBound\", () => resolve(grid));\n            }\n            else {\n                resolve(grid);\n            }\n        });\n    }\n    get filterable() {\n        return {\n            extra: false,\n            operators: {\n                string: {\n                    contains: \"Tartalmazza\",\n                    eq: \"Egyenlő\"\n                }\n            }\n        };\n    }\n    /**\n     * @param grid kendo grid objektum\n     * @param callback hívási vissza\n     * @param call hívható\n     */\n    dataBound(grid, callback, call = true) {\n        grid.bind(\"dataBound\", callback);\n        if (call) {\n            callback();\n        }\n    }\n}\n\n\n//# sourceURL=webpack://karsaiauto/./helpers/class.util.ts?");

/***/ }),

/***/ "./views/assets/login.ts":
/*!*******************************!*\
  !*** ./views/assets/login.ts ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _helpers_class_login__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../helpers/class.login */ \"./helpers/class.login.ts\");\n\nnew _helpers_class_login__WEBPACK_IMPORTED_MODULE_0__.ClassLogin().init();\n\n\n//# sourceURL=webpack://karsaiauto/./views/assets/login.ts?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./views/assets/login.ts");
/******/ 	
/******/ })()
;