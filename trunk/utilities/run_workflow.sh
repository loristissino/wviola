#!/bin/bash
utilities/reload.sh
symfony wviola:scan-sources --recursive=true --application=frontend 
symfony wviola:schedule-asset --user=matthew --binder=Spring --subdir=videos --file=bigbuckbunny02.mpeg --thumbnail=1 --application=frontend
symfony wviola:publish-assets --application=frontend
