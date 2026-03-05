---
slug: 2026-03-05-upgrade-to-v1.1.1
title: Upgrading from v1.1.0 to v1.1.1
authors: [amostajo]
tags: [wpmvc]
---

Guide to upgrade your project from `v1.1.0` to `v1.1.1`

<!-- truncate -->

Version `v1.1.1` of WordPress MVC (WPMVC) has been released!

This new version multiple framework builds using the latest composer builds.

## Changelog

* Added composer `autoloader-suffix` support to handle multiple framework instances on newer composer builds.

## Upgrade guide

To upgrade your project from `v1.1.0` to `v1.1.1`, follow this step:

### Step 1: composer.json

Add this line inside the `"config"` section:
```json title="composer.json"
"autoloader-suffix": "MyApp",
```

Replace `"MyApp"` with your current namespace, for example if your namespace is `"MyAwesomePlugin"`, it should look like this:
```json title="composer.json"
"autoloader-suffix": "MyAwesomePlugin",
```

The whole `"config"` section should look like this:
```json
"config": {
    "autoloader-suffix": "MyAwesomePlugin",
    "optimize-autoloader": true,
    "sort-packages": true
},
```

### Step 2: Dumb autoloader

Run the following command to dump the current autoloader:
```bash
composer dump-autoloader
```
