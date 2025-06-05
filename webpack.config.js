const path = require('path');

module.exports = {
    entry  : {
        helper       : './helpers/class.helper.ts',
        formpopup    : './helpers/class.formpopup.ts',
        util         : './helpers/class.util.ts',
        admin        : './modules/admin/assets/admin.js',
        idoszakok    : './modules/karbantartas/assets/idoszakok.ts',
        arak         : './modules/karbantartas/assets/arak.ts',
        markak       : './modules/karbantartas/assets/markak.ts',
        autok        : './modules/autok/assets/autok.ts',
        ugyfelek     : './modules/autok/assets/ugyfelek.ts',
        felszereltseg: './modules/karbantartas/assets/felszereltseg.ts',
        kivitel      : './modules/karbantartas/assets/kivitel.ts',
        szinek       : './modules/karbantartas/assets/szinek.ts',
        landing      : './src/index/landing.ts',
        jarmuvek     : './src/index/jarmuvek.ts',
        auto         : './src/index/auto.ts',
        // login    : './views/assets/login.ts',
    },
    output : {
        filename: '[name].js',
        path    : path.resolve(__dirname, 'web/webpack'),
    },
    resolve: {
        extensions: [
            '.ts',
            '.js'
        ]
    },
    module : {
        rules: [
            {
                test   : /\.ts$/,
                use    : 'ts-loader',
                exclude: /node_modules/
            },
            {
                test: /\.css$/i,
                use : [
                    'style-loader',
                    'css-loader'
                ],
            },
            {
                test: /\.s[ac]ss$/i,
                use : [
                    'style-loader',
                    'css-loader',
                    'sass-loader'
                ],
            }
        ],
    },
    mode   : 'development', // vagy 'production'
};