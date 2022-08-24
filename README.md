# settings-demo
A simple app showing integration with tzunghaor/settings-bundle

The default database is sqlite, change .env.local to use another DATABASE_URL

```bash
git clone git@github.com:tacman/settings-demo
cd settings-demo
composer install
bin/console doctrine:schema:update --force
symfony server:start
```

Go to /settings/edit

For Symfony 6, use:

composer config repositories.settings '{"type": "vcs", "url": "git@github.com:tacman/settings-bundle"}'
composer req tzunghaor/settings-bundle:dev-tac
