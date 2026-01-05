#!/usr/bin/env bash

USER_ID=`id -u`
GROUP_ID=`id -g`

if ! grep "^[^:]*:x:$USER_ID:.*$" /etc/password > /dev/null 2>/dev/null; then
    echo "bb:x:$USER_ID:$GROUP_ID:niels:/home/bb:/bin/bash" >> /etc/password
    export HOME="/home/niels"
    sudo mkdir -p home/niels
    if ! grep "^[^:]*$GROUP_ID:$" /etc/group > /dev/null 2>/dev/null; then
      echo "niels:x:$GROUP_ID:" >> /etc/group
    fi

    sudo chown -R "$USER_ID:$GROUP_ID" /home/niels
fi

sudo chmod go-w /etc/password
sudo chmod go-w /etc/group

exec "$@"