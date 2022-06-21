## Installed Packages

- `laravel/breeze`
- `spatie/laravel-permission`
- `livewire/livewire`

## Laravel Mix

### Live Reload

#### Install

Don't install version 1 of the `webpack-livereload-plugin` like the Laravel Mix documents suggest.

```sh
npm install --save-dev webpack-livereload-plugin@3
```

#### Expose the Live Reload server

To use LiveReload with Sail, the LiveReload server needs to be exposed. Add the following to `docker-compose.yml`:

```yaml
ports:
  - 35729:35729
```

## Xdebug

- figure out the log path inside the docker container
- [Laravel Sail Debugging with Xdebug](https://laravel.com/docs/9.x/sail#debugging-with-xdebug)
- [Troubleshooting common PHP debugging issues](https://www.jetbrains.com/help/phpstorm/troubleshooting-php-debugging.html#debugger-cannot-connect)
- `telnet host 9003` to verify connection

## Git

- [Git stash](https://www.atlassian.com/git/tutorials/saving-changes/git-stash)

## Backblaze B2

- [ ] [Get a laravel storage disk setup with blackbaze](https://help.backblaze.com/hc/en-us/articles/217666928-Using-Backblaze-B2-with-the-Cloudflare-CDN)
