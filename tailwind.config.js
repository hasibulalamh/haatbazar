import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            /**
             * TYPOGRAPHY - Design System Integration
             * Using CSS variables for design tokens
             */
            fontFamily: {
                sans: ["Noto Sans", ...defaultTheme.fontFamily.sans],
                mono: ["Courier New", ...defaultTheme.fontFamily.mono],
            },
            fontSize: {
                xs: "var(--font-size-xs)",
                sm: "var(--font-size-sm)",
                base: "var(--font-size-base)",
                md: "var(--font-size-md)",
                lg: "var(--font-size-lg)",
                xl: "var(--font-size-xl)",
                "2xl": "var(--font-size-2xl)",
                "3xl": "var(--font-size-3xl)",
            },
            fontWeight: {
                regular: "var(--font-weight-regular)",
                medium: "var(--font-weight-medium)",
                semibold: "var(--font-weight-semibold)",
                bold: "var(--font-weight-bold)",
            },
            lineHeight: {
                xs: "var(--line-height-xs)",
                sm: "var(--line-height-sm)",
                base: "var(--line-height-base)",
                md: "var(--line-height-md)",
                lg: "var(--line-height-lg)",
                xl: "var(--line-height-xl)",
                heading: "var(--line-height-heading)",
            },

            /**
             * COLORS - Design System Integration
             */
            colors: {
                transparent: "transparent",
                current: "currentColor",

                /* Surface Colors */
                surface: {
                    base: "var(--color-surface-base)",
                    muted: "var(--color-surface-muted)",
                    raised: "var(--color-surface-raised)",
                    strong: "var(--color-surface-strong)",
                },

                /* Text Colors */
                text: {
                    primary: "var(--color-text-primary)",
                    secondary: "var(--color-text-secondary)",
                    tertiary: "var(--color-text-tertiary)",
                    inverse: "var(--color-text-inverse)",
                },

                /* Interactive Colors */
                interactive: {
                    primary: "var(--color-interactive-primary)",
                    "primary-hover": "var(--color-interactive-primary-hover)",
                    "primary-active": "var(--color-interactive-primary-active)",
                    secondary: "var(--color-interactive-secondary)",
                    "secondary-hover":
                        "var(--color-interactive-secondary-hover)",
                    "secondary-active":
                        "var(--color-interactive-secondary-active)",
                },

                /* Feedback Colors */
                success: "var(--color-success)",
                "success-light": "var(--color-success-light)",
                error: "var(--color-error)",
                "error-light": "var(--color-error-light)",
                warning: "var(--color-warning)",
                "warning-light": "var(--color-warning-light)",
                info: "var(--color-info)",
                "info-light": "var(--color-info-light)",

                /* Utility Colors */
                focus: "var(--color-focus)",
                border: "var(--color-border)",
                "border-light": "var(--color-border-light)",
                "border-dark": "var(--color-border-dark)",
                disabled: "var(--color-disabled)",
                "disabled-bg": "var(--color-disabled-bg)",
            },

            /**
             * SPACING - Design System Integration
             */
            spacing: {
                1: "var(--space-1)",
                2: "var(--space-2)",
                3: "var(--space-3)",
                4: "var(--space-4)",
                5: "var(--space-5)",
                6: "var(--space-6)",
                7: "var(--space-7)",
                8: "var(--space-8)",
                12: "var(--space-12)",
                16: "var(--space-16)",
                20: "var(--space-20)",
                24: "var(--space-24)",
                32: "var(--space-32)",
                36: "var(--space-36)",
                40: "var(--space-40)",
                48: "var(--space-48)",
                52: "var(--space-52)",
                56: "var(--space-56)",
            },

            /**
             * BORDER RADIUS - Design System Integration
             */
            borderRadius: {
                xs: "var(--radius-xs)",
                sm: "var(--radius-sm)",
                md: "var(--radius-md)",
                lg: "var(--radius-lg)",
                xl: "var(--radius-xl)",
                full: "var(--radius-full)",
            },

            /**
             * SHADOW - Design System Integration
             */
            boxShadow: {
                none: "var(--shadow-none)",
                xs: "var(--shadow-xs)",
                sm: "var(--shadow-sm)",
                md: "var(--shadow-md)",
                lg: "var(--shadow-lg)",
                xl: "var(--shadow-xl)",
            },

            /**
             * ANIMATION - Design System Integration
             */
            transitionDuration: {
                instant: "var(--motion-instant)",
                fast: "var(--motion-fast)",
                normal: "var(--motion-normal)",
                slow: "var(--motion-slow)",
            },
            transitionTimingFunction: {
                linear: "var(--motion-easing-linear)",
                ease: "var(--motion-easing-ease)",
                "ease-in": "var(--motion-easing-ease-in)",
                "ease-out": "var(--motion-easing-ease-out)",
                "ease-in-out": "var(--motion-easing-ease-in-out)",
                cubic: "var(--motion-easing-cubic)",
            },

            /**
             * Z-INDEX - Design System Integration
             */
            zIndex: {
                dropdown: "var(--z-dropdown)",
                sticky: "var(--z-sticky)",
                fixed: "var(--z-fixed)",
                "modal-backdrop": "var(--z-modal-backdrop)",
                modal: "var(--z-modal)",
                popover: "var(--z-popover)",
                tooltip: "var(--z-tooltip)",
            },

            /**
             * CUSTOM UTILITIES FOR DESIGN SYSTEM
             */
            outlineWidth: {
                focus: "2px",
            },
            outlineOffset: {
                focus: "3px",
            },
        },
    },

    plugins: [forms],
};
