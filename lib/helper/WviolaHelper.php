<?php

function human_readable_size($size)
{
  return Generic::getHumanReadableSize($size);
}

function url_for_backend($name, $parameters)
{
  return sfProjectConfiguration::getActive()->generateBackendUrl($name, $parameters);
}

function url_for_frontend($name, $parameters)
{
  return sfProjectConfiguration::getActive()->generateFrontendUrl($name, $parameters);
}