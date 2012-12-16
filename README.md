# Kiosk

_Bookmarks sharing. Anytime. Anywhere._

Current Version: **0.2**

Kiosk helps sharing web pages between collaborators by generating a common RSS feed. The contribution is managed thanks to API keys and requires no peculiar install or configuration client-side other than a bookmarklet.

Kiosk features an optional IRC bot which intercepts `!pr <url>` on a given channel.

Note that there is no user interface enabling to manage shared pages.

![Bookmarklet Kiosk 0.2](http://imgs.be/50aedf70-2028.png)
![RSS feed in Firefox Kiosk 0.2](http://imgs.be/50aedfae-380.png)

## Installation and configuration

Upload the `/kiosk/` folder to your webserver.

Edit the following files:

* `includes/config.php`
* `bookmarklet.js` (L22, edit path and key)

### (optional) IRC bot

Edit `bot.php` and run the following command in your shell:

    screen -S BotsName php bot.php

## Licence

Copyright &copy; 2012 André LOCONTE

This program is free software: you can redistribute it and/or modify it under the terms of the [GNU Affero General Public License](https://gnu.org/licenses/agpl.html) as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.