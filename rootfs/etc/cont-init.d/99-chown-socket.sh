#!/usr/bin/with-contenv bash

#
# since admin runs as nobody and clightning creates socket with rights only to root, we need to fix that
#

if [[ $CLIGHTNING_RPC_SOCKET != unix* ]]; then
    echo "not unix socket type, continuing"
    exit 0;
fi

SOCKET=${CLIGHTNING_RPC_SOCKET:7}
while [ 1 ]
do
    if [ -S $SOCKET ]; then
        chmod 777 $SOCKET
        exit 0;
    fi
    echo "no socket visible at $SOCKET, sleeping"
    sleep 1
done