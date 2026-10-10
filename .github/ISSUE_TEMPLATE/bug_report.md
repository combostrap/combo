---
name: Bug report
about: Report something that isn't working
title: "[Bug] "
labels: bug
assignees: ""
---

## Prerequisite - How to provide a reproducible environment

DokuWiki is pretty difficult to debug because it's:

* based on php that have many distribution and environment
* it allows to have many plugins and configuration

To be able to reproduce quickly an error, we provide
[a test/demo environment called the starter](https://github.com/combostrap/site-starter).

The bug should be reproducible in this environment.

Steps:

* fork the [starter repo](https://github.com/combostrap/site-starter)
* clone your fork

```bash
git clone git@github.com:your-org/site-starter-issue
```

* change or copy the [configuration file](https://github.com/combostrap/site-starter/blob/main/conf) (
  mainly [local.php](https://github.com/combostrap/site-starter/blob/main/conf/local.php))
* start it

```markdown
docker run \
--name combo-site-starter \
--rm \
-p 8081:80 \
--user 1000:1000 \
-e DOKU_DOCKER_ENV=dev \
-e DOKU_DOCKER_ACL_POLICY='public' \
-e DOKU_DOCKER_ADMIN_NAME='admin' \
-e DOKU_DOCKER_ADMIN_PASSWORD='welcome' \
-v $PWD:/var/www/html \
ghcr.io/combostrap/dokuwiki:php8.3-latest
```

* validate the bug at `http://localhost:8081`,
* you can log in at [http://localhost:8081?do=login](http://localhost:8081?do=login) with `admin`/`welcome`
* if the bug is validated, paste the link to your fork in this issue.

## Description

A clear description of the problem.

## Expected behavior

## Actual behavior
