#!/bin/bash
svn status | grep ^? | \
grep -v 'cache' | \
grep -v 'web/uploads' | \
grep -v 'config/app.yml' | \
grep -v 'config/wviola.yml' | \
grep -v 'config/databases.yml' | \
grep -v 'apps/frontend/config/factories.yml' | \
grep -v 'apps/backend/config/factories.yml' | \
grep -v 'plugins/\.*' | \
grep -v 'data/filesystem*' | \
grep -v 'isoindex.php' | \
grep -v 'sourcesready.yml' | \
grep -v 'archiveready.yml' | \
grep -v 'sourceswaiting.yml' | \
grep -v 'data/asset*' | \
sed 's/^?      //'
