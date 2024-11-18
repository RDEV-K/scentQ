/******/
(function (modules) { // webpackBootstrap
    /******/ 	// The module cache
    /******/
    var installedModules = {};
    /******/
    /******/ 	// The require function
    /******/
    function __webpack_require__(moduleId) {
        /******/
        /******/ 		// Check if module is in cache
        /******/
        if (installedModules[moduleId]) {
            /******/
            return installedModules[moduleId].exports;
            /******/
        }
        /******/ 		// Create a new module (and put it into the cache)
        /******/
        var module = installedModules[moduleId] = {
            /******/            i: moduleId,
            /******/            l: false,
            /******/            exports: {}
            /******/
        };
        /******/
        /******/ 		// Execute the module function
        /******/
        modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
        /******/
        /******/ 		// Flag the module as loaded
        /******/
        module.l = true;
        /******/
        /******/ 		// Return the exports of the module
        /******/
        return module.exports;
        /******/
    }

    /******/
    /******/
    /******/ 	// expose the modules object (__webpack_modules__)
    /******/
    __webpack_require__.m = modules;
    /******/
    /******/ 	// expose the module cache
    /******/
    __webpack_require__.c = installedModules;
    /******/
    /******/ 	// define getter function for harmony exports
    /******/
    __webpack_require__.d = function (exports, name, getter) {
        /******/
        if (!__webpack_require__.o(exports, name)) {
            /******/
            Object.defineProperty(exports, name, {enumerable: true, get: getter});
            /******/
        }
        /******/
    };
    /******/
    /******/ 	// define __esModule on exports
    /******/
    __webpack_require__.r = function (exports) {
        /******/
        if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
            /******/
            Object.defineProperty(exports, Symbol.toStringTag, {value: 'Module'});
            /******/
        }
        /******/
        Object.defineProperty(exports, '__esModule', {value: true});
        /******/
    };
    /******/
    /******/ 	// create a fake namespace object
    /******/ 	// mode & 1: value is a module id, require it
    /******/ 	// mode & 2: merge all properties of value into the ns
    /******/ 	// mode & 4: return value when already ns object
    /******/ 	// mode & 8|1: behave like require
    /******/
    __webpack_require__.t = function (value, mode) {
        /******/
        if (mode & 1) value = __webpack_require__(value);
        /******/
        if (mode & 8) return value;
        /******/
        if ((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
        /******/
        var ns = Object.create(null);
        /******/
        __webpack_require__.r(ns);
        /******/
        Object.defineProperty(ns, 'default', {enumerable: true, value: value});
        /******/
        if (mode & 2 && typeof value != 'string') for (var key in value) __webpack_require__.d(ns, key, function (key) {
            return value[key];
        }.bind(null, key));
        /******/
        return ns;
        /******/
    };
    /******/
    /******/ 	// getDefaultExport function for compatibility with non-harmony modules
    /******/
    __webpack_require__.n = function (module) {
        /******/
        var getter = module && module.__esModule ?
            /******/            function getDefault() {
                return module['default'];
            } :
            /******/            function getModuleExports() {
                return module;
            };
        /******/
        __webpack_require__.d(getter, 'a', getter);
        /******/
        return getter;
        /******/
    };
    /******/
    /******/ 	// Object.prototype.hasOwnProperty.call
    /******/
    __webpack_require__.o = function (object, property) {
        return Object.prototype.hasOwnProperty.call(object, property);
    };
    /******/
    /******/ 	// __webpack_public_path__
    /******/
    __webpack_require__.p = "/";
    /******/
    /******/
    /******/ 	// Load entry module and return exports
    /******/
    return __webpack_require__(__webpack_require__.s = 3);
    /******/
})
    /************************************************************************/
    /******/ ({

    /***/ "./resources/js/select2.vue.js":
    /*!*************************************!*\
      !*** ./resources/js/select2.vue.js ***!
      \*************************************/
    /*! no static exports found */
    /***/ (function (module, exports) {

        window.select2Vue = Vue.component('select2', {
            props: ['options', 'value', 'onchange', 'ajax', 'allowClear', 'placeholder', 'minimumInputLength', 'tags'],
            template: '<select><slot></slot></select>',
            data: function data() {
                return {
                    settings: {}
                }
            },
            beforeMount: function beforeMount() {
                var vm = this;
                if (typeof this.options == 'object') {
                    this.settings.data = this.options
                }
                if (typeof this.allowClear == 'boolean') {
                    this.settings.allowClear = this.allowClear
                }
                if (typeof this.placeholder != 'undefined') {
                    this.settings.placeholder = this.placeholder
                }
                if (typeof this.minimumInputLength != 'undefined') {
                    this.settings.minimumInputLength = this.minimumInputLength
                }
                if (typeof this.tags != 'undefined') {
                    this.settings.tags = true
                    this.settings.tokenSeparators = [',', '|']
                    this.settings.createTag = function (params) {
                        var term = $.trim(params.term);
                        if (term === '') {
                            return null;
                        }
                        return {
                            id: term,
                            text: term,
                            newTag: true // add additional parameters
                        }
                    }
                }
                if (typeof this.ajax == 'object') {
                    this.settings.escapeMarkup = function (m) {
                        return m;
                    };
                    this.settings.ajax = {
                        url: this.ajax.url,
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                term: params.term
                            };
                        },
                        processResults: function (data) {
                            var terms = [];
                            if (data) {
                                let idKey = 'id'
                                let textKey = 'text'
                                if (typeof vm.ajax.data == 'object') {
                                    idKey = vm.ajax.data.id
                                    textKey = vm.ajax.data.text
                                }
                                terms = data.map(d => {
                                    terms.push({id: d[idKey], text: d[textKey]});
                                })
                            }
                            return {
                                results: terms
                            };
                        },
                        cache: true
                    }
                }
            },
            mounted: function mounted() {
                var vm = this;
                $(this.$el) // init select2
                    .select2(this.settings).val(this.value).trigger('change', {
                    ignore: true
                }) // emit event on change.
                    .on('change', function (ev, args) {
                        if (!(args && "ignore" in args)) {
                            vm.$emit('input', $(this).val());
                        }
                    });
            },
            watch: {
                value: function value(_value) {
                    // update value
                    $(this.$el).val(_value).trigger('change', {
                        ignore: true
                    });
                },
                options: function options(_options) {
                    var vm = this;
                    this.settings.data = _options
                    // update options
                    $(this.$el).empty().select2(this.settings).val(this.value).trigger('change', {
                        ignore: true
                    }) // emit event on change.
                        .on('change', function (ev, args) {
                            if (!(args && "ignore" in args)) {
                                vm.$emit('input', $(this).val());
                            }
                        });
                }
            },
            destroyed: function destroyed() {
                $(this.$el).off().select2('destroy');
            }
        });

        /***/
    }),

    /***/ 3:
    /*!*******************************************!*\
      !*** multi ./resources/js/select2.vue.js ***!
      \*******************************************/
    /*! no static exports found */
    /***/ (function (module, exports, __webpack_require__) {

        module.exports = __webpack_require__(/*! /home/yhshanto/Projects/binary-operations/binary-travel/resources/js/select2.vue.js */"./resources/js/select2.vue.js");


        /***/
    })

    /******/
});
