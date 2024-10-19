# PHP Bandwidth Hero Proxy

> :warning: This is still very much work in progress. Any feedback is highly appreciated!

Alternative proxy for [Bandwidth Hero](https://bandwidth-hero.com/) browser extension written in PHP.

This service lowers your bandwidth usage by compressing images before they are sent to your device. You have to host the service on your home server, webhosting (works very well for me) or service like [Heroku](https://www.heroku.com/). [Docker](https://www.docker.com/) image coming soon.

No dependencies outside common PHP installation.

## Why?

> Necessity is the mother of invention

Our old webhosting doesn't support `node.js` and I'm lately working on moblie connection a lot, so any way to save some megabytes is welcome.

## Installation

- Clone this repository or download the source archive [here](https://github.com/staifa/php_bandwidth_hero_proxy/archive/refs/heads/main.zip)
- After unpacking the archive, copy all files and folders over ftp or drop them via your webhosting web gui to the root folder of your domain
- Wait for a bit for changes to settle

That's it! Now the easy part:

* Install the extension for your favourite browser
    * [Chrome](https://chromewebstore.google.com/detail/bandwidth-hero-live-image/mmhippoadkhcflebgghophicgldbahdb?pli=1)
    * [Firefox](https://addons.mozilla.org/en-US/firefox/addon/bandwidth-hero/)

* Find extension settings in your browser menu

![Extension settings](/../../../../staifa/readme-assets/blob/main/bhero1.jpeg)

* Find the `Configure data compression service` button under `Compression settings` menu option
* Paste a link to your compression service to the big

![Compression service settings](/../../../../staifa/readme-assets/blob/main/bhero2.jpeg)

## Configuration

There is no authorization switched on by default. There are 2 ways to set basic authentication with username and password

* Setting them in you system environment variables

    * [Windows](https://learn.microsoft.com/en-us/windows-server/administration/windows-commands/set_1)
    * Linux/MacOS

```Linux/MacOS
    export BHERO_LOGIN=yourusername
    export BHERO_PASSWORD=yourpassword
```


* Editing `config.php` file

Change these 2 lines

```php
    "auth_user" => $_ENV("BHERO_LOGIN"),
    "auth_password" => $_ENV("BHERO_PASSWORD"),
```

to

```php
    "auth_user" => "yourusername",
    "auth_password" => "yourpassword",
```

All other settings have same defaults and can be changed in the extension settings. Quality is set between 0 to 100, 40 being a default. Greyscale setting is available for even more bandwidth savings.

## Running locally

To run the service on your local computer:

* Be sure to have latest [PHP](https://www.php.net/) installed
* Open a terminal window and navigate to the service directory
* Run

```shell
php -S localhost:8000 index.php
```

* You'll now have the service running on your localhost on port `8000` as indicated by to log in your terminal

![Service log](/../../../../staifa/readme-assets/blob/main/bhero3.jpeg)

* To verify everything works, paste following link into your browser

```
http://localhost:8000/?url=https://raw.githubusercontent.com/PortsMaster/PortMaster-New/main/ports/half-life/screenshot.jpg
```

If you see crappy screenshot from Half-Life, congratulations!

![Victory!](/../../../../staifa/readme-assets/blob/main/bhero4.jpeg)

If not, feel free to [open an issue](https://github.com/staifa/php_bandwidth_hero_proxy/issues)!

## Running tests

* From project's root directory, go to `test` folder.
* Run

```shell
php test_runner.php
```

<a href="https://www.buymeacoffee.com/staifa" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-orange.png" alt="Buy Me A Coffee" height="41" width="174"></a>
