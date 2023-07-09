/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/components/dimentions-control/index.js":
/*!****************************************************!*\
  !*** ./src/components/dimentions-control/index.js ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);


/**
 * WordPress dependencies
 */



/**
 * DimensionsControl controls
 */

const DimensionsControl = props => {
  const {
    setAttributes,
    lavel,
    dimensions,
    device,
    attributesKey
  } = props;

  const onChangeData = (newValue, dataKey) => {
    const newDimensions = { ...dimensions
    };

    if (props.responsive && props.device) {
      let linkAll = dimensions.link ? dimensions.link : 'yes';

      if (linkAll === 'yes') {
        newDimensions[device] = {
          top: newValue,
          right: newValue,
          bottom: newValue,
          left: newValue
        };
        newDimensions.link = 'yes';
        newDimensions.unit = dimensions.unit ? dimensions.unit : 'px';
      } else {
        newDimensions[device] = {
          top: newDimensions[device].top !== '' ? newDimensions[device].top : '0',
          right: newDimensions[device].right !== '' ? newDimensions[device].right : '0',
          bottom: newDimensions[device].bottom !== '' ? newDimensions[device].bottom : '0',
          left: newDimensions[device].left !== '' ? newDimensions[device].left : '0',
          link: 'no',
          unit: newDimensions[device].unit !== '' ? newDimensions[device].unit : 'px',
          [dataKey]: newValue
        };
        newDimensions.link = 'no';
        newDimensions.unit = dimensions.unit !== '' ? dimensions.unit : 'px';
      }

      console.log(newDimensions);
    } else {
      if (newDimensions.link === 'yes') {
        newDimensions.top = newValue;
        newDimensions.right = newValue;
        newDimensions.bottom = newValue;
        newDimensions.left = newValue;
        newDimensions.link = 'yes';
      } else {
        newDimensions.top = newDimensions.top !== '' ? newDimensions.top : '0';
        newDimensions.right = newDimensions.right !== '' ? newDimensions.right : '0';
        newDimensions.bottom = newDimensions.bottom !== '' ? newDimensions.bottom : '0';
        newDimensions.left = newDimensions.left !== '' ? newDimensions.left : '0';
        newDimensions.link = 'no';
        newDimensions[dataKey] = newValue;
      }
    }

    setAttributes({
      [attributesKey]: newDimensions
    });
  };

  const onClickUnit = event => {
    const newDimensions = { ...dimensions
    };
    newDimensions.unit = event.target.value;
    setAttributes({
      [attributesKey]: newDimensions
    });
  };

  const setLinkAllHandler = () => {
    const newDimensions = { ...dimensions
    };

    if (newDimensions.link === 'yes') {
      newDimensions.link = 'no';
    } else {
      newDimensions.link = 'yes';
    }

    setAttributes({
      [attributesKey]: newDimensions
    });
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wp-block-selector-ht-contactform-dimensions-control"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelRow, {
    className: 'ht-contactform-panel-row-height-auto',
    style: {
      minHeight: 'auto'
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", null, lavel), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ButtonGroup, {
    className: "ht-contactform-dimensions-btn-group"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    value: "px",
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('PX', 'ht-contactform'),
    isPrimary: dimensions.unit === 'px',
    isSecondary: dimensions.unit !== 'px',
    onClick: onClickUnit,
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('PX', 'ht-contactform'),
    focus: false
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    value: "%",
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('%', 'ht-contactform'),
    isPrimary: dimensions.unit === '%',
    isSecondary: dimensions.unit !== '%',
    onClick: onClickUnit,
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('%', 'ht-contactform'),
    focus: false
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    value: "em",
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('EM', 'ht-contactform'),
    isPrimary: dimensions.unit === 'em',
    isSecondary: dimensions.unit !== 'em',
    onClick: onClickUnit,
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('EM', 'ht-contactform'),
    focus: false
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalNumberControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Top', 'ht-contactform'),
    isShiftStepEnabled: true,
    onChange: newValue => onChangeData(newValue, 'top'),
    shiftStep: 10,
    value: props.responsive && props.device ? dimensions[device].top : dimensions.top,
    labelPosition: 'bottom'
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalNumberControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Right', 'ht-contactform'),
    isShiftStepEnabled: true,
    onChange: newValue => onChangeData(newValue, 'right'),
    shiftStep: 10,
    value: props.responsive && props.device ? dimensions[device].right : dimensions.right,
    labelPosition: 'bottom'
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalNumberControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Bottom', 'ht-contactform'),
    isShiftStepEnabled: true,
    onChange: newValue => onChangeData(newValue, 'bottom'),
    shiftStep: 10,
    value: props.responsive && props.device ? dimensions[device].bottom : dimensions.bottom,
    labelPosition: 'bottom'
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalNumberControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Left', 'ht-contactform'),
    isShiftStepEnabled: true,
    onChange: newValue => onChangeData(newValue, 'left'),
    shiftStep: 10,
    value: props.responsive && props.device ? dimensions[device].left : dimensions.left,
    labelPosition: 'bottom'
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    icon: "admin-links",
    value: "yes",
    isPrimary: dimensions.link === 'yes',
    isSecondary: dimensions.link !== 'yes',
    onClick: setLinkAllHandler,
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Link values together', 'ht-contactform'),
    showTooltip: true
  }))));
};

