// Vuetify
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const customeTheme = {
    dark: false,
    colors: {
        primary: "#308DC2",
        red: "#ba2d42",
        secondary: "#48a9a6",
        /*
        accent: "#82B1FF",
        error: "#FF5252",
        info: "#2196F3",
        success: "#4CAF50",
        warning: "#FFC107",
        lightblue: "#14c6FF",
        yellow: "#FFCF00",
        pink: "#FF1976",
        orange: "#FF8657",
        magenta: "#C33AFC",
        darkblue: "#1E2D56",
        darkblueshade: "#308DC2",
        gray: "#909090",
        neutralgray: "#9BA6C1",
        green: "#2ED47A",
        lightgray: "#BDBDBD",
        lightpink: "#FFCFE3",
        white: "#FFFFFF",
        muted: "#6c757d", */
    },
};

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "customeTheme",
        themes: {
            customeTheme,
        },
    },
});

export default vuetify;