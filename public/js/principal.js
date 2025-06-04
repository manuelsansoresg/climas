/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/components/cart.js":
/*!*****************************************!*\
  !*** ./resources/js/components/cart.js ***!
  \*****************************************/
/***/ (() => {

eval("document.addEventListener('DOMContentLoaded', function () {\n  var btn = document.getElementById('add-to-cart-btn');\n  if (!btn) return;\n  btn.addEventListener('click', function () {\n    var productId = btn.getAttribute('data-product-id');\n    var url = btn.getAttribute('data-url');\n    var csrfToken = btn.getAttribute('data-csrf');\n    fetch(url, {\n      method: 'POST',\n      headers: {\n        'Content-Type': 'application/json',\n        'X-CSRF-TOKEN': csrfToken\n      },\n      body: JSON.stringify({\n        product_id: productId,\n        quantity: 1\n      })\n    }).then(function (response) {\n      if (!response.ok) {\n        return response.json().then(function (err) {\n          return Promise.reject(err);\n        });\n      }\n      return response.json();\n    }).then(function (data) {\n      alert(data.message);\n    })[\"catch\"](function (error) {\n      if (error.message) {\n        alert('Error: ' + error.message);\n      } else {\n        alert('Error al agregar al carrito');\n      }\n      console.error(error);\n    });\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6WyJkb2N1bWVudCIsImFkZEV2ZW50TGlzdGVuZXIiLCJidG4iLCJnZXRFbGVtZW50QnlJZCIsInByb2R1Y3RJZCIsImdldEF0dHJpYnV0ZSIsInVybCIsImNzcmZUb2tlbiIsImZldGNoIiwibWV0aG9kIiwiaGVhZGVycyIsImJvZHkiLCJKU09OIiwic3RyaW5naWZ5IiwicHJvZHVjdF9pZCIsInF1YW50aXR5IiwidGhlbiIsInJlc3BvbnNlIiwib2siLCJqc29uIiwiZXJyIiwiUHJvbWlzZSIsInJlamVjdCIsImRhdGEiLCJhbGVydCIsIm1lc3NhZ2UiLCJlcnJvciIsImNvbnNvbGUiXSwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL2NvbXBvbmVudHMvY2FydC5qcz9mZDI4Il0sInNvdXJjZXNDb250ZW50IjpbImRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCBmdW5jdGlvbigpIHtcclxuICAgIGNvbnN0IGJ0biA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhZGQtdG8tY2FydC1idG4nKTtcclxuICAgIGlmICghYnRuKSByZXR1cm47XHJcblxyXG4gICAgYnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgY29uc3QgcHJvZHVjdElkID0gYnRuLmdldEF0dHJpYnV0ZSgnZGF0YS1wcm9kdWN0LWlkJyk7XHJcbiAgICAgICAgY29uc3QgdXJsID0gYnRuLmdldEF0dHJpYnV0ZSgnZGF0YS11cmwnKTtcclxuICAgICAgICBjb25zdCBjc3JmVG9rZW4gPSBidG4uZ2V0QXR0cmlidXRlKCdkYXRhLWNzcmYnKTtcclxuXHJcbiAgICAgICAgZmV0Y2godXJsLCB7XHJcbiAgICAgICAgICAgIG1ldGhvZDogJ1BPU1QnLFxyXG4gICAgICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICAgICAnQ29udGVudC1UeXBlJzogJ2FwcGxpY2F0aW9uL2pzb24nLFxyXG4gICAgICAgICAgICAgICAgJ1gtQ1NSRi1UT0tFTic6IGNzcmZUb2tlblxyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICBib2R5OiBKU09OLnN0cmluZ2lmeSh7IHByb2R1Y3RfaWQ6IHByb2R1Y3RJZCwgcXVhbnRpdHk6IDEgfSlcclxuICAgICAgICB9KVxyXG4gICAgICAgIC50aGVuKHJlc3BvbnNlID0+IHtcclxuICAgICAgICAgICAgaWYgKCFyZXNwb25zZS5vaykge1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuIHJlc3BvbnNlLmpzb24oKS50aGVuKGVyciA9PiBQcm9taXNlLnJlamVjdChlcnIpKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICByZXR1cm4gcmVzcG9uc2UuanNvbigpO1xyXG4gICAgICAgIH0pXHJcbiAgICAgICAgLnRoZW4oZGF0YSA9PiB7XHJcbiAgICAgICAgICAgIGFsZXJ0KGRhdGEubWVzc2FnZSk7XHJcbiAgICAgICAgfSlcclxuICAgICAgICAuY2F0Y2goZXJyb3IgPT4ge1xyXG4gICAgICAgICAgICBpZiAoZXJyb3IubWVzc2FnZSkge1xyXG4gICAgICAgICAgICAgICAgYWxlcnQoJ0Vycm9yOiAnICsgZXJyb3IubWVzc2FnZSk7XHJcbiAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICBhbGVydCgnRXJyb3IgYWwgYWdyZWdhciBhbCBjYXJyaXRvJyk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgY29uc29sZS5lcnJvcihlcnJvcik7XHJcbiAgICAgICAgfSk7XHJcbiAgICB9KTtcclxufSk7Il0sIm1hcHBpbmdzIjoiQUFBQUEsUUFBUSxDQUFDQyxnQkFBZ0IsQ0FBQyxrQkFBa0IsRUFBRSxZQUFXO0VBQ3JELElBQU1DLEdBQUcsR0FBR0YsUUFBUSxDQUFDRyxjQUFjLENBQUMsaUJBQWlCLENBQUM7RUFDdEQsSUFBSSxDQUFDRCxHQUFHLEVBQUU7RUFFVkEsR0FBRyxDQUFDRCxnQkFBZ0IsQ0FBQyxPQUFPLEVBQUUsWUFBVztJQUNyQyxJQUFNRyxTQUFTLEdBQUdGLEdBQUcsQ0FBQ0csWUFBWSxDQUFDLGlCQUFpQixDQUFDO0lBQ3JELElBQU1DLEdBQUcsR0FBR0osR0FBRyxDQUFDRyxZQUFZLENBQUMsVUFBVSxDQUFDO0lBQ3hDLElBQU1FLFNBQVMsR0FBR0wsR0FBRyxDQUFDRyxZQUFZLENBQUMsV0FBVyxDQUFDO0lBRS9DRyxLQUFLLENBQUNGLEdBQUcsRUFBRTtNQUNQRyxNQUFNLEVBQUUsTUFBTTtNQUNkQyxPQUFPLEVBQUU7UUFDTCxjQUFjLEVBQUUsa0JBQWtCO1FBQ2xDLGNBQWMsRUFBRUg7TUFDcEIsQ0FBQztNQUNESSxJQUFJLEVBQUVDLElBQUksQ0FBQ0MsU0FBUyxDQUFDO1FBQUVDLFVBQVUsRUFBRVYsU0FBUztRQUFFVyxRQUFRLEVBQUU7TUFBRSxDQUFDO0lBQy9ELENBQUMsQ0FBQyxDQUNEQyxJQUFJLENBQUMsVUFBQUMsUUFBUSxFQUFJO01BQ2QsSUFBSSxDQUFDQSxRQUFRLENBQUNDLEVBQUUsRUFBRTtRQUNkLE9BQU9ELFFBQVEsQ0FBQ0UsSUFBSSxDQUFDLENBQUMsQ0FBQ0gsSUFBSSxDQUFDLFVBQUFJLEdBQUc7VUFBQSxPQUFJQyxPQUFPLENBQUNDLE1BQU0sQ0FBQ0YsR0FBRyxDQUFDO1FBQUEsRUFBQztNQUMzRDtNQUNBLE9BQU9ILFFBQVEsQ0FBQ0UsSUFBSSxDQUFDLENBQUM7SUFDMUIsQ0FBQyxDQUFDLENBQ0RILElBQUksQ0FBQyxVQUFBTyxJQUFJLEVBQUk7TUFDVkMsS0FBSyxDQUFDRCxJQUFJLENBQUNFLE9BQU8sQ0FBQztJQUN2QixDQUFDLENBQUMsU0FDSSxDQUFDLFVBQUFDLEtBQUssRUFBSTtNQUNaLElBQUlBLEtBQUssQ0FBQ0QsT0FBTyxFQUFFO1FBQ2ZELEtBQUssQ0FBQyxTQUFTLEdBQUdFLEtBQUssQ0FBQ0QsT0FBTyxDQUFDO01BQ3BDLENBQUMsTUFBTTtRQUNIRCxLQUFLLENBQUMsNkJBQTZCLENBQUM7TUFDeEM7TUFDQUcsT0FBTyxDQUFDRCxLQUFLLENBQUNBLEtBQUssQ0FBQztJQUN4QixDQUFDLENBQUM7RUFDTixDQUFDLENBQUM7QUFDTixDQUFDLENBQUMiLCJpZ25vcmVMaXN0IjpbXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL2NvbXBvbmVudHMvY2FydC5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/components/cart.js\n");

/***/ }),

/***/ "./resources/js/principal.js":
/*!***********************************!*\
  !*** ./resources/js/principal.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

eval("__webpack_require__(/*! ./components/cart */ \"./resources/js/components/cart.js\");//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvcHJpbmNpcGFsLmpzIiwibWFwcGluZ3MiOiJBQUFBQSxtQkFBTyxDQUFDLDREQUFtQixDQUFDIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL3ByaW5jaXBhbC5qcz8yZjY4Il0sInNvdXJjZXNDb250ZW50IjpbInJlcXVpcmUoJy4vY29tcG9uZW50cy9jYXJ0Jyk7Il0sIm5hbWVzIjpbInJlcXVpcmUiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/principal.js\n");

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
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/principal.js");
/******/ 	
/******/ })()
;