/* harmony default export */ __webpack_exports__["default"] = (DimensionsControl);

/***/ }),

/***/ "./src/ht-contactform-block/Edit.js":
/*!******************************************!*\
  !*** ./src/ht-contactform-block/Edit.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _inspector__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./inspector */ "./src/ht-contactform-block/inspector.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);


/**
 * Internal dependencies
 */

/**
 * WordPress dependencies
 */




const {
  serverSideRender: ServerSideRender
} = wp;

class Edit extends _wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Component {
  render() {
    const {
      clientId,
      attributes,
      className,
      setAttributes
    } = this.props;
    const {
      formId,
      blockUniqId
    } = attributes;
    {
      blockUniqId == '' && setAttributes({
        blockUniqId: clientId
      });
    }
    const areaClasses = classnames__WEBPACK_IMPORTED_MODULE_2___default()(className, {
      [`ht-contactform-area-${attributes.align}`]: attributes.align
    });
    let htBlockUniqId = `ht-editor-bock-${blockUniqId}`;
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      id: htBlockUniqId,
      className: areaClasses
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ServerSideRender, {
      block: "block/ht-contactform",
      attributes: {
        formId: formId
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_inspector__WEBPACK_IMPORTED_MODULE_1__["default"], this.props));
  }

}

/* harmony default export */ __webpack_exports__["default"] = (Edit);

/***/ }),

/***/ "./src/ht-contactform-block/icon.js":
/*!******************************************!*\
  !*** ./src/ht-contactform-block/icon.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

/* harmony default export */ __webpack_exports__["default"] = ((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
  "aria-hidden": "true",
  focusable: "false",
  "data-prefix": "fas",
  "data-icon": "envelope-open-text",
  class: "svg-inline--fa fa-envelope-open-text fa-w-16",
  role: "img",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 512 512"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
  fill: "currentColor",
  d: "M176 216h160c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16H176c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16zm-16 80c0 8.84 7.16 16 16 16h160c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16H176c-8.84 0-16 7.16-16 16v16zm96 121.13c-16.42 0-32.84-5.06-46.86-15.19L0 250.86V464c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V250.86L302.86 401.94c-14.02 10.12-30.44 15.19-46.86 15.19zm237.61-254.18c-8.85-6.94-17.24-13.47-29.61-22.81V96c0-26.51-21.49-48-48-48h-77.55c-3.04-2.2-5.87-4.26-9.04-6.56C312.6 29.17 279.2-.35 256 0c-23.2-.35-56.59 29.17-73.41 41.44-3.17 2.3-6 4.36-9.04 6.56H96c-26.51 0-48 21.49-48 48v44.14c-12.37 9.33-20.76 15.87-29.61 22.81A47.995 47.995 0 0 0 0 200.72v10.65l96 69.35V96h320v184.72l96-69.35v-10.65c0-14.74-6.78-28.67-18.39-37.77z"
})));

/***/ }),

/***/ "./src/ht-contactform-block/index.js":
/*!*******************************************!*\
  !*** ./src/ht-contactform-block/index.js ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Edit__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Edit */ "./src/ht-contactform-block/Edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./block.json */ "./src/ht-contactform-block/block.json");
/* harmony import */ var _icon__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./icon */ "./src/ht-contactform-block/icon.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_6__);


/**
 * Internal dependencies
 */



/**
 * WordPress dependencies
 */




(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_5__.registerBlockType)('block/ht-contactform', {
  title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('HT Contact Form 7'),
  icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_6__.Icon, {
    icon: _icon__WEBPACK_IMPORTED_MODULE_3__["default"]
  }),
  category: 'common',
  keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('ht-contactform'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('contact-form')],
  supports: {
    align: ['wide', 'full']
  },
  attributes: _block_json__WEBPACK_IMPORTED_MODULE_2__,
  edit: _Edit__WEBPACK_IMPORTED_MODULE_1__["default"],
  save: props => {
    return null;
  }
});

/***/ }),

/***/ "./src/ht-contactform-block/inspector.js":
/*!***********************************************!*\
  !*** ./src/ht-contactform-block/inspector.js ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_dimentions_control__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/dimentions-control */ "./src/components/dimentions-control/index.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_5__);


/**
 * Internal dependencies
 */

/**
 * WordPress dependencies
 */






const {
  addQueryArgs
} = wp.url;

