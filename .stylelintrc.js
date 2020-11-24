module.exports = {
	extends: 'stylelint-config-wordpress/scss',
	rules: {
		'selector-class-pattern': null,
		'no-descending-specificity': null,
		'selector-id-pattern': null,
		'max-line-length': null,
		'value-keyword-case': null,
		'no-duplicate-selectors': null,
		'comment-empty-line-before': null,
		'scss/selector-no-redundant-nesting-selector': null,
		'selector-type-no-unknown': null,
		'property-no-unknown': [
			true,
			{
				ignoreProperties: [ 'box', 'box-item', 'border-right-radius', 'border-left-radius' ],
			},
		],
		'at-rule-no-unknown': [
			true,
			{
				ignoreAtRules: [ 'for', 'extend', 'each', 'mixin', 'define-mixin' ],
			},
		],
		'scss/at-rule-no-unknown': [
			true,
			{
				ignoreAtRules: [ 'define-mixin' ],
			},
		],
		'selector-pseudo-element-no-unknown': [ true, { ignorePseudoElements: [ 'range-thumb' ] } ],
		'font-family-no-missing-generic-family-keyword': [
			true,
			{
				ignoreFontFamilies: [ 'dashicons' ],
			},
		],
	},
};
