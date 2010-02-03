#!/bin/bash
svn status | grep ^? | \
grep -v 'cache' | \
grep -v 'web/uploads' | \
grep -v 'web/images/sources' | \
grep -v 'apps/frontend/config/app.yml' | \
grep -v 'apps/backend/config/app.yml' | \
grep -v 'config/app.yml' | \
grep -v 'apps/frontend/config/factories.yml' | \
grep -v 'apps/backend/config/factories.yml' | \
grep -v 'config/databases.yml' | \
grep -v 'plugins/\.*' | \
sed 's/^?      //'
