module.exports = ( { env } ) => ( {
	plugins: {
		'postcss-import': {},
		'postcss-for': {},
		'postcss-each': {},
		'postcss-mixins': {},
		'postcss-nested-ancestors': {},
		'postcss-nested': {},
		'postcss-variables-prefixer': {
			prefix: 'hypermarket-',
		},
		'postcss-css-variables': {
			preserve: true,
		},
		'postcss-extend': {},
		'postcss-custom-selectors': {},
		'postcss-if-media': {},
		'postcss-custom-media': {},
		'postcss-quantity-queries': {},
		'postcss-start-to-end': {},
		'postcss-calc': {},
		'postcss-size': {},
		'postcss-position': {},
		'postcss-hidden': {},
		'postcss-short-border-radius': {},
		'postcss-transform-shortcut': {},
		'postcss-selector-not': {},
		'postcss-combine-media-query': {},
		'postcss-normalize': {},
		'postcss-fontpath': {},
		autoprefixer: {},
	},
} );
