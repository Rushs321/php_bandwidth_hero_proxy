<img alt="GitHub Actions Workflow Status" src="https://img.shields.io/github/actions/workflow/status/staifa/php_bandwidth_hero_proxy/php.yml?style=for-the-badge&logoSize=100">

# PHP Bandwidth Hero Proxy

> :warning: Work in progress. Any feedback is highly appreciated!

Alternative proxy for [Bandwidth Hero](https://bandwidth-hero.com/) browser extension written in PHP.

This service lowers your bandwidth usage by compressing images before they are sent to your device. You have to host the service on your home server, webhosting (works very well for me) or service like [Heroku](https://www.heroku.com/). [Docker](https://www.docker.com/) image coming soon.

No dependencies outside common PHP installation.

## Why?

> Necessity is the mother of invention

Our old webhosting doesn't support `node.js` and I'm lately working on moblie connection a lot, so any way to save some megabytes is welcome.

PHP also brings the advantage of being able to run the service on all webhostings that support it (they all do). No need for Heroku and similar services. It's lightweight and much less complicated to run and maintain. Node shines on parallelised infrastructure with high traffic whereas PHP is more suited for personal proxy used by you, your family and few friends. It's nice to have options to choose from.

## Demo

![Demo](/../../../../staifa/readme-assets/blob/main/sbhero8.gif)

## Installation

### Docker

Pull the app image from [dockerhub](https://hub.docker.com/r/staifa/php-bandwidth-hero-proxy)

```
docker pull staifa/php-bandwidth-hero-proxy
```

Or build it yourself

```
docker build -t php-bandwidth-hero-proxy .
```

then run it

```
docker run -p 9696:8000 --name php-bandwidth-hero-proxy php-bandwidth-hero-proxy
```

and verify that the service is running by pasting following link into web browser

```
http://localhost:9696/?url=https://1gr.cz/o/sph/mask-map3.png&l=20
```

### Manual setup

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

or use docker

```
docker exec --workdir /usr/src/app/test php-bandwidth-hero-proxy php test_runner.php
```

<a href="https://www.buymeacoffee.com/staifa" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-orange.png" alt="Buy Me A Coffee" height="41" width="174"></a>
