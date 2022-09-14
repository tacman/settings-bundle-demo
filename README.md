# settings-demo
A simple app showing integration with tzunghaor/settings-bundle

The default database is sqlite, change .env.local to use another DATABASE_URL

The project: Joksters

Jokers is a site for people to create joke-themed pages, e.g. golf jokes, and for others to "subscribe" to those pages.

Each themed joke site is a "project", the person who creates the project is the manager and can configure the tagline (and content).

Users can view these projects and configure their experience, like wanting the project to appear on their home page.

Site administrators (ROLE_ADMIN) can configure the site title, version, and welcome message.

One approach is to add the settings to the individual record.  That is, the project record could have a title and tagline, the UserSubscriber record could ahve the "add to favorites" tag, etc.  But this creates a lot of horizontal fields.  Settings bundle adds the overridden properties to a table without cluttering up the entity record.

```bash
git clone git@github.com:tacman/settings-bundle-demo
cd settings-bundle-demo
composer install
bin/console doctrine:schema:update --force
npm install
npm run build
symfony server:start
```

Go to /settings/edit

For Symfony 6, use:

composer config repositories.settings '{"type": "vcs", "url": "git@github.com:tacman/settings-bundle"}'
composer req tzunghaor/settings-bundle:dev-tac