class Inspector extends _wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Component {
  constructor(props) {
    super(props);
    this.state = {
      contactFormPosts: [],
      device: 'desktop'
    };
  }

  componentDidMount() {
    this.fetchContactFormPosts();
  }

  fetchContactFormPosts() {
    var queryAttrData = {
      wpnonce: htcontactdata.security
    };
    var query = addQueryArgs('/htcontactform/v1/posts', queryAttrData);
    _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_5___default()({
      path: query
    }).then(data => {
      var postlist = [{
        label: 'Select',
        value: '',
        disabled: true
      }];

      for (var key in data) {
        postlist.push({
          label: data[key],
          value: key
        });
      }

      this.setState({
        contactFormPosts: postlist
      });
    });
  }

  render() {
    const {
      contactFormPosts
    } = this.state;
    const {
      className,
      attributes,
      setAttributes
    } = this.props;
    const {
      formId,
      inputBorderRadius,
      inputPadding,
      borderType,
      areaMargin,
      inputMargin,
      blockUniqId,
      buttonPadding,
      buttonMargin,
      btnBorderType,
      buttonBorderRadius,
      labelFontSize,
      btnFontSize,
      inputTextSize,
      inputHight,
      textAreaHight
    } = attributes;
    const colorSelectorStyles = {
      selectedColorDisplay: {
        width: 30,
        height: 12,
        display: "inline-block",
        marginLeft: 10,
        verticalAlign: "middle"
      }
    };

    const handleTabs = (event, stateKey, value) => {
      this.setState({
        [stateKey]: value
      });
    };

    const onChangeResponsiveData = (newValue, device, dataKey) => {
      const newDimensions = { ...attributes[dataKey]
      };
      newDimensions[device] = newValue;
      setAttributes({
        [dataKey]: newDimensions
      });
    };

    const formStyle = `
						   #ht-editor-bock-${blockUniqId}{
							   margin: ${areaMargin.top}${areaMargin.unit} ${areaMargin.right}${areaMargin.unit} ${areaMargin.bottom}${areaMargin.unit} ${areaMargin.left}${areaMargin.unit};
						   }
						   #ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 input[type=text],
						   #ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 input[type=email],
						   #ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 input[type=password],
						   #ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 input[type=search],
						   #ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 input[type=tel],
						   #ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 input[type=url],
						   #ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 select{
								height: ${inputHight.desktop}px;
						}

						#ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 input:not([type=checkbox]):not([type=submit]),
						#ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 textarea{
							font-size: ${attributes.inputTextSize.desktop};
							background:${attributes.inputBackground};
							color: ${attributes.inputTextColor};
							Padding: ${inputPadding.top}${inputPadding.unit} ${inputPadding.right}${inputPadding.unit} ${inputPadding.bottom}${inputPadding.unit} ${inputPadding.left}${inputPadding.unit};
							margin: ${inputMargin.top}${inputMargin.unit} ${inputMargin.right}${inputMargin.unit} ${inputMargin.bottom}${inputMargin.unit} ${inputMargin.left}${inputMargin.unit};
							border: ${attributes.borderWidth}px ${borderType} ${attributes.borderColor};
							border-radius: ${inputBorderRadius.top}${inputBorderRadius.unit} ${inputBorderRadius.right}${inputBorderRadius.unit} ${inputBorderRadius.bottom}${inputBorderRadius.unit} ${inputBorderRadius.left}${inputBorderRadius.unit};
						}

						#ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 textarea{
							height: ${textAreaHight.desktop}px;
						}
						#ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 label{
							font-size: ${labelFontSize.desktop};
							color: ${attributes.labelColor};
						}
						#ht-editor-bock-${blockUniqId} #wpcf7-f${formId}-o1.wpcf7 input[type=submit]{
							font-size: ${btnFontSize.desktop};
							Padding: ${buttonPadding.desktop.top}${buttonPadding.unit} ${buttonPadding.desktop.right}${buttonPadding.unit} ${buttonPadding.desktop.bottom}${buttonPadding.unit} ${buttonPadding.desktop.left}${buttonPadding.unit};
							margin: ${buttonMargin.desktop.top}${buttonMargin.unit} ${buttonMargin.desktop.right}${buttonMargin.unit} ${buttonMargin.desktop.bottom}${buttonMargin.unit} ${buttonMargin.desktop.left}${buttonMargin.unit};
							color: ${attributes.btnTextColor};
							border: ${attributes.btnBorderWidth}px ${btnBorderType} ${attributes.btnBorderColor};
							border-radius: ${buttonBorderRadius.top}${buttonBorderRadius.unit} ${buttonBorderRadius.right}${buttonBorderRadius.unit} ${buttonBorderRadius.bottom}${buttonBorderRadius.unit} ${buttonBorderRadius.left}${buttonBorderRadius.unit};
							background:${attributes.btnBackgroundColor};
						}`;
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Settings", 'ht-contactform'),
      initialOpen: true
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Form', 'ht-contactform'),
      value: formId,
      options: contactFormPosts,
      onChange: newId => setAttributes({
        formId: newId
      })
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Style", 'ht-contactform'),
      initialOpen: false
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
      className: 'ht-contactform-blocks-section-title'
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Area', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_dimentions_control__WEBPACK_IMPORTED_MODULE_1__["default"], {
      lavel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Margin', 'ht-contactform'),
      dimensions: areaMargin,
      attributesKey: 'areaMargin',
      setAttributes: setAttributes
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
      className: 'ht-contactform-blocks-section-title'
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Border', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Border Type', 'ht-contactform'),
      value: borderType,
      options: [{
        value: 'none',
        label: 'None'
      }, {
        value: 'solid',
        label: 'Solid'
      }, {
        value: 'double',
        label: 'Double'
      }, {
        value: 'dotted',
        label: 'Dotted'
      }, {
        value: 'dashed',
        label: 'Dashed'
      }, {
        value: 'groove',
        label: 'Groove'
      }],
      onChange: newType => setAttributes({
        borderType: newType
      })
    }), borderType !== 'none' ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.RangeControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Border Width', 'ht-contactform'),
      value: attributes.borderWidth,
      onChange: newValue => setAttributes({
        borderWidth: newValue
      }),
      min: 0,
      step: 1,
      max: 10
    }) : '', (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_dimentions_control__WEBPACK_IMPORTED_MODULE_1__["default"], {
      lavel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Border Radius', 'ht-contactform'),
      dimensions: inputBorderRadius,
      attributesKey: 'inputBorderRadius',
      setAttributes: setAttributes
    }), borderType !== 'none' ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", {
      style: {
        marginTop: 15
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Border Color", "ht-contactform"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      style: { ...colorSelectorStyles.selectedColorDisplay,
        backgroundColor: attributes.borderColor
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ColorPalette, {
      colors: [{
        name: 'Black',
        color: '#000000'
      }, {
        name: 'Orange',
        color: '#FF6900'
      }, {
        name: 'Vivid Red',
        color: '#CF2E2E'
      }, {
        name: 'Pink',
        color: '#F78DA7'
      }, {
        name: 'White',
        color: '#FFFFFF'
      }, {
        name: 'Blue',
        color: '#8ED1FC'
      }],
      value: attributes.borderColor,
      onChange: newColor => setAttributes({
        borderColor: newColor
      })
    })) : '', (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
      className: 'ht-contactform-blocks-section-title'
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Field', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_dimentions_control__WEBPACK_IMPORTED_MODULE_1__["default"], {
      lavel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Padding', 'ht-contactform'),
      dimensions: inputPadding,
      attributesKey: 'inputPadding',
      setAttributes: setAttributes
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_dimentions_control__WEBPACK_IMPORTED_MODULE_1__["default"], {
      lavel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Margin', 'ht-contactform'),
      dimensions: inputMargin,
      attributesKey: 'inputMargin',
      setAttributes: setAttributes
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", {
      style: {
        marginTop: 15
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Background Color", "ht-contactform"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      style: { ...colorSelectorStyles.selectedColorDisplay,
        backgroundColor: attributes.inputBackground
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ColorPalette, {
      colors: [{
        name: 'Black',
        color: '#000000'
      }, {
        name: 'Orange',
        color: '#FF6900'
      }, {
        name: 'Vivid Red',
        color: '#CF2E2E'
      }, {
        name: 'Pink',
        color: '#F78DA7'
      }, {
        name: 'White',
        color: '#FFFFFF'
      }, {
        name: 'Blue',
        color: '#8ED1FC'
      }],
      value: attributes.inputBackground,
      onChange: newColor => setAttributes({
        inputBackground: newColor
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
      className: 'ht-contactform-blocks-section-title'
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Field Text', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
      className: "ht-contactform-device-row",
      style: {
        minHeight: 'auto'
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Device For Font Size', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ButtonGroup, {
      className: "ht-contactform-device-button"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "desktop",
      value: "desktop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large', 'ht-contactform'),
      isPrimary: this.state.device === 'desktop',
      isSecondary: this.state.device !== 'desktop',
      onClick: event => handleTabs(event, 'device', 'desktop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "laptop",
      value: "laptop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Medium', 'ht-contactform'),
      isPrimary: this.state.device === 'laptop',
      isSecondary: this.state.device !== 'laptop',
      onClick: event => handleTabs(event, 'device', 'laptop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "tablet",
      value: "tablet",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Small', 'ht-contactform'),
      isPrimary: this.state.device === 'tablet',
      isSecondary: this.state.device !== 'tablet',
      onClick: event => handleTabs(event, 'device', 'tablet')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "smartphone",
      value: "mobile",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Extra Small', 'ht-contactform'),
      isPrimary: this.state.device === 'mobile',
      isSecondary: this.state.device !== 'mobile',
      onClick: event => handleTabs(event, 'device', 'mobile')
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FontSizePicker, {
      fontSizes: [{
        name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Small', 'ht-contactform'),
        slug: 'small',
        size: '12px'
      }, {
        name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Medium', 'ht-contactform'),
        slug: 'medium',
        size: '18px'
      }, {
        name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large', 'ht-contactform'),
        slug: 'large',
        size: '24px'
      }],
      value: inputTextSize[this.state.device],
      fallbackFontSize: inputTextSize.desktop,
      onChange: newValue => onChangeResponsiveData(newValue, this.state.device, 'inputTextSize')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", {
      style: {
        marginTop: 15
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Text Color", "ht-contactform"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      style: { ...colorSelectorStyles.selectedColorDisplay,
        backgroundColor: attributes.inputTextColor
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ColorPalette, {
      colors: [{
        name: 'Black',
        color: '#000000'
      }, {
        name: 'Orange',
        color: '#FF6900'
      }, {
        name: 'Vivid Red',
        color: '#CF2E2E'
      }, {
        name: 'Pink',
        color: '#F78DA7'
      }, {
        name: 'White',
        color: '#FFFFFF'
      }, {
        name: 'Blue',
        color: '#8ED1FC'
      }],
      value: attributes.inputTextColor,
      onChange: newColor => setAttributes({
        inputTextColor: newColor
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
      className: 'ht-contactform-blocks-section-title'
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Input', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
      className: "ht-contactform-device-row",
      style: {
        minHeight: 'auto'
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Device For Height', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ButtonGroup, {
      className: "ht-contactform-device-button"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "desktop",
      value: "desktop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large', 'ht-contactform'),
      isPrimary: this.state.device === 'desktop',
      isSecondary: this.state.device !== 'desktop',
      onClick: event => handleTabs(event, 'device', 'desktop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "laptop",
      value: "laptop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Medium', 'ht-contactform'),
      isPrimary: this.state.device === 'laptop',
      isSecondary: this.state.device !== 'laptop',
      onClick: event => handleTabs(event, 'device', 'laptop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "tablet",
      value: "tablet",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Small', 'ht-contactform'),
      isPrimary: this.state.device === 'tablet',
      isSecondary: this.state.device !== 'tablet',
      onClick: event => handleTabs(event, 'device', 'tablet')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "smartphone",
      value: "mobile",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Extra Small', 'ht-contactform'),
      isPrimary: this.state.device === 'mobile',
      isSecondary: this.state.device !== 'mobile',
      onClick: event => handleTabs(event, 'device', 'mobile')
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.RangeControl, {
      label: "Height",
      value: inputHight[this.state.device],
      onChange: newValue => onChangeResponsiveData(newValue, this.state.device, 'inputHight'),
      min: 1,
      step: 1,
      max: 150
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
      className: 'ht-contactform-blocks-section-title'
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Textarea', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
      className: "ht-contactform-device-row",
      style: {
        minHeight: 'auto'
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Device For Height', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ButtonGroup, {
      className: "ht-contactform-device-button"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "desktop",
      value: "desktop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large', 'ht-contactform'),
      isPrimary: this.state.device === 'desktop',
      isSecondary: this.state.device !== 'desktop',
      onClick: event => handleTabs(event, 'device', 'desktop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "laptop",
      value: "laptop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Medium', 'ht-contactform'),
      isPrimary: this.state.device === 'laptop',
      isSecondary: this.state.device !== 'laptop',
      onClick: event => handleTabs(event, 'device', 'laptop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "tablet",
      value: "tablet",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Small', 'ht-contactform'),
      isPrimary: this.state.device === 'tablet',
      isSecondary: this.state.device !== 'tablet',
      onClick: event => handleTabs(event, 'device', 'tablet')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "smartphone",
      value: "mobile",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Extra Small', 'ht-contactform'),
      isPrimary: this.state.device === 'mobile',
      isSecondary: this.state.device !== 'mobile',
      onClick: event => handleTabs(event, 'device', 'mobile')
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.RangeControl, {
      label: "Height",
      value: textAreaHight[this.state.device],
      onChange: newValue => onChangeResponsiveData(newValue, this.state.device, 'textAreaHight'),
      min: 80,
      step: 2,
      max: 300
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
      className: 'ht-contactform-blocks-section-title'
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
      className: "ht-contactform-device-row",
      style: {
        minHeight: 'auto'
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Device For Font Size', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ButtonGroup, {
      className: "ht-contactform-device-button"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "desktop",
      value: "desktop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large', 'ht-contactform'),
      isPrimary: this.state.device === 'desktop',
      isSecondary: this.state.device !== 'desktop',
      onClick: event => handleTabs(event, 'device', 'desktop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "laptop",
      value: "laptop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Medium', 'ht-contactform'),
      isPrimary: this.state.device === 'laptop',
      isSecondary: this.state.device !== 'laptop',
      onClick: event => handleTabs(event, 'device', 'laptop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "tablet",
      value: "tablet",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Small', 'ht-contactform'),
      isPrimary: this.state.device === 'tablet',
      isSecondary: this.state.device !== 'tablet',
      onClick: event => handleTabs(event, 'device', 'tablet')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "smartphone",
      value: "mobile",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Extra Small', 'ht-contactform'),
      isPrimary: this.state.device === 'mobile',
      isSecondary: this.state.device !== 'mobile',
      onClick: event => handleTabs(event, 'device', 'mobile')
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FontSizePicker, {
      fontSizes: [{
        name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Small', 'ht-contactform'),
        slug: 'small',
        size: '12px'
      }, {
        name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Medium', 'ht-contactform'),
        slug: 'medium',
        size: '18px'
      }, {
        name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large', 'ht-contactform'),
        slug: 'large',
        size: '24px'
      }],
      value: labelFontSize[this.state.device],
      fallbackFontSize: labelFontSize.desktop,
      onChange: newValue => onChangeResponsiveData(newValue, this.state.device, 'labelFontSize')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", {
      style: {
        marginTop: 15
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Label Color", "ht-contactform"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      style: { ...colorSelectorStyles.selectedColorDisplay,
        backgroundColor: attributes.labelColor
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ColorPalette, {
      colors: [{
        name: 'Black',
        color: '#000000'
      }, {
        name: 'Orange',
        color: '#FF6900'
      }, {
        name: 'Vivid Red',
        color: '#CF2E2E'
      }, {
        name: 'Pink',
        color: '#F78DA7'
      }, {
        name: 'White',
        color: '#FFFFFF'
      }, {
        name: 'Blue',
        color: '#8ED1FC'
      }],
      value: attributes.labelColor,
      onChange: newColor => setAttributes({
        labelColor: newColor
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
      className: 'ht-contactform-blocks-section-title'
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Button', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
      className: "ht-contactform-device-row",
      style: {
        minHeight: 'auto'
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Device For Font Size', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ButtonGroup, {
      className: "ht-contactform-device-button"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "desktop",
      value: "desktop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large', 'ht-contactform'),
      isPrimary: this.state.device === 'desktop',
      isSecondary: this.state.device !== 'desktop',
      onClick: event => handleTabs(event, 'device', 'desktop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "laptop",
      value: "laptop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Medium', 'ht-contactform'),
      isPrimary: this.state.device === 'laptop',
      isSecondary: this.state.device !== 'laptop',
      onClick: event => handleTabs(event, 'device', 'laptop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "tablet",
      value: "tablet",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Small', 'ht-contactform'),
      isPrimary: this.state.device === 'tablet',
      isSecondary: this.state.device !== 'tablet',
      onClick: event => handleTabs(event, 'device', 'tablet')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "smartphone",
      value: "mobile",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Extra Small', 'ht-contactform'),
      isPrimary: this.state.device === 'mobile',
      isSecondary: this.state.device !== 'mobile',
      onClick: event => handleTabs(event, 'device', 'mobile')
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FontSizePicker, {
      fontSizes: [{
        name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Small', 'ht-contactform'),
        slug: 'small',
        size: '12px'
      }, {
        name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Medium', 'ht-contactform'),
        slug: 'medium',
        size: '18px'
      }, {
        name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large', 'ht-contactform'),
        slug: 'large',
        size: '24px'
      }],
      value: btnFontSize[this.state.device],
      fallbackFontSize: btnFontSize.desktop,
      onChange: newValue => onChangeResponsiveData(newValue, this.state.device, 'btnFontSize')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Border Type', 'ht-contactform'),
      value: btnBorderType,
      options: [{
        value: 'none',
        label: 'None'
      }, {
        value: 'solid',
        label: 'Solid'
      }, {
        value: 'double',
        label: 'Double'
      }, {
        value: 'dotted',
        label: 'Dotted'
      }, {
        value: 'dashed',
        label: 'Dashed'
      }, {
        value: 'groove',
        label: 'Groove'
      }],
      onChange: newType => setAttributes({
        btnBorderType: newType
      })
    }), btnBorderType !== 'none' ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.RangeControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Border Width', 'ht-contactform'),
      value: attributes.btnBorderWidth,
      onChange: newValue => setAttributes({
        btnBorderWidth: newValue
      }),
      min: 0,
      step: 1,
      max: 10
    }) : '', btnBorderType !== 'none' ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", {
      style: {
        marginTop: 15
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Border Color", "ht-contactform"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      style: { ...colorSelectorStyles.selectedColorDisplay,
        backgroundColor: attributes.btnBorderColor
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ColorPalette, {
      colors: [{
        name: 'Black',
        color: '#000000'
      }, {
        name: 'Orange',
        color: '#FF6900'
      }, {
        name: 'Vivid Red',
        color: '#CF2E2E'
      }, {
        name: 'Pink',
        color: '#F78DA7'
      }, {
        name: 'White',
        color: '#FFFFFF'
      }, {
        name: 'Blue',
        color: '#8ED1FC'
      }],
      value: attributes.btnBorderColor,
      onChange: newColor => setAttributes({
        btnBorderColor: newColor
      })
    })) : '', (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", {
      style: {
        marginTop: 15
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Text Color", "ht-contactform"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      style: { ...colorSelectorStyles.selectedColorDisplay,
        backgroundColor: attributes.btnTextColor
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ColorPalette, {
      colors: [{
        name: 'Black',
        color: '#000000'
      }, {
        name: 'Orange',
        color: '#FF6900'
      }, {
        name: 'Vivid Red',
        color: '#CF2E2E'
      }, {
        name: 'Pink',
        color: '#F78DA7'
      }, {
        name: 'White',
        color: '#FFFFFF'
      }, {
        name: 'Blue',
        color: '#8ED1FC'
      }],
      value: attributes.btnTextColor,
      onChange: newColor => setAttributes({
        btnTextColor: newColor
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", {
      style: {
        marginTop: 15
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Background Color", "ht-contactform"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      style: { ...colorSelectorStyles.selectedColorDisplay,
        backgroundColor: attributes.btnBackgroundColor
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ColorPalette, {
      colors: [{
        name: 'Black',
        color: '#000000'
      }, {
        name: 'Orange',
        color: '#FF6900'
      }, {
        name: 'Vivid Red',
        color: '#CF2E2E'
      }, {
        name: 'Pink',
        color: '#F78DA7'
      }, {
        name: 'White',
        color: '#FFFFFF'
      }, {
        name: 'Blue',
        color: '#8ED1FC'
      }],
      value: attributes.btnBackgroundColor,
      onChange: newColor => setAttributes({
        btnBackgroundColor: newColor
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_dimentions_control__WEBPACK_IMPORTED_MODULE_1__["default"], {
      lavel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Border Radius', 'ht-contactform'),
      dimensions: buttonBorderRadius,
      attributesKey: 'buttonBorderRadius',
      setAttributes: setAttributes
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
      className: "ht-contactform-device-row",
      style: {
        minHeight: 'auto'
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Device For Padding', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ButtonGroup, {
      className: "ht-contactform-device-button"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "desktop",
      value: "desktop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large', 'ht-contactform'),
      isPrimary: this.state.device === 'desktop',
      isSecondary: this.state.device !== 'desktop',
      onClick: event => handleTabs(event, 'device', 'desktop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "laptop",
      value: "laptop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Medium', 'ht-contactform'),
      isPrimary: this.state.device === 'laptop',
      isSecondary: this.state.device !== 'laptop',
      onClick: event => handleTabs(event, 'device', 'laptop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "tablet",
      value: "tablet",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Small', 'ht-contactform'),
      isPrimary: this.state.device === 'tablet',
      isSecondary: this.state.device !== 'tablet',
      onClick: event => handleTabs(event, 'device', 'tablet')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "smartphone",
      value: "mobile",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Extra Small', 'ht-contactform'),
      isPrimary: this.state.device === 'mobile',
      isSecondary: this.state.device !== 'mobile',
      onClick: event => handleTabs(event, 'device', 'mobile')
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_dimentions_control__WEBPACK_IMPORTED_MODULE_1__["default"], {
      lavel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Padding', 'ht-contactform'),
      dimensions: buttonPadding,
      attributesKey: 'buttonPadding',
      setAttributes: setAttributes,
      responsive: "yes",
      device: this.state.device
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
      className: "ht-contactform-device-row",
      style: {
        minHeight: 'auto'
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Device For Margin', 'ht-contactform')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ButtonGroup, {
      className: "ht-contactform-device-button"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "desktop",
      value: "desktop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large', 'ht-contactform'),
      isPrimary: this.state.device === 'desktop',
      isSecondary: this.state.device !== 'desktop',
      onClick: event => handleTabs(event, 'device', 'desktop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "laptop",
      value: "laptop",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Medium', 'ht-contactform'),
      isPrimary: this.state.device === 'laptop',
      isSecondary: this.state.device !== 'laptop',
      onClick: event => handleTabs(event, 'device', 'laptop')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "tablet",
      value: "tablet",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Small', 'ht-contactform'),
      isPrimary: this.state.device === 'tablet',
      isSecondary: this.state.device !== 'tablet',
      onClick: event => handleTabs(event, 'device', 'tablet')
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      icon: "smartphone",
      value: "mobile",
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Extra Small', 'ht-contactform'),
      isPrimary: this.state.device === 'mobile',
      isSecondary: this.state.device !== 'mobile',
      onClick: event => handleTabs(event, 'device', 'mobile')
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_dimentions_control__WEBPACK_IMPORTED_MODULE_1__["default"], {
      lavel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Margin', 'ht-contactform'),
      dimensions: buttonMargin,
      attributesKey: 'buttonMargin',
      setAttributes: setAttributes,
      responsive: "yes",
      device: this.state.device
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("style", {
      type: "text/css"
    }, formStyle));
  }

}

/* harmony default export */ __webpack_exports__["default"] = (Inspector);

/***/ }),

/***/ "./node_modules/classnames/index.js":
/*!******************************************!*\
  !*** ./node_modules/classnames/index.js ***!
  \******************************************/
/***/ (function(module, exports) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  Copyright (c) 2018 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames() {
		var classes = [];

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (!arg) continue;

			var argType = typeof arg;

			if (argType === 'string' || argType === 'number') {
				classes.push(arg);
			} else if (Array.isArray(arg)) {
				if (arg.length) {
					var inner = classNames.apply(null, arg);
					if (inner) {
						classes.push(inner);
					}
				}
			} else if (argType === 'object') {
				if (arg.toString === Object.prototype.toString) {
					for (var key in arg) {
						if (hasOwn.call(arg, key) && arg[key]) {
							classes.push(key);
						}
					}
				} else {
					classes.push(arg.toString());
				}
			}
		}

		return classes.join(' ');
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["apiFetch"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./src/ht-contactform-block/block.json":
/*!*********************************************!*\
  !*** ./src/ht-contactform-block/block.json ***!
  \*********************************************/
/***/ (function(module) {

"use strict";
module.exports = JSON.parse('{"formId":{"type":"string","default":""},"inputHight":{"type":"object","default":{"desktop":40,"laptop":35,"tablet":30,"mobile":30}},"areaMargin":{"type":"object","default":{"top":"0","right":"0","bottom":"0","left":"0","unit":"px","link":"yes"}},"blockUniqId":{"type":"string","default":""},"inputTextColor":{"type":"string","default":"#666"},"inputTextSize":{"type":"object","default":{"desktop":"16px","laptop":"14px","tablet":"14px","mobile":"14px"}},"inputBackground":{"type":"string","default":"#fafafa"},"inputPadding":{"type":"object","default":{"top":"8","right":"8","bottom":"8","left":"8","unit":"px","link":"yes"}},"inputMargin":{"type":"object","default":{"top":"0","right":"0","bottom":"0","left":"0","unit":"px","link":"yes"}},"inputBorderRadius":{"type":"object","default":{"top":"5","right":"5","bottom":"5","left":"5","unit":"px","link":"yes"}},"borderType":{"type":"string","default":"solid"},"borderWidth":{"type":"number","default":1},"borderColor":{"type":"string","default":"#c8c9cb"},"textAreaHight":{"type":"object","default":{"desktop":175,"laptop":170,"tablet":160,"mobile":160}},"labelFontSize":{"type":"object","default":{"desktop":"16px","laptop":"14px","tablet":"14px","mobile":"14px"}},"labelColor":{"type":"string","default":"#3a3a3a"},"buttonPadding":{"type":"object","default":{"desktop":{"top":"10","right":"40","bottom":"10","left":"40"},"laptop":{"top":"0","right":"0","bottom":"0","left":"0"},"tablet":{"top":"0","right":"0","bottom":"0","left":"0"},"mobile":{"top":"0","right":"0","bottom":"0","left":"0"},"unit":"px","link":"no"}},"buttonMargin":{"type":"object","default":{"desktop":{"top":"10","right":"0","bottom":"10","left":"0"},"laptop":{"top":"0","right":"0","bottom":"0","left":"0"},"tablet":{"top":"0","right":"0","bottom":"0","left":"0"},"mobile":{"top":"0","right":"0","bottom":"0","left":"0"},"unit":"px","link":"no"}},"buttonBorderRadius":{"type":"object","default":{"top":"5","right":"5","bottom":"5","left":"5","unit":"px","link":"yes"}},"btnBorderType":{"type":"string","default":"none"},"btnBorderWidth":{"type":"number","default":1},"btnBorderColor":{"type":"string","default":"#000"},"btnBackgroundColor":{"type":"string","default":"#0170B9"},"btnTextColor":{"type":"string","default":"#fff"},"btnFontSize":{"type":"object","default":{"desktop":"16px","laptop":"14px","tablet":"14px","mobile":"14px"}}}');

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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!***********************!*\
  !*** ./src/blocks.js ***!
  \***********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ht_contactform_block_index_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ht-contactform-block/index.js */ "./src/ht-contactform-block/index.js");

}();
/******/ })()
;
//# sourceMappingURL=htcontactform-block.js.map