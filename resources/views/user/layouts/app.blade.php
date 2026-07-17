<!DOCTYPE html>
<html class="light" lang="id" style="">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard Layanan - Dinas Kominfo Murung Raya</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Tailwind Config -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container": "#e5eeff",
                        "surface-container-low": "#eff4ff",
                        "on-primary": "#ffffff",
                        "border-subtle": "#E2E8F0",
                        "on-surface-variant": "#43474f",
                        "surface-container-highest": "#d3e4fe",
                        "primary-fixed": "#d5e3ff",
                        "on-tertiary-fixed-variant": "#723610",
                        "on-tertiary-fixed": "#341100",
                        "background": "#f8f9ff",
                        "on-secondary-fixed-variant": "#5d4201",
                        "tertiary": "#381300",
                        "inverse-on-surface": "#eaf1ff",
                        "status-pending": "#D97706",
                        "on-secondary": "#ffffff",
                        "primary-fixed-dim": "#a7c8ff",
                        "error": "#ba1a1a",
                        "on-surface": "#0b1c30",
                        "surface-bright": "#f8f9ff",
                        "on-error-container": "#93000a",
                        "on-error": "#ffffff",
                        "primary": "#001e40",
                        "surface-gray": "#F8FAFC",
                        "error-container": "#ffdad6",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed-dim": "#ffb690",
                        "secondary-container": "#fed488",
                        "primary-container": "#003366",
                        "surface-container-lowest": "#ffffff",
                        "surface-variant": "#d3e4fe",
                        "secondary-fixed": "#ffdea5",
                        "on-primary-fixed": "#001b3c",
                        "tertiary-fixed": "#ffdbca",
                        "on-primary-container": "#799dd6",
                        "on-background": "#0b1c30",
                        "on-secondary-container": "#785a1a",
                        "on-secondary-fixed": "#261900",
                        "tertiary-container": "#592300",
                        "surface": "#f8f9ff",
                        "inverse-primary": "#a7c8ff",
                        "surface-tint": "#3a5f94",
                        "inverse-surface": "#213145",
                        "outline-variant": "#c3c6d1",
                        "surface-container-high": "#dce9ff",
                        "secondary-fixed-dim": "#e9c176",
                        "success-emerald": "#059669",
                        "secondary": "#775a19",
                        "outline": "#737780",
                        "on-tertiary-container": "#d8885c",
                        "surface-dim": "#cbdbf5",
                        "on-primary-fixed-variant": "#1f477b"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "container-max": "1280px",
                        "margin-mobile": "16px",
                        "margin-desktop": "40px",
                        "base": "8px"
                    },
                    "fontFamily": {
                        "headline-lg-mobile": ["Inter"],
                        "body-md": ["Inter"],
                        "headline-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-xl": ["Inter"],
                        "label-sm": ["Inter"],
                        "caption": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg-mobile": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "700"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }],
                        "headline-md": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "label-md": ["14px", {
                            "lineHeight": "20px",
                            "letterSpacing": "0.01em",
                            "fontWeight": "600"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "28px",
                            "fontWeight": "400"
                        }],
                        "headline-xl": ["40px", {
                            "lineHeight": "48px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "label-sm": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.02em",
                            "fontWeight": "500"
                        }],
                        "caption": ["12px", {
                            "lineHeight": "16px",
                            "fontWeight": "400"
                        }]
                    }
                }
            }
        }
    </script>
    <!-- Tailwind Setup -->

<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "on-primary-fixed-variant": "#1f477b",
                      "inverse-surface": "#213145",
                      "surface": "#f8f9ff",
                      "status-pending": "#D97706",
                      "success-emerald": "#059669",
                      "secondary-fixed": "#ffdea5",
                      "surface-bright": "#f8f9ff",
                      "error-container": "#ffdad6",
                      "secondary-container": "#fed488",
                      "inverse-on-surface": "#eaf1ff",
                      "tertiary-container": "#592300",
                      "on-secondary-fixed-variant": "#5d4201",
                      "on-error": "#ffffff",
                      "on-error-container": "#93000a",
                      "tertiary": "#381300",
                      "on-tertiary-fixed-variant": "#723610",
                      "surface-container-highest": "#d3e4fe",
                      "primary-fixed-dim": "#a7c8ff",
                      "on-primary-container": "#799dd6",
                      "secondary": "#775a19",
                      "surface-variant": "#d3e4fe",
                      "secondary-fixed-dim": "#e9c176",
                      "outline": "#737780",
                      "primary": "#001e40",
                      "on-tertiary-container": "#d8885c",
                      "on-tertiary": "#ffffff",
                      "background": "#f8f9ff",
                      "on-secondary": "#ffffff",
                      "on-primary-fixed": "#001b3c",
                      "on-primary": "#ffffff",
                      "surface-container": "#e5eeff",
                      "on-surface-variant": "#43474f",
                      "error": "#ba1a1a",
                      "on-secondary-container": "#785a1a",
                      "on-background": "#0b1c30",
                      "surface-container-lowest": "#ffffff",
                      "border-subtle": "#E2E8F0",
                      "surface-container-low": "#eff4ff",
                      "tertiary-fixed-dim": "#ffb690",
                      "surface-dim": "#cbdbf5",
                      "surface-container-high": "#dce9ff",
                      "on-surface": "#0b1c30",
                      "outline-variant": "#c3c6d1",
                      "tertiary-fixed": "#ffdbca",
                      "primary-container": "#003366",
                      "primary-fixed": "#d5e3ff",
                      "surface-gray": "#F8FAFC",
                      "surface-tint": "#3a5f94",
                      "on-secondary-fixed": "#261900",
                      "inverse-primary": "#a7c8ff",
                      "on-tertiary-fixed": "#341100"
              },
              "borderRadius": {
                      "DEFAULT": "0.125rem",
                      "lg": "0.25rem",
                      "xl": "0.5rem",
                      "full": "0.75rem"
              },
              "spacing": {
                      "margin-mobile": "16px",
                      "gutter": "24px",
                      "margin-desktop": "40px",
                      "container-max": "1280px",
                      "base": "8px"
              },
              "fontFamily": {
                      "label-md": ["Inter", "sans-serif"],
                      "body-md": ["Inter", "sans-serif"],
                      "caption": ["Inter", "sans-serif"],
                      "headline-xl": ["Inter", "sans-serif"],
                      "headline-lg-mobile": ["Inter", "sans-serif"],
                      "headline-lg": ["Inter", "sans-serif"],
                      "body-lg": ["Inter", "sans-serif"],
                      "label-sm": ["Inter", "sans-serif"],
                      "headline-md": ["Inter", "sans-serif"]
              },
              "fontSize": {
                      "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                      "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                      "caption": ["12px", {"lineHeight": "16px", "fontWeight": "400"}],
                      "headline-xl": ["40px", {"lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                      "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "700"}],
                      "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                      "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                      "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "500"}],
                      "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}]
              }
            }
          }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>


<body class="bg-background text-on-background font-body-md text-body-md h-screen flex overflow-hidden">
    
    <!-- SideBar -->
    @include('user.partial.sidebar')
    <!-- Main Content -->
    <main class="flex-1 md:ml-[280px] h-full overflow-y-auto pt-[80px] md:pt-0 bg-surface-bright relative">
        @include('user.partial.header')
        @yield('content')
        <!-- Footer Spacer -->
         @include('user.partial.footer')
    </main>
    
</body>  
</html>
