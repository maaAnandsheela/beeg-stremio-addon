# beeg-stremio-addon


This is a [Stremio](https://www.stremio.com/) add-on for , [beeg.](https://beeg.com/).

It is a php and apache app and can be run on major free hosting service.

Demo : https://stremio.eu-gb.mybluemix.net/manifest.json

## Features

- Includes custom Configuration for most of the things.
- Includes Home Feed of beeg.com on discover tab of stremio and various other tags of beeg which can be configured before deploying.
- Supports Docker Installation.
- Searching in beeg.com catalog.
- Caching the requests in file cache.
- Since its php and apache app can be deployed on any free hosting with cloudflare to support free ssl.
- Includes Procfile to support heroku. So can be deployed on heroku.
- Custom cache time for feed and meta content.

## Deploying with Docker (preferred for localhost)

To Run on Docker Container

```bash
git clone https://github.com/maaAnandsheela/beeg-stremio-addon
cd beeg-stremio-addon
docker build -t beeg-stremio .
docker run --name beegs -d -p 80:80 beeg-stremio
```

To Stop the container

```bash
docker stop beegs
```

## Deploying on other free hosts

Preffered host [Infinityfree](https://infinityfree.net/) as it supports clouflare in its cpanel. (tested)

- Download the files from github as zip and extract it on the the server using ftp or file manager in cpanel.


## Configuration 

- Includes a config.php to config the default variables before setup.
- `cache_status` to define cacahe status.
- `cache_path`  to define file cache path.
- `cache_catalog_ttl` expire time for catalog feeds cache and also valid for genres.
- `catalog_catalog_ttl` expire time for meta of cahe streams.
- `$tags_catalog` array which determines the number of tags for the feeds on discover and board of stremio app.
- And other basic manifest variables can also be configured from config.php

## Known Issues

- Video Streams won't work on browser version of stremio due to beeg.com preventing forgery of videos due to referrer header.
- Include vendor folder due to docker issues doesn't require composer install.

## Screenshots

![Screenshot](/captures/screenshot1.png)

![Screenshot](/captures/screenshot2.png)

![Screenshot](/captures/screenshot3.png)
