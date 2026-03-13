// @ts-check
// `@type` JSDoc annotations allow editor autocompletion and type checking
// (when paired with `@ts-check`).
// There are various equivalent ways to declare your Docusaurus config.
// See: https://docusaurus.io/docs/api/docusaurus-config

import {themes as prismThemes} from 'prism-react-renderer';
import 'dotenv/config';

/** @type {import('@docusaurus/types').Config} */
const config = {
  title: 'WordPress MVC framework (WPMVC)',
  tagline: 'The ultimate WordPress framework for custom Themes and Plugins development',
  favicon: 'img/favicon.ico',

  // Future flags, see https://docusaurus.io/docs/api/docusaurus-config#future
  future: {
    v4: true, // Improve compatibility with the upcoming Docusaurus v4
  },

  // Set the production url of your site here
  url: 'https://10quality.github.io',
  // Set the /<baseUrl>/ pathname under which your site is served
  // For GitHub pages deployment, it is often '/<projectName>/'
  baseUrl: process.env.BASE_URL || '/wpmvc/',

  // GitHub pages deployment config.
  // If you aren't using GitHub pages, you don't need these.
  organizationName: '10quality', // Usually your GitHub org/user name.
  projectName: 'wpmvc', // Usually your repo name.
  deploymentBranch: 'gh-pages',

  onBrokenLinks: 'throw',

  // Even if you don't use internationalization, you can use this field to set
  // useful metadata like html lang. For example, if your site is Chinese, you
  // may want to replace "en" with "zh-Hans".
  i18n: {
    defaultLocale: 'en',
    locales: ['en'],
  },

  presets: [
    [
      'classic',
      /** @type {import('@docusaurus/preset-classic').Options} */
      ({
        docs: {
          sidebarPath: './sidebars.js',
        },
        blog: {
          showReadingTime: true,
          feedOptions: {
            type: ['rss', 'atom'],
            xslt: true,
          },
          // Useful options to enforce blogging best practices
          onInlineTags: 'warn',
          onInlineAuthors: 'warn',
          onUntruncatedBlogPosts: 'warn',
        },
        theme: {
          customCss: './src/css/custom.css',
        },
      }),
    ],
  ],
  headTags: [
    // Declare some json-ld structured data
    {
      tagName: 'script',
      attributes: {
        type: 'application/ld+json',
      },
      innerHTML: JSON.stringify({
        '@context': 'https://schema.org/',
        '@type': 'SoftwareApplication',
        applicationCategory: 'Framework',
        applicationSuite: 'WordPress',
        downloadUrl: 'https://github.com/10quality/wpmvc',
        featureList: 'MVC, Code Generation, CLI, WordPress',
        softwareHelp: {
          '@type': 'CreativeWork',
          name: 'WordPress MVC Documentation',
          url: 'https://10quality.github.io/wpmvc/docs/intro',
        },
        softwareRequirements: 'Requires WordPress 5.8 or higher, Composer, PHP 7.4 or higher, Node.js',
        softwareVersion: '1.1.1',
        accessMode: 'textual',
        creator: {
          '@type': 'Organization',
          name: '10 Quality',
          legalName: '10 Quality Studio S.R.L.',
          address: 'San Jose, Costa Rica',
          url: 'https://10quality.studio',
        },
        educationalLevel: 'intermediate',
        name: 'WordPress MVC Framework',
        description: 'WordPress MVC is a powerful framework that brings the Model-View-Controller (MVC) architecture to WordPress development. It provides a structured and organized way to build custom themes and plugins, making it easier for developers to create maintainable and scalable WordPress applications.',
        url: 'https://10quality.github.io/wpmvc/',
        logo: 'https://github.com/10quality/wpmvc/blob/gh-pages/static/img/wpmvc-icon.jpg',
        image: 'https://github.com/10quality/wpmvc/blob/gh-pages/static/img/wpmvc-banner.jpg',
      }),
    },
  ],
  themes: ['@easyops-cn/docusaurus-search-local'],
  themeConfig:
    /** @type {import('@docusaurus/preset-classic').ThemeConfig} */
    ({
      // Replace with your project's social card
      image: 'img/wpmvc-banner.jpg',
      metadata: [
        {name: 'keywords', content: 'wpmvc, mvcgenerator, wordpress, framework, plugin, theme, development'},
      ],
      colorMode: {
        respectPrefersColorScheme: true,
      },
      navbar: {
        title: 'WordPress MVC',
        logo: {
          alt: 'WordPress MVC Logo',
          src: 'img/wpmvc-icon-blue.png',
        },
        items: [
          {
            type: 'docSidebar',
            sidebarId: 'tutorialSidebar',
            position: 'left',
            label: 'Docs',
          },
          {to: '/blog', label: 'Blog', position: 'left'},
          {
            href: 'https://github.com/10quality/wpmvc',
            label: 'GitHub',
            position: 'right',
          },
        ],
      },
      footer: {
        style: 'dark',
        links: [
          {
            title: 'Docs',
            items: [
              {
                label: 'Docs',
                to: '/docs/intro',
              },
            ],
          },
          {
            title: 'Community',
            items: [
              {
                label: 'LinkedIn',
                href: 'https://www.linkedin.com/company/10188132',
              },
            ],
          },
          {
            title: 'More',
            items: [
              {
                label: 'Blog',
                to: '/blog',
              },
              {
                label: 'GitHub',
                href: 'https://github.com/10quality/wpmvc',
              },
            ],
          },
        ],
        copyright: `Copyright © ${new Date().getFullYear()} 10 Quality Studio S.R.L. Built with Docusaurus.`,
      },
      prism: {
        theme: prismThemes.github,
        darkTheme: prismThemes.vsDark,
        additionalLanguages: ['php', 'bash', 'json'],
      },
      search: {
        // Optional config
        maxPreviewChars: 120,
        // hashed: true, // for cache busting
      },
    }),
};

export default config;
