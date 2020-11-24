module.exports = () => ( {
	plugins: {
		'postcss-import': {},
		'postcss-for': {},
		'postcss-each': {},
		'postcss-mixins': {},
		'postcss-custom-selectors': {},
		'postcss-nested-ancestors': {},
		'postcss-nested': {},
		'postcss-variables-prefixer': {
			prefix: 'hypermarket-',
			ignore: [ /range/ ],
		},
		'postcss-extend': {},
		'postcss-if-media': {},
		'postcss-custom-media': {},
		'postcss-quantity-queries': {},
		'postcss-start-to-end': {},
		'postcss-calc': {},
		'postcss-size': {},
		'postcss-flexbox': {},
		'postcss-position': {},
		'postcss-hidden': {},
		'postcss-short-border-radius': {},
		'postcss-transform-shortcut': {},
		'postcss-selector-not': {},
		'postcss-combine-media-query': {},
		'postcss-normalize': {},
		'postcss-input-range': {},
		autoprefixer: { grid: true },
	},
} );
