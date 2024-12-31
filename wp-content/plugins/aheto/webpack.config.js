const { resolve } = require( 'path' )
const UglifyJSPlugin = require( 'uglifyjs-webpack-plugin' )

const externals = {
	jquery: 'jQuery',
	elementor: 'elementor',
}

const alias = {
	'@root': resolve( __dirname, './assets' ),
	'@library': resolve( __dirname, './assets/admin/src/template-library' ),
}

const uglifyjs = new UglifyJSPlugin(
	{
		uglifyOptions: {
			mangle: true,
			compress: {
				pure_getters: true,
				unsafe: true,
				unsafe_comps: true,
				conditionals: true,
				unused: true,
				comparisons: true,
				sequences: true,
				dead_code: true,
				evaluate: true,
				if_return: true,
				join_vars: true,
			},
			output: {
				beautify: false,
				comments: false,
			},
		},
	}
)

module.exports = function( env ) {
	const mode = ( env && env.environment ) || process.env.NODE_ENV || 'production'

	return {
		devtool: mode === 'development' ? 'cheap-module-eval-source-map' : false,
		entry: {
			'assets/admin/js/elementor/elementor-modal': './assets/admin/src/elementor-modal.js',
			'assets/admin/js/template-kit': './assets/admin/src/template-kit.js',
		},
		output: {
			path: resolve( __dirname, './' ),
			filename: '[name].js',
		},
		resolve: {
			alias,
		},
		module: {
			rules: [
				{
					test: /\.js$/,
					exclude: /(node_modules|bower_components)/,
					loader: 'babel-loader',
					options: {
						cacheDirectory: true,
						presets: [ '@babel/preset-env' ],
					},
				},
				{
					test: /\.html$/,
					exclude: /(node_modules|bower_components)/,
					use: [
						{
							loader: 'html-loader',
							options: { minimize: true },
						},
					],
				},
			],
		},
		externals,
		plugins: [ uglifyjs ],
	}
}
