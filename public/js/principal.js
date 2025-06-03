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

eval("document.addEventListener('DOMContentLoaded', function () {\n  var btn = document.getElementById('add-to-cart-btn');\n  if (!btn) return;\n  btn.addEventListener('click', function () {\n    var productId = btn.getAttribute('data-product-id');\n    var url = btn.getAttribute('data-url');\n    var csrfToken = btn.getAttribute('data-csrf');\n    fetch(url, {\n      method: 'POST',\n      headers: {\n        'Content-Type': 'application/json',\n        'X-CSRF-TOKEN': csrfToken\n      },\n      body: JSON.stringify({\n        product_id: productId,\n        quantity: 1\n      })\n    }).then(function (response) {\n      if (!response.ok) {\n        return response.json().then(function (err) {\n          return Promise.reject(err);\n        });\n      }\n      return response.json();\n    }).then(function (data) {\n      alert(data.message);\n    })[\"catch\"](function (error) {\n      if (error.message) {\n        alert('Error: ' + error.message);\n      } else {\n        alert('Error al agregar al carrito');\n      }\n      console.error(error);\n    });\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvY29tcG9uZW50cy9jYXJ0LmpzIiwibmFtZXMiOlsiZG9jdW1lbnQiLCJhZGRFdmVudExpc3RlbmVyIiwiYnRuIiwiZ2V0RWxlbWVudEJ5SWQiLCJwcm9kdWN0SWQiLCJnZXRBdHRyaWJ1dGUiLCJ1cmwiLCJjc3JmVG9rZW4iLCJmZXRjaCIsIm1ldGhvZCIsImhlYWRlcnMiLCJib2R5IiwiSlNPTiIsInN0cmluZ2lmeSIsInByb2R1Y3RfaWQiLCJxdWFudGl0eSIsInRoZW4iLCJyZXNwb25zZSIsIm9rIiwianNvbiIsImVyciIsIlByb21pc2UiLCJyZWplY3QiLCJkYXRhIiwiYWxlcnQiLCJtZXNzYWdlIiwiZXJyb3IiLCJjb25zb2xlIl0sInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvY29tcG9uZW50cy9jYXJ0LmpzP2ZkMjgiXSwic291cmNlc0NvbnRlbnQiOlsiZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignRE9NQ29udGVudExvYWRlZCcsIGZ1bmN0aW9uKCkge1xyXG4gICAgY29uc3QgYnRuID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2FkZC10by1jYXJ0LWJ0bicpO1xyXG4gICAgaWYgKCFidG4pIHJldHVybjtcclxuXHJcbiAgICBidG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbigpIHtcclxuICAgICAgICBjb25zdCBwcm9kdWN0SWQgPSBidG4uZ2V0QXR0cmlidXRlKCdkYXRhLXByb2R1Y3QtaWQnKTtcclxuICAgICAgICBjb25zdCB1cmwgPSBidG4uZ2V0QXR0cmlidXRlKCdkYXRhLXVybCcpO1xyXG4gICAgICAgIGNvbnN0IGNzcmZUb2tlbiA9IGJ0bi5nZXRBdHRyaWJ1dGUoJ2RhdGEtY3NyZicpO1xyXG5cclxuICAgICAgICBmZXRjaCh1cmwsIHtcclxuICAgICAgICAgICAgbWV0aG9kOiAnUE9TVCcsXHJcbiAgICAgICAgICAgIGhlYWRlcnM6IHtcclxuICAgICAgICAgICAgICAgICdDb250ZW50LVR5cGUnOiAnYXBwbGljYXRpb24vanNvbicsXHJcbiAgICAgICAgICAgICAgICAnWC1DU1JGLVRPS0VOJzogY3NyZlRva2VuXHJcbiAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgIGJvZHk6IEpTT04uc3RyaW5naWZ5KHsgcHJvZHVjdF9pZDogcHJvZHVjdElkLCBxdWFudGl0eTogMSB9KVxyXG4gICAgICAgIH0pXHJcbiAgICAgICAgLnRoZW4ocmVzcG9uc2UgPT4ge1xyXG4gICAgICAgICAgICBpZiAoIXJlc3BvbnNlLm9rKSB7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gcmVzcG9uc2UuanNvbigpLnRoZW4oZXJyID0+IFByb21pc2UucmVqZWN0KGVycikpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHJldHVybiByZXNwb25zZS5qc29uKCk7XHJcbiAgICAgICAgfSlcclxuICAgICAgICAudGhlbihkYXRhID0+IHtcclxuICAgICAgICAgICAgYWxlcnQoZGF0YS5tZXNzYWdlKTtcclxuICAgICAgICB9KVxyXG4gICAgICAgIC5jYXRjaChlcnJvciA9PiB7XHJcbiAgICAgICAgICAgIGlmIChlcnJvci5tZXNzYWdlKSB7XHJcbiAgICAgICAgICAgICAgICBhbGVydCgnRXJyb3I6ICcgKyBlcnJvci5tZXNzYWdlKTtcclxuICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgIGFsZXJ0KCdFcnJvciBhbCBhZ3JlZ2FyIGFsIGNhcnJpdG8nKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBjb25zb2xlLmVycm9yKGVycm9yKTtcclxuICAgICAgICB9KTtcclxuICAgIH0pO1xyXG59KTsiXSwibWFwcGluZ3MiOiJBQUFBQSxRQUFRLENBQUNDLGdCQUFnQixDQUFDLGtCQUFrQixFQUFFLFlBQVc7RUFDckQsSUFBTUMsR0FBRyxHQUFHRixRQUFRLENBQUNHLGNBQWMsQ0FBQyxpQkFBaUIsQ0FBQztFQUN0RCxJQUFJLENBQUNELEdBQUcsRUFBRTtFQUVWQSxHQUFHLENBQUNELGdCQUFnQixDQUFDLE9BQU8sRUFBRSxZQUFXO0lBQ3JDLElBQU1HLFNBQVMsR0FBR0YsR0FBRyxDQUFDRyxZQUFZLENBQUMsaUJBQWlCLENBQUM7SUFDckQsSUFBTUMsR0FBRyxHQUFHSixHQUFHLENBQUNHLFlBQVksQ0FBQyxVQUFVLENBQUM7SUFDeEMsSUFBTUUsU0FBUyxHQUFHTCxHQUFHLENBQUNHLFlBQVksQ0FBQyxXQUFXLENBQUM7SUFFL0NHLEtBQUssQ0FBQ0YsR0FBRyxFQUFFO01BQ1BHLE1BQU0sRUFBRSxNQUFNO01BQ2RDLE9BQU8sRUFBRTtRQUNMLGNBQWMsRUFBRSxrQkFBa0I7UUFDbEMsY0FBYyxFQUFFSDtNQUNwQixDQUFDO01BQ0RJLElBQUksRUFBRUMsSUFBSSxDQUFDQyxTQUFTLENBQUM7UUFBRUMsVUFBVSxFQUFFVixTQUFTO1FBQUVXLFFBQVEsRUFBRTtNQUFFLENBQUM7SUFDL0QsQ0FBQyxDQUFDLENBQ0RDLElBQUksQ0FBQyxVQUFBQyxRQUFRLEVBQUk7TUFDZCxJQUFJLENBQUNBLFFBQVEsQ0FBQ0MsRUFBRSxFQUFFO1FBQ2QsT0FBT0QsUUFBUSxDQUFDRSxJQUFJLENBQUMsQ0FBQyxDQUFDSCxJQUFJLENBQUMsVUFBQUksR0FBRztVQUFBLE9BQUlDLE9BQU8sQ0FBQ0MsTUFBTSxDQUFDRixHQUFHLENBQUM7UUFBQSxFQUFDO01BQzNEO01BQ0EsT0FBT0gsUUFBUSxDQUFDRSxJQUFJLENBQUMsQ0FBQztJQUMxQixDQUFDLENBQUMsQ0FDREgsSUFBSSxDQUFDLFVBQUFPLElBQUksRUFBSTtNQUNWQyxLQUFLLENBQUNELElBQUksQ0FBQ0UsT0FBTyxDQUFDO0lBQ3ZCLENBQUMsQ0FBQyxTQUNJLENBQUMsVUFBQUMsS0FBSyxFQUFJO01BQ1osSUFBSUEsS0FBSyxDQUFDRCxPQUFPLEVBQUU7UUFDZkQsS0FBSyxDQUFDLFNBQVMsR0FBR0UsS0FBSyxDQUFDRCxPQUFPLENBQUM7TUFDcEMsQ0FBQyxNQUFNO1FBQ0hELEtBQUssQ0FBQyw2QkFBNkIsQ0FBQztNQUN4QztNQUNBRyxPQUFPLENBQUNELEtBQUssQ0FBQ0EsS0FBSyxDQUFDO0lBQ3hCLENBQUMsQ0FBQztFQUNOLENBQUMsQ0FBQztBQUNOLENBQUMsQ0FBQyIsImlnbm9yZUxpc3QiOltdfQ==\n//# sourceURL=webpack-internal:///./resources/js/components/cart.js\n");

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