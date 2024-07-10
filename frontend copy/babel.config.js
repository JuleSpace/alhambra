module.exports = {
  presets: [
    [
      '@vue/cli-plugin-babel/preset',
      {
        useBuiltIns: 'entry',
        corejs: 3,
      },
    ],
  ],
  plugins: [
    '@babel/plugin-syntax-dynamic-import',
    '@babel/plugin-proposal-class-properties',
    '@babel/plugin-proposal-private-methods',
    '@babel/plugin-proposal-optional-chaining',
    '@babel/plugin-proposal-nullish-coalescing-operator',
    '@babel/plugin-transform-runtime',
    'babel-plugin-lodash',
    [
      'import',
      {
        libraryName: 'ant-design-vue',
        libraryDirectory: 'es',
        style: true,
      },
    ],
    ['@babel/plugin-proposal-decorators', { legacy: true }],
    '@vue/babel-plugin-jsx',
  ],
  env: {
    production: {
      plugins: [
        'transform-remove-console',
        'transform-remove-debugger',
      ],
    },
    test: {
      plugins: [
        'require-context-hook',
      ],
    },
  },
};
