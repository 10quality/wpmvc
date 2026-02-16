---
slug: 2026-02-16-upgrade-to-v1.1.0
title: Upgrading from v1.0.8 to v1.1.0
authors: [amostajo]
tags: [wpmvc]
---

Guide to upgrade your project from `v1.0.8` to `v1.1.0`

<!-- truncate -->

Version `v1.1.0` of WordPress MVC (WPMVC) has been released!

This new version supports NodeJS < 24.x and npm < 11.x and includes some bug fixes and improvements to the documentation.


## Changelog

* Support for NodeJS < 24.x and npm < 11.x
* Handles deprecated SASS `@import` syntax in favor of `@use`

## Upgrade guide

To upgrade your project from `v1.0.8` to `v1.1.0`, follow these steps:

### Step 1: gulpfile.js

Change this line:
```js title="gulpfile.js"
var wpmvc = require('gulp-wpmvc');
```

To:
```js title="gulpfile.js"
var wpmvc = require('@10quality/gulp-wpmvc');
```

### Step 2: package.json

Change these lines:
```json title="package.json"
{
  "dependencies": {
    "gulp": "4.0.2",
    "gulp-wpmvc": "^1.3.*"
  }
}
```

To:
```json title="package.json"
{
  "scripts": {
    "build": "gulp build",
    "deploy": "gulp deploy",
    "dev": "gulp dev",
    "watch": "gulp watch"
  },
  "dependencies": {
    "@10quality/gulp-wpmvc": "1.4.0",
    "gulp": "4.0.2"
  }
}
```

### Step 3: SASS / SCSS

If you are using SASS / SCSS and have `@import` statements, change them to `@use` as follows:

```scss title="style.scss"
// Old syntax
@import 'parts/header';
// New syntax
@use 'parts/header';
```

### Step 4: Run npm install

Finally, run `npm install` to update your dependencies and complete the upgrade process.

```bash
npm install
```
