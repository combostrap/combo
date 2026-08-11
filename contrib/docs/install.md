# How to install a new Laptop Dev Environment

## Install PHP

* Install php7.4 on debian with
  the [sury repo](https://github.com/oerdnj/deb.sury.org/wiki/Frequently-Asked-Questions#how-to-enable-the-debsuryorg-repository)
* https://packages.sury.org/php/pool/main/p/php7.4/

```bash
curl -sSL https://packages.sury.org/php/README.txt | sudo bash -x
sudo apt update
sudo apt install -y php8.2 \
  php8.2-mbstring \
  php8.2-xml \
  php8.2-gd \
  php8.2-intl \
  php8.2-curl \
  php8.2-xdebug \
  php8.2-pdo-sqlite
# openssl not found
# curl is needed for snapshot
which php8.2 # /usr/bin/php8.2
# ini
cat /etc/php/8.2/cli/php.ini
cat /etc/php/8.2/mods-available/xdebug.ini
```

## Clone dokuwiki

* Clone Dokuwiki to get:
    * the base `_test\core\DokuWikiTest` class
    * and `_test\phpunit.xml`

```bash
git clone https://github.com/dokuwiki/dokuwiki combo
cd combo
git checkout stable
```

## Clone Combo

```bash
cd dokuwiki_home/lib/plugins/
git clone git@github.com:ComboStrap/combo
```

## Clone the dependent plugins

* Clone the dependent plugins found in [requirements](requirements.txt)

```bash
cd dokuwiki_home/lib/plugins/
git clone https://github.com/cosmocode/sqlite sqlite
git clone https://github.com/michitux/dokuwiki-plugin-move/ move
git clone https://github.com/dokufreaks/plugin-include include
git clone https://github.com/tatewake/dokuwiki-plugin-googleanalytics googleanalytics
git clone https://github.com/alexlehm/dokuwiki-plugin-gtm googletagmanager
```

## Clone the tests

If you are from the combostrap organisation:

```bash
cd dokuwiki_home/lib/plugins/combo
git clone git@github.com:ComboStrap/combo_test.git _test
```

## Install Node dependency

```bash
cd dokuwiki_home/lib/plugins/combo
npm install
```

## Install phpunit

```bash
cd dokuwiki_home/_test
composer install
```

## Intellij Php Configuration on WSL

* Git
    * add `lib/plugins/combo` as a registered root (Intellij> Version Control > Directory Mapping)
    * Check that Set it as a source root

Following [](https://www.jetbrains.com/help/phpstorm/how-to-use-wsl-development-environment-in-product.html#open-a-project-in-wsl)

* Install the plugin PHP Remote Interpreter (for WSL Support)
* Add Php Cli Interpreter on WSL. Intellij > Settings > Php > Cli Interpreter
* Firewall from an elevated PowerShell

```powershell
New-NetFirewallRule -DisplayName "WSL" -Direction Inbound  -InterfaceAlias "vEthernet (WSL (Hyper-V firewall))"  -Action Allow
Get-NetFirewallProfile -Name Public | Get-NetFirewallRule | where DisplayName -ILike "IntelliJ IDEA*" | Disable-NetFirewallRule
```

* Intellij > Settings > Php > Test Framework

```yaml
Use_autoloader: dokuwiki_home/lib/plugins/combo/vendor/autoload.php
Use_default_configuration_file: combo/_test/phpunit.xml
Use_default_bootstrap_file: combo/lib/plugins/combo/_test/bootstrap.php
```

* Intellij Test Runner Configuration

```yaml
Use_alternative_configuration_file: combo/_test/phpunit.xml
Use_alternative_bootstrap_file: combo/lib/plugins/combo/_test/bootstrap.php
Interpreter_cli: use wsl
Interpreter_options: |
    # put this ip if you are not in mirrored mode and intellij keep using 127.0.0.1
    -dxdebug.client_host=$(echo $(ip route list default | awk '{print $3}'))
```
