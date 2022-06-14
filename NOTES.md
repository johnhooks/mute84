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
