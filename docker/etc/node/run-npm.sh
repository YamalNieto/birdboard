#!/usr/bin/env bash

# https://docs.npmjs.com/resolving-eacces-permissions-errors-when-installing-packages-globally
source ~/.profile

npm install npm@latest -g
npm install
npm run watch-poll