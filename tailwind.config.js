/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    '!./node_modules/**',
    '!./vendor/**',
  ],
  theme: {
    extend: {
      colors: {
        // ── Ink scale (dark backgrounds)
        ink: {
          DEFAULT: '#090F1A',
          light:   '#141B27',
          mid:     '#1C2325',
        },
        slate:  '#2A3C38',
        steel:  '#445278',
        muted:  '#687384',
        soft:   '#949AC2',
        cloud:  '#C8D2D6',
        fog:    '#C8D2F4',
        paper:  '#F4F6F3',
        // ── Accent (emerald-teal)
        accent: {
          DEFAULT: '#00D4A4',
          bright:  '#00FFD0',
          dim:     '#008070',
          teal:    '#007C82',
          navy:    '#071248',
        },
      },
      fontFamily: {
        sans:    ['"DM Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        display: ['Syne', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        // Match Figma type scale
        label: ['11px', { lineHeight: '1', letterSpacing: '0.1em' }],
        sm:    ['14px', { lineHeight: '1.5' }],
        base:  ['16px', { lineHeight: '1.6' }],
        lg:    ['18px', { lineHeight: '1.5' }],
        xl:    ['20px', { lineHeight: '1.4' }],
        '2xl': ['24px', { lineHeight: '1.3' }],
        '3xl': ['32px', { lineHeight: '1.2' }],
        '4xl': ['40px', { lineHeight: '1.1' }],
        '5xl': ['56px', { lineHeight: '1.05' }],
      },
      maxWidth: {
        site: '1200px',
      },
      spacing: {
        // Figma spacing scale
        xs:  '4px',
        sm:  '8px',
        md:  '16px',
        lg:  '24px',
        xl:  '40px',
        '2xl': '64px',
        '3xl': '96px',
        '4xl': '144px',
      },
      borderRadius: {
        notch: '10px', // mechanical notch on buttons/chips
        tag:   '8px',  // tags & small elements
      },
      backgroundImage: {
        'dot-grid': 'radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px)',
      },
      backgroundSize: {
        'dot-24': '24px 24px',
      },
      typography: (theme) => ({
        DEFAULT: {
          css: {
            color: theme('colors.muted'),
            a: { color: theme('colors.accent.DEFAULT') },
            'h1,h2,h3,h4': { fontFamily: 'Syne, sans-serif', color: theme('colors.ink.DEFAULT') },
          },
        },
        invert: {
          css: {
            color: theme('colors.cloud'),
            'h1,h2,h3,h4': { color: '#ffffff' },
          },
        },
      }),
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
