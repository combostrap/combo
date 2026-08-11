# Contrib

## Info

### Main Class

The main entrypoint is the [docustom.php action script](action/docustom.php). ie
(ie a `do` custom action) that takes over action such as `show` (default).

### Dependencies Declaration

The dependencies are not in [plugins info](plugin.info.txt) but online in the `dependents`
property of the [Combo Plugin page](https://www.dokuwiki.org/plugin:combo)

It's used by the [new installer](https://www.patreon.com/posts/new-extension-116501986)

## How To

* [How to install a new Laptop Dev Environment](contrib/docs/install.md)
* [Release](contrib/docs/release.md)

### Start it with the combostrap dokuwiki docker image

```bash
docker run \
  --name combo \
  -d \
  -p 8082:80 \
  --user 1000:1000 \
  -e DOKU_DOCKER_ENV=dev \
  -e DOKU_DOCKER_ACL_POLICY='public' \
  -e DOKU_DOCKER_ADMIN_NAME='admin' \
  -e DOKU_DOCKER_ADMIN_PASSWORD='welcome' \
  -v $PWD:/var/www/html \
  ghcr.io/combostrap/dokuwiki:php8.3-latest
```


