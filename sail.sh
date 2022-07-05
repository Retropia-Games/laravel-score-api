#!/bin/sh
echo "This is just a shortcut to sail command 👀"
COMMAND="$(dirname $0)/vendor/bin/sail $@"
eval "$COMMAND"
