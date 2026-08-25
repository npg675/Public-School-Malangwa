<?php
/**
 * Stitch design-system head partial (Tailwind Play CDN + Material Symbols).
 * Loaded only on pages that set $useTailwind = true before including header.php.
 */
?>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<script>
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      "colors": {
        "on-tertiary-fixed-variant": "#604100",
        "surface-container-highest": "#d9e3fb",
        "on-surface": "#111c2d",
        "primary-fixed-dim": "#adc8f3",
        "tertiary-fixed-dim": "#f9bc51",
        "primary-fixed": "#d4e3ff",
        "on-tertiary": "#ffffff",
        "secondary-container": "#a3c5ff",
        "on-error": "#ffffff",
        "outline": "#74777f",
        "inverse-primary": "#adc8f3",
        "on-primary-fixed-variant": "#2c486c",
        "on-secondary": "#ffffff",
        "surface-container-high": "#dfe8ff",
        "surface-container-lowest": "#ffffff",
        "surface-tint": "#456085",
        "primary-container": "#092a4d",
        "secondary-fixed-dim": "#a8c8ff",
        "inverse-surface": "#273143",
        "surface-variant": "#d9e3fb",
        "on-tertiary-container": "#bc871f",
        "on-primary-container": "#7792bb",
        "on-error-container": "#93000a",
        "border-base": "#E2E8F0",
        "error-container": "#ffdad6",
        "primary": "#00152e",
        "alert-red": "#C1272D",
        "text-heading": "#172033",
        "bg-surface": "#F7F9FC",
        "surface": "#f9f9ff",
        "on-secondary-container": "#2d5184",
        "secondary-fixed": "#d5e3ff",
        "on-primary-fixed": "#001c3a",
        "outline-variant": "#c4c6cf",
        "active-gold": "#FFCC00",
        "background": "#f9f9ff",
        "surface-container-low": "#f0f3ff",
        "on-tertiary-fixed": "#281900",
        "inverse-on-surface": "#ecf0ff",
        "secondary": "#3c5f93",
        "on-primary": "#ffffff",
        "surface-dim": "#d0daf2",
        "masthead-navy": "#001E40",
        "surface-bright": "#f9f9ff",
        "surface-container": "#e8eeff",
        "on-background": "#111c2d",
        "tertiary": "#201300",
        "on-secondary-fixed": "#001b3c",
        "tertiary-container": "#3a2600",
        "on-secondary-fixed-variant": "#22477a",
        "tertiary-fixed": "#ffdeac",
        "on-surface-variant": "#43474e",
        "error": "#ba1a1a"
      },
      "borderRadius": { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
      "spacing": { "container-max": "1200px", "margin-desktop": "32px", "margin-mobile": "16px", "base": "4px", "gutter": "24px" },
      "fontFamily": {
        "headline-md": ["Hanken Grotesk"], "body-sm": ["Inter"], "label-lg": ["Inter"],
        "headline-lg": ["Hanken Grotesk"], "headline-sm": ["Hanken Grotesk"], "label-md": ["Inter"],
        "headline-lg-mobile": ["Hanken Grotesk"], "label-sm": ["Inter"], "body-lg": ["Inter"],
        "body-md": ["Inter"], "display-lg": ["Hanken Grotesk"]
      },
      "fontSize": {
        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
        "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
        "label-lg": ["16px", { "lineHeight": "24px", "fontWeight": "600" }],
        "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "600" }],
        "headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
        "label-md": ["14px", { "lineHeight": "20px", "fontWeight": "500" }],
        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
        "label-sm": ["12px", { "lineHeight": "16px", "fontWeight": "500" }],
        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }]
      }
    }
  }
}
</script>
<style>
  .soft-shadow { box-shadow: 0 4px 20px rgba(9, 42, 77, 0.06); }
  .shadow-ambient { box-shadow: 0 4px 12px rgba(9, 42, 77, 0.06); }
  .shadow-ambient-focus { box-shadow: 0 8px 24px rgba(9, 42, 77, 0.12); }
  .civic-shadow { box-shadow: 0 4px 12px rgba(9, 42, 77, 0.06); }
  .civic-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(9, 42, 77, 0.1); }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
