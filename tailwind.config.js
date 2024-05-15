const plugin = require("tailwindcss/plugin");
const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");
module.exports = {
    content: [
        // "./resources/views/*.blade.php",
        "./app/Helpers/*.php",
        "./resources/views/components/*.blade.php",
        "./resources/views/components/**/*.blade.php",
        "./resources/views/components/**/**/*.blade.php",
        "./resources/views/desktop/*.blade.php",
        "./resources/views/desktop/**/*.blade.php",
        "./resources/views/desktop/**/**/*.blade.php",
        "node_modules/preline/dist/*.js",
    ],
    theme: {
        screens: {
            xs: "475px",
            ...defaultTheme.screens,
        },
        extend: {
            gridTemplateColumns: {
                14: "repeat(14, minmax(0, 1fr))",
                15: "repeat(15, minmax(0, 1fr))",
                16: "repeat(16, minmax(0, 1fr))",
            },
            gridColumn: {
                "span-14": "span 14 / span 14",
                "span-15": "span 15 / span 15",
                "span-16": "span 16 / span 16",
            },
            gridColumnStart: {
                13: "13",
                14: "14",
                15: "15",
                16: "16",
                17: "17",
            },
            gridColumnEnd: {
                13: "13",
                14: "14",
                15: "15",
                16: "16",
                17: "17",
            },
            colors: {
                primary: {
                    100: "#ffe3cc",
                    200: "#ffc799",
                    300: "#ffaa66",
                    400: "#ff8e33",
                    500: "#ff7200",
                    DEFAULT: "#22B5BB",
                    600: "#cc5b00",
                    700: "#994400",
                    800: "#662e00",
                    900: "#331700",
                },
                secondary: {
                    100: "#cccccc",
                    200: "#999999",
                    300: "#666666",
                    400: "#333333",
                    500: "#000000",
                    DEFAULT: "#000000",
                    600: "#000000",
                    700: "#000000",
                    800: "#000000",
                    900: "#000000",
                },
            },
            backgroundImage: {
                dots: "url('../pts/dots.png')",
                doingu: "url('../pts/doingu_hover.png')",
                doingupre: "url('../pts/doingu_prehover.png')",
                ketqua: "url('../pts/ketqua.png')",
                quyenloi: "url('../pts/quyenloi.png')",
                gioithieuchung: "url('../pts/gioithieuchung.png')",
                chuongtrinhdaotao: "url('../pts/chuongtrinhdaotao.png')",
                lotrinhdaotao: "url('../pts/map.jpg')",
                dangkynhantin: "url('../pts/dangkynhantin.png')",
                slide: "url('../../img/slide-bg.png')",
                feedback: "url('../../img/feedback-bg.png')",
                "readmore-gradient":
                    "linear-gradient(90deg, #16623A 0%, #DFB337 50%, #F9EB85 100%)",
            },
            fontFamily: {
                // 'display': ['Prata', serif],
                menu: ['"SVN-Gilroy"', "sans-serif"],
                display: ['"SVN-Gilroy"', "sans-serif"],
                body: ['"SVN-Gilroy"', "sans-serif"],
                title: ['"SVN-Gilroy"', "sans-serif"],
            },
            container: {
                center: true,
                padding: "1rem",
                // sm (640px)	max-width: 640px;
                // md (768px)	max-width: 768px;
                // lg (1024px)	max-width: 1024px;
                // xl (1280px)	max-width: 1280px;
                // 2xl (1536px)	max-width: 1536px;
                screens: {
                    // xl: "1254px",
                    // "2xl": "1346px",
                    // "3xl": "1600px",
                },
            },
            boxShadow: {
                circle: "0px 4px 4px rgba(0, 0, 0, 0.25)",
            },
            dropShadow: {
                readmore: "0px 4px 4px rgba(192, 157, 14, 0.22)",
                "3xl": "0 35px 35px rgba(0, 0, 0, 0.25)",
                "4xl": [
                    "0 35px 35px rgba(0, 0, 0, 0.25)",
                    "0 45px 65px rgba(0, 0, 0, 0.15)",
                ],
            },
            animation: {
                marquee: "marquee 25s linear infinite",
                marquee2: "marquee2 25s linear infinite",
            },
            keyframes: {
                marquee: {
                    "0%": { transform: "translateX(0%)" },
                    "100%": { transform: "translateX(-100%)" },
                },
                marquee2: {
                    "0%": { transform: "translateX(100%)" },
                    "100%": { transform: "translateX(0%)" },
                },
            },
            lineClamp: {
                7: "7",
                8: "8",
                9: "9",
                10: "10",
            },
        },
    },
    corePlugins: {
        aspectRatio: false,
        preflight: true,
    },
    plugins: [
        require("@tailwindcss/aspect-ratio"),
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("tailwindcss-debug-screens"),
        require("preline/plugin"),
        // plugin( ({addVariant, e}) => {
        //     addVariant("current", ({ modifySelectors, separator }) => {
        //         modifySelectors(({ className }) => {
        //           const newClass = e(`current${separator}${className}`);
        //           return `.custom-active.${newClass}`;
        //         });
        //     })
        //     addVariant("custom", ({ modifySelectors, separator }) => {
        //         modifySelectors(({ className }) => {
        //           const newClass = e(`custom${separator}${className}`);
        //           return `.custom-sub .${newClass}`;
        //         });
        //     })
        // })
        plugin(function (helpers) {
            // variants that help styling Radix-UI components
            // dataStateVariant('even', helpers)
            // dataStateVariant('active', helpers)
            // dataStateVariant('open', helpers)
            // dataStateVariant('closed', helpers)
            // dataStateVariant('on', helpers)
            // dataStateVariant('checked', helpers)
            // dataStateVariant('unchecked', helpers)
        }),
    ],
};
function dataStateVariant(
    state,
    {
        addVariant, // for registering custom variants
        e, // for manually escaping strings meant to be used in class names
    }
) {
    // <div class="item custom-even current-even current-even:justify-even">
    //     <div class="col-info">
    //         <h5 class="text-red custom-even:text-blue">xxx</h5>
    //     </div>
    //     <div class="col-image custom-even:order-1"></div>
    // <div></div>
    addVariant(`custom-${state}`, ({ modifySelectors, separator }) => {
        modifySelectors(({ className }) => {
            return `.custom-${state} .${e(
                `custom-${state}${separator}${className}`
            )}`;
        });
    });

    addVariant(`current-${state}`, ({ modifySelectors, separator }) => {
        modifySelectors(({ className }) => {
            return `.current-${state}.${e(
                `current-${state}${separator}${className}`
            )}`;
        });
    });

    // addVariant(`data-state-${state}`, ({ modifySelectors, separator }) => {
    //     modifySelectors(({ className }) => {
    //         return `.${e(`data-state-${state}${separator}${className}`)}[data-state='${state}']`
    //     })
    // })

    // addVariant(`group-data-state-${state}`, ({ modifySelectors, separator }) => {
    //     modifySelectors(({ className }) => {
    //         return `.group[data-state='${state}'] .${e(
    //         `group-data-state-${state}${separator}${className}`,
    //         )}`
    //     })
    // })

    // addVariant(`peer-data-state-${state}`, ({ modifySelectors, separator }) => {
    //     modifySelectors(({ className }) => {
    //         return `.peer[data-state='${state}'] ~ .${e(
    //         `peer-data-state-${state}${separator}${className}`,
    //         )}`
    //     })
    // })
}
