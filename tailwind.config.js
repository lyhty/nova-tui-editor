const path = require('path');

module.exports = {
    content: [path.resolve(__dirname, 'resources/**/*.{vue,js,ts,jsx,tsx,scss}')],
    darkMode: 'class',
    safelist: [],
};
