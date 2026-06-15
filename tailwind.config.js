import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: "class",
    
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                // Font dari Stitch
                "body-md": ["Inter"],
                "headline-md": ["Inter"],
                "headline-lg-mobile": ["Inter"],
                "headline-xl": ["Inter"],
                "label-sm": ["Inter"],
                "caption": ["Inter"],
                "label-md": ["Inter"],
                "headline-lg": ["Inter"],
                "body-lg": ["Inter"]
            },
            
            // Colors dari Stitch
            colors: {
                "on-primary": "#ffffff",
                "surface-container-low": "#eff4ff",
                "surface-container": "#e5eeff",
                "background": "#f8f9ff",
                "on-tertiary-fixed": "#341100",
                "on-tertiary-fixed-variant": "#723610",
                "primary-fixed": "#d5e3ff",
                "surface-container-highest": "#d3e4fe",
                "on-surface-variant": "#43474f",
                "border-subtle": "#E2E8F0",
                "on-error-container": "#93000a",
                "surface-bright": "#f8f9ff",
                "on-surface": "#0b1c30",
                "primary-fixed-dim": "#a7c8ff",
                "error": "#ba1a1a",
                "on-secondary": "#ffffff",
                "status-pending": "#D97706",
                "tertiary": "#381300",
                "inverse-on-surface": "#eaf1ff",
                "on-secondary-fixed-variant": "#5d4201",
                "secondary-container": "#fed488",
                "tertiary-fixed-dim": "#ffb690",
                "on-tertiary": "#ffffff",
                "error-container": "#ffdad6",
                "surface-gray": "#F8FAFC",
                "primary": "#001e40",
                "on-error": "#ffffff",
                "on-primary-fixed": "#001b3c",
                "secondary-fixed": "#ffdea5",
                "surface-variant": "#d3e4fe",
                "surface-container-lowest": "#ffffff",
                "primary-container": "#003366",
                "inverse-primary": "#a7c8ff",
                "surface": "#f8f9ff",
                "tertiary-container": "#592300",
                "on-secondary-fixed": "#261900",
                "on-secondary-container": "#785a1a",
                "on-primary-container": "#799dd6",
                "on-background": "#0b1c30",
                "tertiary-fixed": "#ffdbca",
                "surface-container-high": "#dce9ff",
                "outline-variant": "#c3c6d1",
                "inverse-surface": "#213145",
                "surface-tint": "#3a5f94",
                "on-primary-fixed-variant": "#1f477b",
                "surface-dim": "#cbdbf5",
                "on-tertiary-container": "#d8885c",
                "success-emerald": "#059669",
                "secondary": "#775a19",
                "outline": "#737780",
                "secondary-fixed-dim": "#e9c176"
            },
            
            // Border Radius dari Stitch
            borderRadius: {
                DEFAULT: "0.125rem",
                lg: "0.25rem",
                xl: "0.5rem",
                full: "0.75rem"
            },
            
            // Spacing dari Stitch
            spacing: {
                base: "8px",
                "margin-desktop": "40px",
                "margin-mobile": "16px",
                gutter: "24px",
                "container-max": "1280px"
            },
            
            // Font Size dari Stitch
            fontSize: {
                "body-md": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                "headline-md": ["24px", { lineHeight: "32px", fontWeight: "600" }],
                "headline-lg-mobile": ["24px", { lineHeight: "32px", fontWeight: "700" }],
                "headline-xl": ["40px", { lineHeight: "48px", letterSpacing: "-0.02em", fontWeight: "700" }],
                "label-sm": ["12px", { lineHeight: "16px", letterSpacing: "0.02em", fontWeight: "500" }],
                caption: ["12px", { lineHeight: "16px", fontWeight: "400" }],
                "label-md": ["14px", { lineHeight: "20px", letterSpacing: "0.01em", fontWeight: "600" }],
                "headline-lg": ["32px", { lineHeight: "40px", letterSpacing: "-0.02em", fontWeight: "700" }],
                "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }]
            }
        },
    },

    plugins: [forms, typography],
};