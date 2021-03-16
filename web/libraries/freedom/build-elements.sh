#!/bin/sh

ELEM_1="freedom";

ng build $ELEM_1 --prod \
  --output-hashing=none && \
  cat ./dist/$ELEM_1/runtime.js ./dist/$ELEM_1/polyfills.js ./dist/$ELEM_1/scripts.js ./dist/$ELEM_1/main.js > ./dist/$ELEM_1.js
