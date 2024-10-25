<img alt="GitHub Actions Workflow Status" src="https://img.shields.io/github/actions/workflow/status/staifa/php_bandwidth_hero_proxy/php.yml?style=for-the-badge&logoSize=100">

# PHP Bandwidth Hero Proxy

> :warning: Work in progress. Any feedback is highly appreciated!

Alternative proxy for [Bandwidth Hero](https://bandwidth-hero.com/) browser extension written in PHP.
[Original node.js service](https://github.com/ayastreb/bandwidth-hero-proxy)
[Frontend](https://github.com/ayastreb/bandwidth-hero)

This service lowers your bandwidth usage by compressing images before they are sent to your device. You have to host the service on your home server, webhosting (works very well for me) or service like [Heroku](https://www.heroku.com/).
It's not an anonymization proxy.

## Why?

> Necessity is the mother of invention

Our old webhosting doesn't support `node.js` and I'm currently working on moblie connection a lot, so I welcome any way to save some megabytes here and there.

PHP itself brings some new possibilities to the table too. It's nice to have options to choose from.

## Demo

![Demo](/../../../../staifa/readme-assets/blob/main/sbhero8.gif)

## Installation

### Docker

* Pull the app image from [dockerhub](https://hub.docker.com/r/staifa/php-bandwidth-hero-proxy)
    ```
    docker pull staifa/php-bandwidth-hero-proxy
    ```

* Or build it by running following command in the root folder of this project
    ```
    docker build -t php-bandwidth-hero-proxy .
    ```

* then run it
    * without basic authorization
        ```
        docker run -p 9696:8000 --name php-bandwidth-hero-proxy php-bandwidth-hero-proxy
        ```
    * or preferably with authorization credentials passed as env variables
        ```
        docker run -p 9696:8000 -e BHERO_LOGIN='username' -e BHERO_PASSWORD='password' --name php-bandwidth-hero-proxy php-bandwidth-hero-proxy
        ```
    * and verify that the service is running by pasting following link into web browser. Don't forget to add auth header if needed.
        ```
        http://localhost:9696/?url=https://1gr.cz/o/sph/mask-map3.png&l=20
        ```

### Manual setup

- Clone this repository or download the source archive [here](https://github.com/staifa/php_bandwidth_hero_proxy/archive/refs/heads/main.zip)
- After unpacking the archive, copy all files and folders over ftp or drop them via your webhosting web gui to the root folder of your domain
- Wait for a bit for changes to settle

### Browser extension setup

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

  Change following lines
  
            "auth_user" => $_ENV("BHERO_LOGIN"),
            "auth_password" => $_ENV("BHERO_PASSWORD"),
    
  to
  
            "auth_user" => "yourusername",
            "auth_password" => "yourpassword",

All other settings have same defaults and can be changed in the extension settings. Quality is set between 0 to 100, 40 being a default. Greyscale setting is available for even more bandwidth savings.

## Running locally

To run the service on your local machina:
* Be sure to have latest [php](https://www.php.net/) installed
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

* From project's root directory, go to `test` folder and run
    ```shell
    php test_runner.php
    ```

* Or use Docker
    ```
    docker exec --workdir /usr/src/app/test php-bandwidth-hero-proxy php test_runner.php
    ```

<a href="https://www.buymeacoffee.com/staifa" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-orange.png" alt="Buy Me A Coffee" height="41" width="174"></a>
