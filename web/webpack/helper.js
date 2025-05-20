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

/***/ "./helpers/class.helper.ts":
/*!*********************************!*\
  !*** ./helpers/class.helper.ts ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   ClassHelper: () => (/* binding */ ClassHelper)\n/* harmony export */ });\nclass ClassHelper {\n    static init() {\n        alert(\"OK\");\n    }\n    static maxZIndex() {\n        let maxZ = 0;\n        const elements = document.getElementsByTagName('*');\n        for (let i = 0; i < elements.length; i++) {\n            const z = window.getComputedStyle(elements[i]).zIndex;\n            const zIndex = parseInt(z, 10);\n            if (!isNaN(zIndex)) {\n                maxZ = Math.max(maxZ, zIndex);\n            }\n        }\n        return maxZ;\n    }\n    static navigate(url, target = \"_self\") {\n        const link = document.createElement(\"a\");\n        link.href = url;\n        document.body.appendChild(link);\n        link.target = target;\n        link.click();\n        link.remove();\n    }\n    pascalToKebab(str) {\n        return str.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();\n    }\n}\n\n\n//# sourceURL=webpack://karsaiauto/./helpers/class.helper.ts?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
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
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./helpers/class.helper.ts"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;