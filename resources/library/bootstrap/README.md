# Bootstrap

## About

This directory contains all `Bootstrap` related resources such as JavaScript and CSS files used
by [ComboStrap](https://combostrap.com)

If you want to bring your own custom Css file, check
the [custom Bootstrap article](https://combowiki.combostrap.com/custom/bootrstap)

In a nutshell, if you already have your CSS file:

* Copy your CSS file into the sub version directory (`4.4.1`, `4.5.0`, ...)
* Copy the [bootstrapCustomCss.json](./bootstrapStylesheet.json) to `bootstrapLocalCss.json`
* And adapt the file by changing or adding your values

## Files

* `bootstrapxxx.json` is a metadata file with all official bootstrap information
* [bootstrapCustom.json] is a metadata file with the [ComboStrap](https://combostrap.com) 16 grid theme.
* There is one subdirectory by `Bootstrap` release such as [4.5.0](./4.5.0)

## Jquery

Jquery must not be slim because the `post` http method is needed for the search box (`qsearch`)

## Steps

* Go to:
  * https://www.jsdelivr.com/package/npm/bootstrap and choose the version to add
  * or to https://getbootstrap.com/docs/5.3/getting-started/introduction/ and choose the popper/bootstrap tags
* Takes the URL and SRI of
  * bootstrap.min.js
  * popper.min.js - needed for the search box
  * bootstrap.min.css
  * and bootstrap.rtl.min.css
* Writes them in:
  * [bootstrapJavascript.json](bootstrapJavascript.json)
  * and [bootstrapStylesheet.json](bootstrapStylesheet.json)
* Create the version subdirectory and download the files. Example:

```bash
curl -L -o bootstrap.min.js \
  https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js
curl -L -o bootstrap.min.css \
  https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css
curl -L -o bootstrap.rtl.min.css \
  https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css
curl -L -o popper.min.js \
  https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js
```

